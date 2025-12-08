@extends('layouts.plantilla')

@section('tittle', 'Ag_prods')
    
@section('titular')
<x-navbar>
    Agregar productos
</x-navbar>
@endSection


    <!-- Formulario -->
@section('contenido')
<div class="form-container p-4 bg-light rounded shadow-sm mx-auto formulario-content" style="max-width: 400px;">

    <form action="/addProductos" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre">
        </div>

        <div class="mb-3">
            <label for="concentracion" class="form-label">concentracion</label>
            <input type="text" class="form-control" id="concentracion" name="concentracion">
        </div>
        
        <div class="mb-3">
            <label for="metodo" class="form-label">metodo</label>
            <input type="text" class="form-control" id="metodo" name="metodo">
        </div>

        <div class="mb-3">
            <label for="plaga" class="form-label">plaga</label>
            <input type="text" class="form-control" id="plaga" name="plaga">
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary">
            <i class="fa-solid fa-floppy-disk"></i>
            </button>
        </div>
    </form>
</div>
@endSection

