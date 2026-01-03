<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\productos;
use Illuminate\Validation\ValidationException;


class productosController extends Controller
{
    public function productos() {
            $productos = productos::orderBy('updated_at','desc')->paginate(10);
            return view('productos', compact('productos'));
    }
    
    public function ag_productos() {
            return view('agregar.agProductos');
    }
    
    public function addProductos(Request $request){
        
        try {
            $request->validate([
                'nombre' => 'required|string|max:255',
                'concentracion' => 'required|string|max:255',
                'metodo' => 'required|string|max:255',
                'plaga' => 'required|string|max:255',
            ]);
            
        } catch (ValidationException $e) {
        // Definimos el mensaje claro y legible
        $mensaje = 'Debes completar todos los campos';

        return redirect()->back()
            ->with('errorMensaje', $mensaje) // Manda el mensaje personalizado
            ->with('mostrarModal', true)      // Manda la bandera para el modal
            ->withInput();
    }

        $otroRegistroMismoId = productos::where([
            'nombre'=> $request->nombre,
            'concentracion'=> $request->concentracion,
            'metodo'=> $request->metodo,
            'plaga'=> $request->plaga,
        ])->first();

        if ($otroRegistroMismoId) {
            return redirect()->back()
                ->with('errorMensaje','ya tienes un producto totalmente identico')
                ->with('mostrarModal', true)
                ->withInput();
        }
 
        productos::create([
        'nombre' => $request->nombre,
        'concentracion' => $request->concentracion,
        'metodo' => $request->metodo,
        'plaga' => $request->plaga
        ]);

        return redirect()->back()->with('success', 'Técnico registrado correctamente');
    }
  // =================================================================
    public function edProducto($id_prod){
        
        $prod_mod = productos::findOrFail($id_prod);
        if (!$prod_mod) {
            return redirect()->back()->with('error', 'Técnico no encontrado');
        }
        return view('editar.edProductos', compact('prod_mod'));
    }
  // =================================================================
    public function updateProducto(Request $request, $prod_mod)
    {
        // 2. Manejo de la Validación (optimizado)
        try {
            $request->validate([
                'nombre' => 'required|string|max:255',
                'concentracion' => 'required|string|max:255',
                'metodo' => 'required|string|max:255',
                'plaga' => 'required|string|max:255',
            ]);
            
        } catch (ValidationException $e) {
            $mensaje = 'Debes completar todos los campos (nombre,concentracion,metodo,etc.).';
            return redirect()->back()
                ->withErrors($e->errors()) 
                ->with('errorMensaje', $mensaje)
                ->with('mostrarModal', true)
                ->withInput();
        }

        $prod_new = productos::findOrFail($prod_mod);

        $prod_new->update([
            'nombre' => $request->input('nombre'),
            'clave' => $request->input('clave'), 
            'concentracion' => $request->input('concentracion'),
            'metodo' => $request->input('metodo'),
            'plaga' => $request->input('plaga')
        ]);

        return redirect()->back()->with('success', 'Técnico modificado correctamente'); 
    }
   // =================================================================
    public function delProductos($id_prod){
                try {
                    $registro = productos::findOrFail($id_prod);
                    $registro->delete();
                    
                    return redirect()->back()
                        ->with('success', 'Registro eliminado correctamente');
                } catch (\Exception $e) {
                    return redirect()->back()
                        ->with('error', 'Error al eliminar el registro');
                }
            }

    // Ejemplo de cómo debería verse la respuesta en tu Controlador
    public function buscar(Request $request) {
        $term = $request->q;
        $productos = productos::where('nombre', 'LIKE', "%$term%")
            ->get(['id_pr', 'nombre', 'concentracion']);

        return response()->json($productos->map(function($p) {
            return [
                'id' => $p->id_pr,
                'text' => $p->nombre,
                'concentracion' => $p->concentracion // <-- ESTO ES VITAL
            ];
        }));
    }
    
}
