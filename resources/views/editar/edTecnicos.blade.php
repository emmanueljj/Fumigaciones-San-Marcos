@extends('layouts.plantilla')

@section('tittle', 'Editar Técnico')

@section('titular')
<x-navbar-3>
    Editar técnicos  
</x-navbar-3>
@endSection

@section('contenido')
<style>
    /* Estilos reusables Dark */
    .form-card-minimal { background-color: #1a1c20; border: 1px solid #2d3035; border-radius: 16px; }
    .input-dark { background-color: #0f1012; border: 1px solid #2d3035; color: #e0e0e0; border-radius: 8px; padding: 0.6rem 1rem; }
    .input-dark:focus { background-color: #141619; border-color: #4a4d55; color: #fff; outline: none; }
    .form-label-dark { color: #a0a0a0; font-size: 0.85rem; margin-bottom: 0.4rem; }
</style>

<div class="container py-4">
  <div class="form-card-minimal p-4 mx-auto" style="max-width: 400px;">
    
    <div class="text-center mb-4">
        <h5 class="text-light"><i class="fa-solid fa-user-pen me-2"></i>Editar Datos</h5>
    </div>

    <form action="/upTecnico/{{$tec_mod->id_tec}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')  
        
        <div class="mb-3">
            <label for="nombre" class="form-label-dark">Nombre Completo</label>
            <input type="text" class="form-control input-dark" id="nombre" name="nombre" value="{{ $tec_mod->nombre }}">
        </div>

        <div class="mb-4">
            <label for="clave" class="form-label-dark">Clave de Empleado</label>
            <div class="input-group">
                <span class="input-group-text bg-dark border-secondary text-muted" style="border-color: #2d3035;">#</span>
                <input type="text" class="form-control input-dark" id="clave" name="clave" value="{{ $tec_mod->clave }}">
            </div>
        </div>

        <button type="submit" class="btn w-100" style="background-color: #1c2a35; color: #6dacd6; border: 1px solid #243b4a;">
            <i class="fa-solid fa-floppy-disk me-2"></i> Guardar Cambios
        </button>
    </form>
  </div>
</div>
@endSection