@extends('layouts.plantilla')

@section('tittle')
    Agregar mes para {{ $empresa->nombre}}
@endsection

@section('titular')
    <x-navbar :empresa="$empresa">
        Agregar mes
    </x-navbar>
@endsection


@section('contenido')
  <div class="form-container p-4 bg-light rounded shadow-sm mx-auto formulario-content" style="max-width: 400px;">
    
    <!-- Formulario -->
    <form action="/addMes/{{$empresa->id_empresa}}" method="POST" enctype="multipart/form-data">
    @csrf

      <div class="mb-3">
        <label for="fecha_I" class="form-label">Fecha Inicio</label>
        <input type="date" name="fecha_I" id="fechaInicio" class="form-control" >
      </div>

      <div class="mb-3">
            <label for="fecha_f" class="form-label">Fecha</label>
            <input type="date" name="fecha_f" id="fechaCorte" class="form-control">
      </div>

      <div class="text-end">
        <button type="submit" class="btn btn-primary">
          <i class="fa-solid fa-floppy-disk"></i>
        </button>
      </div>
    </form>
  </div>
@endSection

{{-- value="{{ date('Y-m-d') }}" PARA RELLENAR FECHA--}}
