<?php

namespace App\Http\Controllers;

use App\Models\actividades;
use App\Models\Empresas;
use App\Models\servicio;
use Illuminate\Http\Request;

class actividadesController extends Controller
{
public function verActividades($id_servicio) {
    // Usa findOrFail para asegurar que existe
    $servicio = servicio::findOrFail($id_servicio); 
    
    $id_mes = $servicio->id_mes;
    // ... resto de tu código ...
    
    // IMPORTANTE: Asegúrate de que 'servicio' esté dentro del compact
    return view('actividades', compact('id_mes','servicio'));
}
    // Muestra el formulario de creación
    public function create($id_servicio) {
        // Buscamos el servicio para saber a quién pertenece la actividad
        $servicio = servicio::find($id_servicio);
        
        // Retornamos la vista del formulario (que aun debes crear)
        return view('actividades_create', compact('servicio'));
    }

    // Guarda la actividad en la BD
    public function store(Request $request) {
        // Aquí irá tu lógica para guardar...
    }

    // Muestra el formulario de edición
    public function edit($id) {
        $actividad = actividades::find($id);
        return view('actividades_edit', compact('actividad'));
    }
    
    // Elimina la actividad
    public function destroy($id) {
        $actividad = actividades::find($id);
        $actividad->delete();
        
        // Redirigimos atrás
        return back()->with('success', 'Actividad eliminada correctamente');
    }

    // Actualiza la actividad
    public function update(Request $request, $id) {
        // Lógica para actualizar...
    }
}
