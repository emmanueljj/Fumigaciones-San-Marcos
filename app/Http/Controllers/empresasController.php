<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresas;
use Illuminate\Support\Facades\Storage;
use Exception;

class EmpresasController extends Controller
{
    public function index() {
        $empresas = Empresas::orderBy('updated_at', 'desc')->paginate(10);
        return view('index', compact('empresas'));
    }

    public function ag_empresa() {
        return view('agregar.agEmpresa');
    }


    private function validarYProcesar(Request $request, $empresa = null) 
    {
        // 1. Validar campos (incluyendo los nuevos de la migración)
        $request->validate([
            'nombre'          => 'required|string|max:255',
            'encargado'       => 'required|string|max:255',
            'correo'          => 'required|email|max:255',
            'ubicacion'       => 'nullable|string|max:500',
            'fotoEmpresa'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'calendario'      => 'nullable|mimes:pdf,jpg,jpeg,png|max:4096',
            'esquemas'        => 'nullable|mimes:pdf,jpg,jpeg,png|max:4096',
            'especificaciones'=> 'nullable|mimes:pdf,jpg,jpeg,png|max:4096',
        ]);

        // 2. Preparar datos base
            $datos = $request->only(['nombre', 'encargado', 'correo', 'ubicacion']);

        // 3. Procesar archivos dinámicamente
        // Mapeo: 'nombre_en_formulario' => 'nombre_en_base_de_datos'
        $archivos = [
            'fotoEmpresa'      => 'foto',
            'calendario'       => 'calendario',
            'esquemas'         => 'esquemas',
            'especificaciones' => 'especificaciones'
        ];

        foreach ($archivos as $input => $columna) {
            if ($request->hasFile($input)) {
                // Si estamos editando y existe un archivo viejo, lo borramos (opcional pero recomendado)
                if ($empresa && $empresa->$columna && $empresa->$columna !== 'fotos/profile.jpg') {
                    Storage::disk('public')->delete($empresa->$columna);
                }
                
                // Guardar el nuevo archivo
                $datos[$columna] = $request->file($input)->store('fotos', 'public');
            }
        }

        return $datos;
    }

    public function addEmpresa(Request $request)
    {
        try {
            $datos = $this->validarYProcesar($request);
            
            // Asignar foto por defecto si no se subió ninguna
            if (!isset($datos['foto'])) {
                $datos['foto'] = 'fotos/profile.jpg';
            }

            Empresas::create($datos);

            return redirect('/')->with('success', 'Empresa registrada correctamente');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Error al registrar: ' . $e->getMessage());
        }
    }

    public function edEmpresa($id_empresa) {
        $empresa_mod = Empresas::findOrFail($id_empresa);
        return view('editar.edEmpresa', compact('empresa_mod'));
    }

    public function updateEmpresa(Request $request, $id_empresa)
    {
        try {
            $empresa = Empresas::findOrFail($id_empresa);
            $datos = $this->validarYProcesar($request, $empresa);

            $empresa->update($datos);

            return redirect('/')->with('success', 'Empresa actualizada correctamente');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Error al actualizar: ' . $e->getMessage());
        }
    }

    public function delEmpresa($id_empresa) {
        try {
            $registro = Empresas::findOrFail($id_empresa);
            
            // Borrar archivos del storage antes de eliminar el registro (excepto el default)
            $columnasArchivos = ['foto', 'calendario', 'esquemas', 'especificaciones'];
            foreach ($columnasArchivos as $col) {
                if ($registro->$col && $registro->$col !== 'fotos/profile.jpg') {
                    Storage::disk('public')->delete($registro->$col);
                }
            }

            $registro->delete();
            return redirect()->back()->with('success', 'Registro eliminado correctamente');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar el registro');
        }
    }
}