@extends('layouts.plantilla')

@section('tittle', 'Ag_tecnicos')

@section('titular')
<x-navbar>
    Agregar técnicos  
</x-navbar>
@endSection

@section('contenido')
  <div class="form-container p-4 bg-light rounded shadow-sm mx-auto formulario-content" style="max-width: 400px;">
    
    <!-- Formulario -->
    <form action="/upTec" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="mb-3">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $tecnico->nombre }}">
      </div>

      <div class="mb-3">
        <label for="id_tec" class="form-label">Clave</label>
        <input type="text" class="form-control" id="id_tec" name="id_tec" value="{{ $tecnico->id_tec }}">
      </div>

      <div class="text-end">
        <button type="submit" class="btn btn-primary">
          <i class="fa-solid fa-floppy-disk"></i>
        </button>
      </div>
    </form>
  </div>

@endSection




