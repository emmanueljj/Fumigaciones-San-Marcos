@extends('layouts.plantilla')

@section('tittle', 'Agregar Producto')
    
@section('titular')
<x-navbar>
    Agregar productos
</x-navbar>
@endSection

@section('contenido')
<style>
    .form-card-minimal {
        background-color: #1a1c20;
        border: 1px solid #2d3035;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    }
    .form-label-dark {
        color: #a0a0a0;
        font-size: 0.85rem;
        font-weight: 500;
        margin-bottom: 0.4rem;
    }
    .input-dark {
        background-color: #0f1012;
        border: 1px solid #2d3035;
        color: #e0e0e0;
        border-radius: 8px;
        padding: 0.6rem 1rem;
        transition: all 0.3s ease;
    }
    .input-dark:focus {
        background-color: #141619;
        border-color: #4a4d55;
        box-shadow: none; /* Quitamos el glow azul default */
        color: #fff;
    }
    .btn-save-minimal {
        background-color: #1c2a35; /* Azul oscuro */
        color: #6dacd6;
        border: 1px solid #243b4a;
        width: 100%;
        padding: 0.6rem;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.2s;
    }
    .btn-save-minimal:hover {
        background-color: #243b4a;
        color: #fff;
    }
</style>

<div class="container py-4">
    <div class="form-card-minimal p-4 mx-auto" style="max-width: 450px;">
        
        <div class="text-center mb-4">
            <h5 class="mt-2 text-light">Nuevo Producto</h5>
        </div>

        <form action="/addProductos" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-3">
                <label for="nombre" class="form-label-dark">Nombre del Producto</label>
                <input type="text" class="form-control input-dark" id="nombre" name="nombre" placeholder="Ej. Cipermetrina">
            </div>

            <div class="row g-3 mb-3">
                <div class="col-6">
                    <label for="concentracion" class="form-label-dark">Concentración</label>
                    <input type="text" class="form-control input-dark" id="concentracion" name="concentracion" placeholder="Ej. 20%">
                </div>
                <div class="col-6">
                    <label for="metodo" class="form-label-dark">Método</label>
                    <input type="text" class="form-control input-dark" id="metodo" name="metodo" placeholder="Ej. Aspersión">
                </div>
            </div>

            <div class="mb-4">
                <label for="plaga" class="form-label-dark">Plaga Objetivo</label>
                <div class="input-group">
                    <span class="input-group-text bg-dark border-secondary text-muted" style="border-color: #2d3035;"><i class="fa-solid fa-bug"></i></span>
                    <input type="text" class="form-control input-dark" id="plaga" name="plaga" placeholder="Ej. Rastreras">
                </div>
            </div>

            <button type="submit" class="btn btn-save-minimal">
                <i class="fa-solid fa-floppy-disk me-2"></i> Guardar Producto
            </button>
        </form>
    </div>
</div>
@endSection