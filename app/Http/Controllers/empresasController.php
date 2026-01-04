<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\empresas;
use Illuminate\Validation\ValidationException;


class empresasController extends Controller
{
    public function index() {
            $empresas = empresas::orderBy('updated_at','desc')->paginate(10);
            return view('index', compact('empresas'));
    }

    public function ag_empresa() {
            return view('agregar.agEmpresa');
    }
    
    public function addEmpresa(Request $request)
        {
            $request->validate([
                'nombre' => 'required|string|max:255',
                'encargado' => 'required|string|max:255',
                'fotoEmpresa' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            ]);

            $rutaFoto = 'fotos/profile.jpg'; // ruta por defecto

            if ($request->hasFile('fotoEmpresa')) {
                $rutaFoto = $request->file('fotoEmpresa')->store('fotos', 'public');
            }

            empresas::create([
                'nombre' => $request->nombre,
                'encargado' => $request->encargado,
                'foto' => $rutaFoto,
            ]);

            return redirect('/')->with('success', 'Empresa registrada correctamente');
        }
// =================================================================
    public function edEmpresa($id_empresa){
        
        $empresa_mod = empresas::findOrFail($id_empresa);
        if (!$empresa_mod) {
            return redirect()->back()->with('error', 'Empresa no encontrada');
        }
        return view('editar.edEmpresa', compact('empresa_mod'));
    }
// =================================================================
    public function updateEmpresa(Request $request, $empresa_mod)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'encargado' => 'required|string|max:255',
            'fotoEmpresa' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $empresa_new = empresas::findOrFail($empresa_mod);

        $datos = [
            'nombre' => $request->input('nombre'),
            'encargado' => $request->input('encargado'),
        ];

        if ($request->hasFile('fotoEmpresa')) {
            $foto = $request->file('fotoEmpresa');
            $nombreLimpio = str_replace(' ', '_', $datos['nombre']);
            $nombreArchivo = $nombreLimpio . '_' . time() . '.' . $foto->getClientOriginalExtension();
            $foto->storeAs('fotos', $nombreArchivo, 'public');
            $datos['foto'] = 'fotos/' . $nombreArchivo;
        }

        $empresa_new->update($datos);

        return redirect()->back()->with('success', 'Empresa actualizada correctamente'); 
    }
// =================================================================
    public function delEmpresa($id_empresa){
                try {
                    $registro = empresas::findOrFail($id_empresa);
                    $registro->delete();
                    
                    return redirect()->back()
                        ->with('success', 'Registro eliminado correctamente');
                } catch (\Exception $e) {
                    return redirect()->back()
                        ->with('error', 'Error al eliminar el registro');
                }
            }
}
