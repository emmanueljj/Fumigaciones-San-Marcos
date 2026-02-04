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

    /**
     * Procesa la validación y el almacenamiento de archivos
     */
    private function validarYProcesar(Request $request, $empresa = null) 
    {
        // 1. Validar campos (Calendario y Especificaciones ahora son estrictamente imágenes)
        $request->validate([
            'nombre'           => 'required|string|max:255',
            'encargado'        => 'required|string|max:255',
            'correo'           => 'required|email|max:255',
            'ubicacion'        => 'nullable|string|max:500',
            'fotoEmpresa'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'calendario'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096', // Solo Imagen
            'esquemas'         => 'nullable|mimes:pdf|max:5120', // Solo PDF (Plano técnico)
            'especificaciones' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096', // Solo Imagen
        ]);

        $datos = $request->only(['nombre', 'encargado', 'correo', 'ubicacion']);

        // 2. Mapeo de inputs de formulario a columnas de la base de datos
        $archivos = [
            'fotoEmpresa'      => 'foto',
            'calendario'       => 'calendario',
            'esquemas'         => 'esquemas',
            'especificaciones' => 'especificaciones'
        ];

        foreach ($archivos as $input => $columna) {
            if ($request->hasFile($input)) {
                // Borrar archivo anterior si existe y no es el perfil por defecto
                if ($empresa && $empresa->$columna && $empresa->$columna !== 'fotos/profile.jpg') {
                    Storage::disk('public')->delete($empresa->$columna);
                }
                
                // Determinamos la carpeta según el tipo de archivo para orden
                $folder = ($input === 'fotoEmpresa') ? 'fotos_perfil' : 'documentos_empresas';
                $datos[$columna] = $request->file($input)->store($folder, 'public');
            }
        }

        return $datos;
    }

    public function addEmpresa(Request $request)
    {
        try {
            $datos = $this->validarYProcesar($request);
            
            if (!isset($datos['foto'])) {
                $datos['foto'] = 'fotos/profile.jpg';
            }

            Empresas::create($datos);
            return redirect('/')->with('success', 'Empresa registrada correctamente');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Error: ' . $e->getMessage());
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
            return redirect()->back()->withInput()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function delEmpresa($id_empresa) {
        try {
            $registro = Empresas::findOrFail($id_empresa);
            $columnasArchivos = ['foto', 'calendario', 'esquemas', 'especificaciones'];
            
            foreach ($columnasArchivos as $col) {
                if ($registro->$col && $registro->$col !== 'fotos/profile.jpg') {
                    Storage::disk('public')->delete($registro->$col);
                }
            }

            $registro->delete();
            return redirect()->back()->with('success', 'Empresa eliminada');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'No se pudo eliminar');
        }
    }
}