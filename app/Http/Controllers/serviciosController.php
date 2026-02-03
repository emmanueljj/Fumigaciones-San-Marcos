<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servicio;
use App\Models\Meses;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Exception;

class ServiciosController extends Controller
{
    public function verServicios($id_mes)
    {
        $mes = Meses::with('empresa')->findOrFail($id_mes);
        $empresa = $mes->empresa;
        // Cargamos las relaciones de muchos a muchos para mostrarlas en la vista si es necesario
        $servicios = Servicio::with(['productos', 'tecnicos'])
            ->where('id_mes', $id_mes)
            ->orderBy('fecha', 'desc')
            ->get();
            
        return view('servicios', compact('servicios', 'id_mes', 'mes', 'empresa'));
    }

    public function ag_servicios($id_mes)
    {
        $mes = Meses::with('empresa')->findOrFail($id_mes);
        $empresa = $mes->empresa;
        return view('agregar.agServicios', compact('id_mes', 'mes', 'empresa'));
    }

    /**
     * Método centralizado para validar datos y procesar archivos técnicos
     */
    private function validarYProcesar(Request $request, $id_mes, $servicio = null)
    {
        try {
            $request->validate([
                'fecha'             => 'required|date',
                'observacion'       => 'nullable|string',
                'controlPerimetral' => 'nullable|mimes:pdf,jpg,jpeg,png|max:4096',
                'productos'         => 'nullable|array', // Validamos que lleguen como array
                'tecnicos'          => 'nullable|array',
            ]);
        } catch (ValidationException $e) {
            throw ValidationException::withMessages([
                'errorMensaje' => 'Verifica la fecha y los archivos seleccionados (Solo PDF/Imagen).',
                'mostrarModal' => true
            ]);
        }

        // Validación de rango de fecha respecto al mes
        $mes = Meses::findOrFail($id_mes);
        $fecha = Carbon::parse($request->fecha);
        if ($fecha->lt(Carbon::parse($mes->fecha_I)) || $fecha->gt(Carbon::parse($mes->fecha_f))) {
            throw new Exception('La fecha seleccionada no pertenece al periodo del mes.');
        }

        $datos = $request->only(['fecha', 'observacion']);
        $datos['id_mes'] = $id_mes;

        // Procesar archivo de Control Perimetral
        if ($request->hasFile('controlPerimetral')) {
            if ($servicio && $servicio->controlPerimetral) {
                Storage::disk('public')->delete($servicio->controlPerimetral);
            }
            $datos['controlPerimetral'] = $request->file('controlPerimetral')->store('controles_perimetrales', 'public');
        }

        return $datos;
    }

    public function addServicio(Request $request, $id_mes)
    {
        try {
            $datos = $this->validarYProcesar($request, $id_mes);
            $servicio = Servicio::create($datos);

            // Guardar relaciones Muchos a Muchos (Tablas Pivot)
            if ($request->has('productos')) {
                $servicio->productos()->attach($request->productos);
            }
            if ($request->has('tecnicos')) {
                $servicio->tecnicos()->attach($request->tecnicos);
            }

            return redirect('/servicios/' . $id_mes)->with('success', 'Servicio registrado correctamente');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('errorMensaje', $e->getMessage());
        }
    }

    public function edServicio(Request $request, $id_servicio)
    {
        $id_mes = $request->input('id_mes'); 
        $mes = Meses::with('empresa')->findOrFail($id_mes);
        $empresa = $mes->empresa;
        // Cargamos los IDs actuales para que el buscador/badges los reconozca en la edición
        $servicio = Servicio::with(['productos', 'tecnicos'])->findOrFail($id_servicio);
        return view('editar.edServicios', compact('id_mes', 'mes', 'empresa', 'servicio'));
    }

    public function updateSer(Request $request, $id_servicio) 
    {
        try {
            $servicio = Servicio::findOrFail($id_servicio);
            $datos = $this->validarYProcesar($request, $servicio->id_mes, $servicio);

            $servicio->update($datos);

            // Sincronizar relaciones Muchos a Muchos (Borra los que no estén en el array y agrega los nuevos)
            $servicio->productos()->sync($request->productos ?? []);
            $servicio->tecnicos()->sync($request->tecnicos ?? []);

            return redirect('/servicios/' . $servicio->id_mes)->with('success', 'Servicio actualizado.');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('errorMensaje', $e->getMessage());
        }
    }

    public function delServicio($id_servicio)
    {
        try {
            $registro = Servicio::findOrFail($id_servicio);
            
            // Borrar archivo técnico
            if ($registro->controlPerimetral) {
                Storage::disk('public')->delete($registro->controlPerimetral);
            }

            // Nota: Las relaciones en las tablas pivot se borran solas por el "onDelete('cascade')" de la migración
            $registro->delete();
            
            return redirect()->back()->with('success', 'Servicio eliminado correctamente');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar el registro');
        }
    }
}