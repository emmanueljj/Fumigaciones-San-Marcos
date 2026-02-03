<?php

namespace App\Http\Controllers;

use App\Models\Empresas;
use App\Models\Servicio;
use App\Models\Meses;
use App\Models\Actividades; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Exception;

class ActividadesController extends Controller
{
    // --- MÉTODOS DE VISTA ---

    public function verActividades($id_servicio) {
        $servicio = Servicio::findOrFail($id_servicio);
        $actividades = Actividades::where('id_servicio', $id_servicio)->get();
        
        $mes = Meses::findOrFail($servicio->id_mes);
        $empresa = Empresas::findOrFail($mes->id_empresa);
        $id_mes = $servicio->id_mes;

        return view('actividades', compact('actividades', 'id_mes', 'empresa', 'id_servicio'));
    }

    public function ag_actividades($id_servicio, Request $request) {
        $id_mes = $request->query('id_mes');
        $id_empresa = $request->query('id_empresa');
        $empresa = Empresas::findOrFail($id_empresa);

        return view('agregar.agActividades', compact('id_servicio', 'id_mes', 'empresa'));
    }

    public function edActividad($id, $id_empresa, $id_mes, $id_servicio) {
        $actividad = Actividades::findOrFail($id);
        $empresa = Empresas::findOrFail($id_empresa);
        return view('editar.edActividades', compact('actividad', 'empresa', 'id_empresa', 'id_mes', 'id_servicio'));
    }


    // --- MÉTODOS DE ACCIÓN ---

    public function addActividad(Request $request) {
        try {
            $datos = $this->validarYProcesar($request);
            Actividades::create($datos);

            return redirect('/actividades/' . $request->id_servicio)
                ->with('success', 'Actividad registrada con éxito.');

        } catch (ValidationException $e) {
            return $this->errorValidacion($e);
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('errorMensaje', $e->getMessage())->with('mostrarModal', true);
        }
    }

    public function updateAct(Request $request, $id) {
        try {
            $actividad = Actividades::findOrFail($id);
            $datos = $this->validarYProcesar($request, $actividad);

            $actividad->update($datos);

            return redirect('/actividades/' . $actividad->id_servicio)
                ->with('success', 'Actividad actualizada con éxito.');

        } catch (ValidationException $e) {
            return $this->errorValidacion($e);
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('errorMensaje', $e->getMessage())->with('mostrarModal', true);
        }
    }

    public function destroy($id) {
        try {
            $actividad = Actividades::findOrFail($id);
            if ($actividad->foto) {
                Storage::disk('public')->delete($actividad->foto);
            }
            $actividad->delete();
            
            return back()->with('success', 'Actividad eliminada correctamente');
        } catch (Exception $e) {
            return back()->with('error', 'No se pudo eliminar la actividad.');
        }
    }


    // --- MÉTODOS PRIVADOS AUXILIARES ---

    private function validarYProcesar(Request $request, $actividad = null) {
        $reglas = [
            'id_servicio' => 'required|exists:servicios,id_servicio',
            'nombre'      => 'required|string|max:255',
            'hora'        => 'required',
            'area'        => 'required|string|max:255',
            'vbNombre'    => 'required|string|max:255',
            'vbFirma'     => 'nullable|image|mimes:jpeg,png,jpg|max:4096',
            'foto'        => 'nullable|image|mimes:jpeg,png,jpg|max:4096',
        ];

        $request->validate($reglas);
        
        // 1. Extraemos solo los campos de texto primero
        $datos = $request->only(['id_servicio', 'nombre', 'hora', 'area', 'vbNombre']);

        // 2. Procesar Foto de Evidencia
        if ($request->hasFile('foto')) {
            if ($actividad && $actividad->foto) {
                Storage::disk('public')->delete($actividad->foto);
            }
            // CLAVE: Usar store() asigna la ruta limpia a la variable
            $datos['foto'] = $request->file('foto')->store('evidencias_actividades', 'public');
        }

        // 3. Procesar Firma (Visto Bueno)
        if ($request->hasFile('vbFirma')) {
            if ($actividad && $actividad->vbFirma) {
                Storage::disk('public')->delete($actividad->vbFirma);
            }
            // CLAVE: Esto es lo que evita que se guarde la ruta de C:\xampp\tmp
            $datos['vbFirma'] = $request->file('vbFirma')->store('firmas_actividades', 'public');
        }

        return $datos;
    }

    /**
     * Centraliza la respuesta en caso de error de validación para el modal.
     */
    private function errorValidacion(ValidationException $e) {
        return redirect()->back()
            ->withErrors($e->errors())
            ->withInput()
            ->with('errorMensaje', 'Verifica que todos los campos requeridos estén llenos.')
            ->with('mostrarModal', true);
    }
}