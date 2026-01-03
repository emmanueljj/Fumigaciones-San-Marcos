<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use App\Models\meses;
use Illuminate\Support\Facades\Storage;
use App\Models\servicio;


class serviciosController extends Controller
{
    public function verServicios($id_mes)
        {
            // Cargar el mes con su empresa
            $mes = Meses::with('empresa')->findOrFail($id_mes);
            $empresa = $mes->empresa;
            
            // Obtener servicios
            $servicios = Servicio::where('id_mes', $id_mes)
                ->orderBy('fecha', 'desc')
                ->get();
            
            return view('servicios', compact('servicios', 'id_mes', 'mes', 'empresa'));
        }

    public function ag_servicios($id_mes)
        {
            // Cargar el mes con su empresa relacionada
            $mes = Meses::with('empresa')->findOrFail($id_mes);
            $empresa = $mes->empresa;
            
            return view('agregar.agServicios', compact('id_mes', 'mes', 'empresa'));
        }

    // Guardar servicio
    public function addServicio(Request $request, $id_mes)
    {
        try {
            $request->validate([
                'fecha' => 'required|date',
                'vb_nombre' => 'nullable|string|max:30',
                'vb_firma' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB máximo
            ]);
        } catch (ValidationException $e) {
            $mensaje = 'Por favor, verifica que todos los campos estén correctos.';
            return redirect()->back()
                ->with('errorMensaje', $mensaje)
                ->withInput();
        }

        // Validar que la fecha esté dentro del periodo del mes
        $mes = Meses::findOrFail($id_mes);
        $fecha = Carbon::parse($request->fecha);
        
        if ($fecha->lt(Carbon::parse($mes->fecha_I)) || $fecha->gt(Carbon::parse($mes->fecha_f))) {
            return redirect()->back()
                ->with('errorMensaje', 'La fecha debe estar dentro del periodo del mes seleccionado.')
                ->withInput();
        }

        // Guardar la firma si se subió
        $firmaPath = null;
        if ($request->hasFile('vb_firma')) {
            $firmaPath = $request->file('vb_firma')->store('firmas', 'public');
        }

        // Crear el servicio
        Servicio::create([
            'fecha' => $request->fecha,
            'vb_nombre' => $request->vb_nombre,
            'vb_firma' => $firmaPath,
            'id_mes' => $id_mes
        ]);

        return redirect('/servicios/' . $id_mes)
            ->with('success', 'Servicio registrado correctamente');
    }


    //  1. Inyecta Request    2. Recibe el parámetro de la ruta
    public function edServicio(Request $request, $id_servicio)
    {
        $id_mes = $request->input('id_mes'); 
        $mes = Meses::with('empresa')->findOrFail($id_mes);
        $empresa = $mes->empresa;
        $servicio = Servicio::findOrFail($id_servicio);
        return view('editar.edServicios', compact('id_mes', 'mes', 'empresa','servicio'));
    }


public function updateSer(Request $request, $id_servicio) 
{
    // 1. Validación (Laravel redirige automáticamente si falla, pero mantenemos tu lógica)
    $request->validate([
        'fecha' => 'required|date',
        'vb_nombre' => 'required|string|max:30',
        'vb_firma' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    // 2. Encontrar el registro actual
    $serv_new = servicio::findOrFail($id_servicio);

    // 3. Preparar los datos básicos (solo texto y fecha)
    $datos = [
        'fecha'     => $request->fecha,
        'vb_nombre' => $request->vb_nombre,
    ];

    // 4. Lógica para la firma: Solo si se subió un archivo nuevo
    if ($request->hasFile('vb_firma')) {
        
        // BORRAR FIRMA ANTERIOR:
        if ($serv_new->vb_firma && Storage::disk('public')->exists($serv_new->vb_firma)) {
            Storage::disk('public')->delete($serv_new->vb_firma);
        }

        // GUARDAR FIRMA NUEVA:
        $datos['vb_firma'] = $request->file('vb_firma')->store('firmas', 'public');
    }

    // 5. Actualizar solo con los campos del arreglo $datos
    // Si no hubo firma nueva, 'vb_firma' no va en el arreglo y no se intenta poner en null
    $serv_new->update($datos);

    return redirect('/servicios/' . $serv_new->id_mes)
        ->with('success', 'Servicio actualizado correctamente.');
}

    public function delServicio($id_servicio){
                try {
                    $registro = servicio::findOrFail($id_servicio);
                    $registro->delete();
                    
                    return redirect()->back()
                        ->with('success', 'Registro eliminado correctamente');
                } 
                catch (\Exception $e) {
                    return redirect()->back()
                        ->with('error', 'Error al eliminar el registro');
                }
    }
}
