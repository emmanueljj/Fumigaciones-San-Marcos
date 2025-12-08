<?php

namespace App\Http\Controllers;

use App\Models\Meses;
use App\Models\empresas;
use App\Models\productos;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use App\Models\tecnicos;

class Controlador extends Controller
{
        public function index() {
            $empresas = empresas::orderBy('updated_at','desc')->get();
            return view('index', compact('empresas'));
        }
        public function productos() {
            $productos = productos::orderBy('updated_at','desc')->get();
            return view('productos', compact('productos'));
        }
        public function tecnicos() {
            $tecnicos = tecnicos::orderBy('updated_at','desc')->get();
            return view('tecnicos', compact('tecnicos'));
        }
        public function verMeses($id_empresa)
        {
            $meses = Meses::where('id_empresa', $id_empresa)->orderBy('fecha_I', 'desc')->get();
            $empresa = empresas::find($id_empresa); // o ->where('id_empresa', $id_empresa)->first();
            return view('meses', compact('meses', 'empresa'));
        }
        
        // para ver vista agregar (formularios)
        public function ag_empresa() {
            return view('agregar.agEmpresa');
        }

        public function ag_productos() {
            return view('agregar.agProductos');
        }

        public function ag_tecnicos() {
            return view('agregar.agTecnicos');
        }

            public function ag_meses($id_empresa) {
                $empresa = empresas::find($id_empresa);
                return view('agregar.agMes', compact('empresa'));
    }


    // para regsitros empresas

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

            return redirect()->back()->with('success', 'Empresa registrada correctamente');
        }

        // para regsitros meses

        public function addMes(Request $request, $id_empresa)
        {
            try {
                // 1. VALIDACIONES DE LARAVEL (Campos Vacíos, Fecha Menor/Igual)
                $request->validate([
                    // Excepción 1: Campos Vacíos (required)
                    'fecha_I' => 'required|date',
                    'fecha_f' => 'required|date',
                    
                    // Excepción 2: Fecha Final Anterior/Igual a la Inicial
                    'fecha_f' => 'after:fecha_I', 
                ]);

                $inicio = Carbon::parse($request->fecha_I)->startOfDay(); 
                $corte = Carbon::parse($request->fecha_f)->endOfDay();

            } catch (ValidationException $e) {
                // Si falla alguna de las validaciones de Laravel (required o after:fecha_I), 
                // capturamos el error y devolvemos el mensaje personalizado.
                
                $errors = $e->errors();
                $mensaje = 'Error de validación de fechas.';
                
                // Determinar qué error ocurrió para dar un mensaje específico
                if (isset($errors['fecha_I']) || isset($errors['fecha_f']) && (
                    in_array('El campo fecha I es obligatorio.', $errors['fecha_I'] ?? []) || 
                    in_array('El campo fecha f es obligatorio.', $errors['fecha_f'] ?? [])
                )) {
                    $mensaje = 'Debes completar ambas fechas. No pueden estar vacías.';
                } elseif (isset($errors['fecha_f'])) {
                    // El error 'after:fecha_I' es el único error de fecha_f restante.
                    $mensaje = 'La fecha de finalización debe ser posterior a la fecha de inicio.';
                }

                return redirect()->back()
                    ->with('errorMensaje', $mensaje)
                    ->with('mostrarModal', true)
                    ->withInput();
            }
            
            // =================================================================
            // ========== EXCEPCIÓN 3: MISMO MES CALENDARIO ====================
            // =================================================================
            
            if ($inicio->format('Y-m') === $corte->format('Y-m')) {
                return redirect()->back()
                    ->with('errorMensaje', 'Las fechas deben estar en meses calendario distintos. El periodo debe cruzar al menos un límite de mes.')
                    ->with('mostrarModal', true)
                    ->withInput();
            }
            
            // =================================================================
            // ========== EXCEPCIÓN 4: SOLAPAMIENTO DE PERIODOS ================
            // =================================================================
            
            $solapamiento = meses::where('id_empresa', $id_empresa)
                ->where(function ($query) use ($inicio, $corte) {
                    $query->whereDate('fecha_f', '>=', $inicio->toDateString())
                        ->whereDate('fecha_I', '<=', $corte->toDateString());
                })
                ->exists();

            if ($solapamiento) {
                return redirect()->back()
                    ->with('errorMensaje', 'El periodo ingresado se solapa con un mes ya registrado para esta empresa. Por favor, ajuste las fechas.')
                    ->with('mostrarModal', true)
                    ->withInput();
            }
            
            // =================================================================

            // Si todo está bien, guarda el registro
            meses::create([
                'fecha_I' => $inicio->toDateString(), 
                'fecha_f' => $corte->toDateString(),
                'id_empresa' => $id_empresa
            ]);

            return redirect()->back()->with('success', 'Mes registrado correctamente');
        }

        // para registrar tecnicios

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
        
        // =================================================================
        tecnicos::create([
            'nombre' => $request->nombre,
            'clave' => $request->clave,
        ]);
        return redirect()->back()->with('success', 'Técnico registrado correctamente'); 
    }

    //hacer registros productos

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
    
    //editar tecnicos vista
    public function edTecnicos($id_tec){
        $tecnico = tecnicos::where('id_tec', $id_tec)->first();
        if (!$tecnico) {
            return redirect()->back()->with('error', 'Técnico no encontrado');
        }
        return view('editar.edTecnicos', compact('tecnico'));
    }
    //actualizar tecnicos
  public function updateTec(Request $request, Tecnicos $tecnico)
{
    // 2. Manejo de la Validación (optimizado)
    try {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'id_tec' => 'required|string|max:255',
        ]);
        
    } catch (ValidationException $e) {
        // Tu lógica personalizada para manejar la validación
        $mensaje = 'Debes completar todos los campos (nombre y clave del técnico).';

        return redirect()->back()
            // Es crucial usar withErrors() para que los errores de campo estén disponibles
            ->withErrors($e->errors()) 
            ->with('errorMensaje', $mensaje)
            ->with('mostrarModal', true)
            ->withInput();
    }

    // 3. Actualización del Registro (Correcto)
    // El método $tecnico->update() es la forma correcta de actualizar la instancia inyectada.
    $tecnico->update([
        'nombre' => $request->input('nombre'),
        'id_tec' => $request->input('id_tec'), 
    ]);
    
    // 4. Redirección
    return redirect()->back()->with('success', 'Técnico modificado correctamente'); 
}

}
