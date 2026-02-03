<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tecnicos;
use Illuminate\Validation\ValidationException;


class tecnicosController extends Controller
{
    public function tecnicos() {
            $tecnicos = tecnicos::orderBy('updated_at','desc')->paginate(10);
            return view('tecnicos', compact('tecnicos'));
    }

    public function ag_tecnicos() {
            return view('agregar.agTecnicos');
    }

    public function addTecnicos(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:255',
                'clave' => 'required|string|max:255',
            ]);
            
        } catch (ValidationException $e) {
        $mensaje = 'Debes completar todos los campos (nombre y clave del técnico).';

        return redirect()->back()
            ->with('errorMensaje', $mensaje) // Manda el mensaje personalizado
            ->with('mostrarModal', true)      // Manda la bandera para el modal
            ->withInput();
    }

        $otroRegistroMismaClave = tecnicos::where('clave', $request->clave)->first();

        if ($otroRegistroMismaClave) {
            return redirect()->back()
                ->with('errorMensaje', 'La clave "' . $request->clave . '" ya pertenece a otro técnico.')
                ->with('mostrarModal', true)
                ->withInput();
        }
        tecnicos::create([
            'nombre' => $request->nombre,
            'clave' => $request->clave,
        ]);
        return redirect()->back()->with('success', 'Técnico registrado correctamente'); 
    }


  // =================================================================
    public function edTecnico($id_tec){
        $tec_mod = tecnicos::where('id_tec', $id_tec)->first();
        if (!$tec_mod) {
            return redirect()->back()->with('error', 'Técnico no encontrado');
        }
        return view('editar.edTecnicos', compact('tec_mod'));
    }
  // =================================================================
    public function updateTecnico(Request $request, $tec_mod)
    {
        // 2. Manejo de la Validación (optimizado)
        try {
            $request->validate([
                'nombre' => 'required|string|max:255',
                'clave' => 'required|string|max:255',
            ]);
            
        } catch (ValidationException $e) {
            $mensaje = 'Debes completar todos los campos (nombre y clave del técnico).';
            return redirect()->back()
                ->withErrors($e->errors()) 
                ->with('errorMensaje', $mensaje)
                ->with('mostrarModal', true)
                ->withInput();
        }

        $tec_new = tecnicos::findOrFail($tec_mod);

        $tec_new->update([
            'nombre' => $request->input('nombre'),
            'clave' => $request->input('clave'), 
        ]);

        return redirect()->back()->with('success', 'Técnico modificado correctamente'); 
    }
   // =================================================================
    public function delTecnicos($id_tec){
        try {
            $registro = tecnicos::findOrFail($id_tec);
            $registro->delete();
            
            return redirect()->back()
                ->with('success', 'Registro eliminado correctamente');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al eliminar el registro');
        }
    }

    public function buscar(Request $request) {
        $term = $request->q;
        $tecnicos = tecnicos::where('nombre', 'LIKE', "%$term%")->get();

        return response()->json($tecnicos->map(function($p) {
            return [
                'id'    => $p->id_tec,     // ID real para la base de datos
                'label' => $p->nombre,  // Lo que el usuario ve en la lista
                'value' => $p->nombre,  // Lo que se escribe en el input al seleccionar
                'text'  => $p->nombre   // Mantener por compatibilidad con tu JS actual
            ];
        }));
    }

}

