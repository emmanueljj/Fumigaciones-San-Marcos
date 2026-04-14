<?php

namespace App\Http\Controllers;

use App\Models\Empresas;
use Illuminate\Http\Request;
use App\Models\Meses;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class mesesController extends Controller
{
    //  * Valida los campos de fecha (que no estén vacíos y que fecha_f sea posterior a fecha_I)

   // 1. Limpiamos la validación básica con mensajes personalizados directos
    private function validarCamposFechas(Request $request) {
        $rules = [
            'fecha_I' => 'required|date',
            'fecha_f' => 'required|date|after:fecha_I',
        ];

        $messages = [
            'fecha_I.required' => 'La fecha de inicio es obligatoria.',
            'fecha_f.required' => 'La fecha de fin es obligatoria.',
            'fecha_f.after'    => 'La fecha de finalización debe ser posterior a la de inicio.',
        ];

        try {
            $request->validate($rules, $messages);
            return null; 
        } catch (ValidationException $e) {
            // Retornamos el primer error encontrado de forma limpia
            return collect($e->errors())->flatten()->first();
        }
    }


    private function validarPeriodoMensual(Carbon $inicio, Carbon $corte)
    {
        // Calculamos lo que sería un mes exacto menos un día
        $finEsperado = (clone $inicio)->addMonthNoOverflow()->subDay();

        if (!$corte->isSameDay($finEsperado)) {
            return "Para una suscripción mensual, si inicia el " . $inicio->format('d/m/Y') . 
                ", el periodo debe terminar exactamente el " . $finEsperado->format('d/m/Y') . 
                " (un día antes de cumplir el mes).";
        }
        return null;
    }

    //  Verifica que no haya solapamiento con periodos existentes

    private function validarSolapamiento($id_empresa, Carbon $inicio, Carbon $corte, $excluirId = null)
    {
        $query = Meses::where('id_empresa', $id_empresa)
            ->where(function ($query) use ($inicio, $corte) {
                // Un periodo solapa si su inicio es ANTES del fin solicitado 
                // Y su fin es DESPUÉS del inicio solicitado.
                $query->where('fecha_I', '<', $corte->toDateString())
                    ->where('fecha_f', '>', $inicio->toDateString());
            });
        
        if ($excluirId) $query->where('id_mes', '!=', $excluirId);
        
        if ($query->exists()) {
            return 'Ya existe un periodo registrado que cubre parte de estas fechas.';
        }
        return null;
    }


    //  * Ejecuta todas las validaciones de fechas y retorna el primer error encontrado o null

    private function validarFechas(Request $request, $id_empresa, $excluirId = null)
    {
        // Paso A: Validar presencia y formato básico
        $error = $this->validarCamposFechas($request);
        if ($error) return $error;
        
        // Paso B: Convertir a Carbon UNA SOLA VEZ para todo el proceso
        $inicio = Carbon::parse($request->fecha_I)->startOfDay();
        $corte = Carbon::parse($request->fecha_f)->endOfDay();
        
        // Paso C: Validar lógica de mes (Suscripción)
        // AHORA PASAMOS LOS OBJETOS CARBON, NO STRINGS
        $error = $this->validarPeriodoMensual($inicio, $corte);
        if ($error) return $error;
        
        // Paso D: Validar que no choque con otros registros
        $error = $this->validarSolapamiento($id_empresa, $inicio, $corte, $excluirId);
        if ($error) return $error;
        
        return null;
    }
  // =================================================================

    public function verMeses($id_empresa)
        {
            $meses = Meses::where('id_empresa', $id_empresa)->orderBy('fecha_I', 'asc')->get();
            $empresa = Empresas::find($id_empresa); // o ->where('id_empresa', $id_empresa)->first();
            return view('meses', compact('meses', 'empresa'));
        }

    public function ag_meses($id_empresa) {
            $empresa = Empresas::find($id_empresa);
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
   // =================================================================
    public function generarPDF($id_mes) {
        $mes = Meses::with(['relEmpresa', 'servicios.productos'])->findOrFail($id_mes);
        $empresa = $mes->relEmpresa;

        // Función auxiliar para convertir a Base64 y no fallar en Windows
        $toBase64 = function($path) {
            $fullPath = storage_path('app/public/' . $path);
            if (file_exists($fullPath)) {
                $type = pathinfo($fullPath, PATHINFO_EXTENSION);
                $data = file_get_contents($fullPath);
                return 'data:image/' . $type . ';base64,' . base64_encode($data);
            }
            return null;
        };

        // Procesar Esquemas
        $esquemasProcesados = [];
        if (is_array($empresa->esquemas)) {
            foreach ($empresa->esquemas as $img) {
                $esquemasProcesados[] = $toBase64($img);
            }
        }

        // Procesar Fichas Técnicas de Productos usados
        $fichasProcesadas = [];
        foreach ($mes->servicios as $servicio) {
            foreach ($servicio->productos as $producto) {
                if (is_array($producto->fichaTecnica)) {
                    foreach ($producto->fichaTecnica as $img) {
                        $fichasProcesadas[] = $toBase64($img);
                    }
                }
            }
        }
        
        $pdf = PDF::loadView('pdf.reporte_mensual', [
            'mes'       => $mes,
            'empresa'   => $empresa,
            'servicios' => $mes->servicios, // <--- ¡ESTA ES LA LÍNEA QUE FALTA!
            'esquemas'  => $esquemasProcesados,
            'fichas'    => $fichasProcesadas
        ]);

        return $pdf->stream("Reporte_{$empresa->nombre}.pdf");
    }
}