<?php

namespace App\Http\Controllers;

use App\Models\Empresas;
use App\Models\Servicio;
use App\Models\Meses;
use App\Models\Actividades; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class actividadesController extends Controller
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
        $empresa = Empresas::find($id_empresa);

        return view('agregar.agActividades', compact('id_servicio', 'id_mes', 'empresa'));
    }

    public function edActividad($id, $id_empresa, $id_mes, $id_servicio) {
        $actividad = Actividades::findOrFail($id);
        $empresa = Empresas::findOrFail($id_empresa);
        return view('editar.edActividades', compact('actividad', 'empresa', 'id_empresa', 'id_mes', 'id_servicio'));
    }


    // --- MÉTODOS DE ACCIÓN (LÓGICA REFORMULADA) ---

    public function addActividad(Request $request) {
        try {
            $datos = $this->validarFormulario($request);
            
            if ($request->hasFile('foto')) {
                $datos['foto'] = $this->procesarFoto($request);
            }

            Actividades::create($datos);

            return redirect('/actividades/' . $request->id_servicio)
                ->with('success', 'Actividad registrada con éxito.');

        } catch (ValidationException $e) {
            return $this->errorValidacion($e);
        }
    }

    public function updateAct(Request $request, $id) {
        try {
            $actividad = Actividades::findOrFail($id);
            $datos = $this->validarFormulario($request);

            if ($request->hasFile('foto')) {
                // Eliminar foto anterior si existe
                if ($actividad->foto) { Storage::disk('public')->delete($actividad->foto); }
                $datos['foto'] = $this->procesarFoto($request);
            }

            $actividad->update($datos);

            return redirect('/actividades/' . $actividad->id_servicio)
                ->with('success', 'Actividad actualizada con éxito.');

        } catch (ValidationException $e) {
            return $this->errorValidacion($e);
        }
    }

    public function destroy($id) {
        $actividad = Actividades::findOrFail($id);
        if ($actividad->foto) {
            Storage::disk('public')->delete($actividad->foto);
        }
        $actividad->delete();
        
        return back()->with('success', 'Actividad eliminada correctamente');
    }


    // --- MÉTODOS PRIVADOS / AUXILIARES (POR FUERA) ---

    /**
     * Define y ejecuta las reglas de validación.
     */
    private function validarFormulario(Request $request) {
        return $request->validate([
            'id_servicio' => 'required|exists:servicios,id_servicio',
            'nombre'      => 'required|string|max:40',
            'hora'        => 'required',
            'area'        => 'nullable|string|max:20',
            'observacion' => 'nullable|string',
            'foto'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'pr1'         => 'required|integer|exists:productos,id_pr',
            'pr2'         => 'nullable|integer|exists:productos,id_pr',
            'pr3'         => 'nullable|integer|exists:productos,id_pr',
            'pr4'         => 'nullable|integer|exists:productos,id_pr',
            'tecnico1'    => 'required|integer|exists:tecnicos,id_tec',
            'tecnico2'    => 'nullable|integer|exists:tecnicos,id_tec',
            'tecnico3'    => 'nullable|integer|exists:tecnicos,id_tec',
        ]);
    }

    /**
     * Maneja la subida de archivos.
     */
    private function procesarFoto(Request $request) {
        return $request->file('foto')->store('actividades', 'public');
    }

    /**
     * Centraliza la respuesta en caso de error de validación para mostrar el modal.
     */
    private function errorValidacion(ValidationException $e) {
        return redirect()->back()
            ->withErrors($e->errors())
            ->withInput()
            ->with('errorMensaje', 'Verifica los campos del formulario.')
            ->with('mostrarModal', true);
    }
}