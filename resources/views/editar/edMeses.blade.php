@extends('layouts.plantilla')

@section('tittle')
    Editar mes
@endsection

@section('titular')
    <x-navbar-3>
        Editar mes
    </x-navbar-3>
@endsection

@section('contenido')
<style>
    .form-card-minimal { background-color: #1a1c20; border: 1px solid #2d3035; border-radius: 16px; }
    .input-dark { 
        background-color: #0f1012; 
        border: 1px solid #2d3035; 
        color: #a0a0a0; 
        border-radius: 8px; 
        padding: 0.6rem 1rem;
        color-scheme: dark; /* Icono calendario blanco */
    }
    .input-dark:focus { background-color: #141619; border-color: #4a4d55; color: #fff; outline: none; }
    .form-label-dark { color: #a0a0a0; font-size: 0.85rem; margin-bottom: 0.4rem; }
</style>

<div class="container py-4">
  <div class="form-card-minimal p-4 mx-auto" style="max-width: 450px;">
    
    <div class="text-center mb-4">
        <h5 class="text-light">Modificar Periodo</h5>
    </div>

    <form action="/upMes/{{$mes_mod->id_mes}}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

      <div class="row g-3 mb-4">
          <div class="col-6">
            <label for="fecha_I" class="form-label-dark">Fecha Inicio</label>
            <input type="date" name="fecha_I" id="fechaInicio" class="form-control input-dark" value="{{$mes_mod->fecha_I}}">
          </div>

          <div class="col-6">
                <label for="fecha_f" class="form-label-dark">Fecha Fin</label>
                <input type="date" name="fecha_f" id="fechaCorte" class="form-control input-dark" value="{{$mes_mod->fecha_f}}">
          </div>
      </div>

      <button type="submit" class="btn w-100" style="background-color: #1c2a35; color: #6dacd6; border: 1px solid #243b4a;">
          <i class="fa-solid fa-floppy-disk me-2"></i> Actualizar Fechas
      </button>
    </form>
  </div>
</div>
@endSection