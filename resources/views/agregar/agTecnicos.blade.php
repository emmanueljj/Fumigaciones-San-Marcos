@extends('layouts.plantilla')

@section('tittle', 'Agregar Técnico')

@section('titular')
<x-navbar>
    Agregar técnicos  
</x-navbar>
@endSection

@section('contenido')
<style>
    /* Asegúrate de tener los estilos de .form-card-minimal, .input-dark, etc. aquí o en tu CSS global */
    .form-card-minimal { background-color: #1a1c20; border: 1px solid #2d3035; border-radius: 16px; }
    .input-dark { background-color: #0f1012; border: 1px solid #2d3035; color: #e0e0e0; border-radius: 8px; padding: 0.6rem 1rem; }
    .input-dark:focus { background-color: #141619; border-color: #4a4d55; color: #fff; outline: none; }
    .form-label-dark { color: #a0a0a0; font-size: 0.85rem; margin-bottom: 0.4rem; }
    .btn-save-minimal { background-color: #1c2a35; color: #6dacd6; border: 1px solid #243b4a; width: 100%; padding: 0.6rem; border-radius: 8px; transition: all 0.2s; }
    .btn-save-minimal:hover { background-color: #243b4a; color: #fff; }
</style>

<div class="container py-4">
  <div class="form-card-minimal p-4 mx-auto" style="max-width: 400px;">
    
    <div class="text-center mb-4">
        <h5 class="mt-2 text-light">Registrar Técnico</h5>
    </div>

    <form action="/addTecnicos" method="POST" enctype="multipart/form-data">
      @csrf
      
      <div class="mb-3">
        <label for="nombre" class="form-label-dark">Nombre Completo</label>
        <input type="text" class="form-control input-dark" id="nombre" name="nombre" placeholder="Nombre del técnico">
      </div>

      <div class="mb-4">
        <label for="clave" class="form-label-dark">Clave de Empleado</label>
        <div class="input-group">
            <span class="input-group-text bg-dark border-secondary text-muted" style="border-color: #2d3035;">#</span>
            <input type="text" class="form-control input-dark" id="clave" name="clave" placeholder="Ej. TEC-001">
        </div>
      </div>

      <button type="submit" class="btn btn-save-minimal">
        <i class="fa-solid fa-floppy-disk me-2"></i> Registrar
      </button>
    </form>
  </div>
</div>
@endSection