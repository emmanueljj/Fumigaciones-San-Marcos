<?php

namespace App\Http\Controllers;

use App\Models\empresas;
use Illuminate\Http\Request;
use App\Models\Meses;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class mesesController extends Controller
{
    //  * Valida los campos de fecha (que no estén vacíos y que fecha_f sea posterior a fecha_I)

    private function validarCamposFechas(Request $request) {
        try {
            $request->validate([
                'fecha_I' => 'required|date',
                'fecha_f' => 'required|date|after:fecha_I',
            ]);
            return null; // Sin errores
        } catch (ValidationException $e) {
            $errors = $e->errors();
            $mensaje = 'Error de validación de fechas.';
            
            if (isset($errors['fecha_I']) || isset($errors['fecha_f']) && (
                in_array('El campo fecha I es obligatorio.', $errors['fecha_I'] ?? []) || 
                in_array('El campo fecha f es obligatorio.', $errors['fecha_f'] ?? [])
            )) {
                $mensaje = 'Debes completar ambas fechas. No pueden estar vacías.';
            } elseif (isset($errors['fecha_f'])) {
                $mensaje = 'La fecha de finalización debe ser posterior a la fecha de inicio.';
            }
            
            return $mensaje;
        }
    }

    //  * Verifica que las fechas estén en meses calendario distintos

    private function validarMesesDistintos(Carbon $inicio, Carbon $corte)
    {
        if ($inicio->format('Y-m') === $corte->format('Y-m')) {
            return 'Las fechas deben estar en meses calendario distintos. El periodo debe cruzar al menos un límite de mes.';
        }
        return null; // Sin errores
    }


    //  Verifica que no haya solapamiento con periodos existentes

    private function validarSolapamiento($id_empresa, Carbon $inicio, Carbon $corte, $excluirId = null)
    {
        $query = Meses::where('id_empresa', $id_empresa)
            ->where(function ($query) use ($inicio, $corte) {
                $query->whereDate('fecha_f', '>=', $inicio->toDateString())
                    ->whereDate('fecha_I', '<=', $corte->toDateString());
            });
        
        // Si estamos editando, excluir el registro actual
        if ($excluirId) {
            $query->where('id_mes', '!=', $excluirId);
        }
        
        if ($query->exists()) {
            return 'El periodo ingresado se solapa con un mes ya registrado para esta empresa. Por favor, ajuste las fechas.';
        }
        
        return null; // Sin errores
    }


    //  * Ejecuta todas las validaciones de fechas y retorna el primer error encontrado o null

    private function validarFechas(Request $request, $id_empresa, $excluirId = null)
    {
        // 1. Validar campos básicos
        $error = $this->validarCamposFechas($request);
        if ($error) return $error;
        
        // 2. Parsear fechas
        $inicio = Carbon::parse($request->fecha_I)->startOfDay();
        $corte = Carbon::parse($request->fecha_f)->endOfDay();
        
        // 3. Validar meses distintos
        $error = $this->validarMesesDistintos($inicio, $corte);
        if ($error) return $error;
        
        // 4. Validar solapamiento
        $error = $this->validarSolapamiento($id_empresa, $inicio, $corte, $excluirId);
        if ($error) return $error;
        
        return null; // Todo OK
    }
  // =================================================================

    public function verMeses($id_empresa)
        {
            $meses = Meses::where('id_empresa', $id_empresa)->orderBy('fecha_I', 'asc')->get();
            $empresa = empresas::find($id_empresa); // o ->where('id_empresa', $id_empresa)->first();
            return view('meses', compact('meses', 'empresa'));
        }

    public function ag_meses($id_empresa) {
            $empresa = empresas::find($id_empresa);
            return view('agregar.agMes', compact('empresa'));
        }
  // =================================================================
    public function edMes($id_mes){
        $mes_mod = Meses::where('id_mes', $id_mes)->first();
        if (!$mes_mod) {
            return redirect()->back()->with('error', 'Mes no encontrado');
        }
        return view('editar.edMeses', compact('mes_mod'));
    }
   // =================================================================

    public function addMes(Request $request, $id_empresa)
    {
        // Ejecutar todas las validaciones
        $errorMensaje = $this->validarFechas($request, $id_empresa);
        
        if ($errorMensaje) {
            return redirect()->back()
                ->with('errorMensaje', $errorMensaje)
                ->with('mostrarModal', true)
                ->withInput();
        }
        
        // Si todo está bien, guarda el registro
        $inicio = Carbon::parse($request->fecha_I)->startOfDay();
        $corte = Carbon::parse($request->fecha_f)->endOfDay();
        
        Meses::create([
            'fecha_I' => $inicio->toDateString(),
            'fecha_f' => $corte->toDateString(),
            'id_empresa' => $id_empresa
        ]);

        return redirect()->back()->with('success', 'Mes registrado correctamente');
        
    }

   // =================================================================

    public function updateMes(Request $request, $id_mes)
    {
        $mes = Meses::findOrFail($id_mes);
        
        // Ejecutar todas las validaciones, excluyendo el registro actual
        $errorMensaje = $this->validarFechas($request, $mes->id_empresa, $id_mes);
        
        if ($errorMensaje) {
            return redirect()->back()
                ->with('errorMensaje', $errorMensaje)
                ->with('mostrarModal', true)
                ->withInput();
        }
        
        // Si todo está bien, actualiza el registro
        $inicio = Carbon::parse($request->fecha_I)->startOfDay();
        $corte = Carbon::parse($request->fecha_f)->endOfDay();
        
        $mes->update([
            'fecha_I' => $inicio->toDateString(),
            'fecha_f' => $corte->toDateString(),
        ]);

        return redirect()->back()->with('success', 'Mes actualizado correctamente');
    }

   // =================================================================

    public function delMes($id_mes)
    {
        try {
            $mes = Meses::findOrFail($id_mes);
            $mes->delete();
            
            return redirect()->back()
                ->with('success', 'Mes eliminado correctamente');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al eliminar el mes');
        }
    }
}