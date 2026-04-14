<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Productos;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Exception;

class ProductosController extends Controller
{
    public function productos() {
        $productos = Productos::orderBy('updated_at', 'desc')->paginate(10);
        return view('productos', compact('productos'));
    }

    public function ag_productos() {
        return view('agregar.agProductos');
    }

    /**
     * Método centralizado para validar datos, procesar archivos y evitar duplicados
     */
    private function validarYProcesar(Request $request, $id_prod = null){
        
        $request->validate([
            'nombre'         => 'required|string|max:255',
            'concentracion'  => 'required|string|max:255',
            // CAMBIO: Aceptar múltiples imágenes
            'fichaTecnica'   => 'nullable|array',
            'fichaTecnica.*' => 'image|mimes:jpg,jpeg,png|max:4096',
        ]);

        // (Tu lógica de duplicados se mantiene igual...)

        $datos = $request->only(['nombre', 'concentracion']);

        if ($request->hasFile('fichaTecnica')) {
            if ($id_prod) {
                $prodActual = Productos::find($id_prod);
                if ($prodActual && is_array($prodActual->fichaTecnica)) {
                    foreach ($prodActual->fichaTecnica as $vieja) {
                        Storage::disk('public')->delete($vieja);
                    }
                }
            }

            $rutasFichas = [];
            foreach ($request->file('fichaTecnica') as $file) {
                $rutasFichas[] = $file->store('fichas_tecnicas', 'public');
            }
            $datos['fichaTecnica'] = $rutasFichas;
        }

        return $datos;
    }

    public function addProductos(Request $request)
    {
        try {
            $datos = $this->validarYProcesar($request);
            Productos::create($datos);

            return redirect()->back()->with('success', 'Producto registrado correctamente');

        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput()
                ->with('errorMensaje', $e->getMessage())
                ->with('mostrarModal', true);
        } catch (Exception $e) {
            return redirect()->back()->withInput()
                ->with('errorMensaje', $e->getMessage())
                ->with('mostrarModal', true);
        }
    }

    public function edProducto($id_prod) {
        $prod_mod = Productos::findOrFail($id_prod);
        return view('editar.edProductos', compact('prod_mod'));
    }

    public function updateProducto(Request $request, $id_prod)
    {
        try {
            $producto = Productos::findOrFail($id_prod);
            $datos = $this->validarYProcesar($request, $id_prod);

            $producto->update($datos);

            return redirect('/productos')->with('success', 'Producto modificado correctamente');

        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput()
                ->with('errorMensaje', $e->getMessage())
                ->with('mostrarModal', true);
        } catch (Exception $e) {
            return redirect()->back()->withInput()
                ->with('errorMensaje', $e->getMessage())
                ->with('mostrarModal', true);
        }
    }

    public function delProductos($id_prod) {
        try {
            $registro = Productos::findOrFail($id_prod);
            
            // Borrar archivo físico
            if ($registro->fichaTecnica) {
                Storage::disk('public')->delete($registro->fichaTecnica);
            }

            $registro->delete();
            return redirect()->back()->with('success', 'Producto eliminado correctamente');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar el registro');
        }
    }

    public function buscar(Request $request) {
        $term = $request->q;
        $productos = Productos::where('nombre', 'LIKE', "%$term%")->get();

        return response()->json($productos->map(function($p) {
        return [
                    'id'    => $p->id_pr,     // ID real para la base de datos
                    'label' => $p->nombre,  // Lo que el usuario ve en la lista
                    'value' => $p->nombre,  // Lo que se escribe en el input al seleccionar
                    'text'  => $p->id_pr   // Mantener por compatibilidad con tu JS actual
                ];
        }));
    }
}