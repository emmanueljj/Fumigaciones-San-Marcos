@extends('layouts.plantilla')

@section('title', 'Agregar Producto')
    
@section('titular')
<x-navbar-3>
    Agregar productos
</x-navbar-3>
@endsection

@section('contenido')
<style>
    .form-card-minimal {
        background-color: #1a1c20;
        border: 1px solid #2d3035;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        color: #fff;
    }
    .form-label-dark {
        color: #a0a0a0;
        font-size: 0.85rem;
        font-weight: 500;
        margin-bottom: 0.4rem;
        display: block;
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
        border-color: #6dacd6;
        box-shadow: none;
        color: #fff;
        outline: none;
    }
    
    /* Zona de carga de Ficha Técnica */
    .file-upload-wrapper {
        border: 2px dashed #2d3035;
        border-radius: 12px;
        padding: 1.5rem;
        background-color: #0f1012;
        text-align: center;
        cursor: pointer;
        transition: 0.3s;
    }
    .file-upload-wrapper:hover {
        border-color: #6dacd6;
        background-color: #141619;
    }
    .file-upload-wrapper i { color: #6dacd6; margin-bottom: 10px; }
    
    .btn-save-minimal {
        background-color: #1c2a35;
        color: #6dacd6;
        border: 1px solid #243b4a;
        width: 100%;
        padding: 0.7rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.2s;
    }
    .btn-save-minimal:hover {
        background-color: #243b4a;
        color: #fff;
    }
    .status-text { font-size: 0.75rem; color: #6dacd6; display: none; margin-top: 8px; }
</style>

<div class="container py-4">
    <div class="form-card-minimal p-4 mx-auto" style="max-width: 450px;">
        
        <div class="text-center mb-4">
            <h5 class="mt-2 text-light fw-light">Registro de Químicos</h5>
            <p class="small text-muted">Ingresa los datos técnicos del producto</p>
        </div>

        <form action="/addProductos" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-3">
                <label for="nombre" class="form-label-dark">Nombre del Producto</label>
                <input type="text" class="form-control input-dark w-100" id="nombre" name="nombre" 
                       placeholder="Ej. Cipermetrina 200">
            </div>

            <div class="mb-3">
                <label for="concentracion" class="form-label-dark">Concentración</label>
                <div class="input-group">
                    <span class="input-group-text bg-dark border-secondary text-muted" style="border-color: #2d3035;">
                        <i class="fa-solid fa-droplet fa-sm"></i>
                    </span>
                    <input type="text" class="form-control input-dark" id="concentracion" name="concentracion" 
                           placeholder="Ej. 20% C.E.">
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label-dark">Ficha Técnica (PDF o Imagen)</label>
                <div class="file-upload-wrapper" onclick="document.getElementById('fichaTecnica').click()">
                    <i class="fa-solid fa-file-pdf fa-2x"></i>
                    <p class="small mb-0 text-muted" id="fileName">Haz clic para subir archivo</p>
                    <div id="fileStatus" class="status-text fw-bold">Archivo seleccionado <i class="fa-solid fa-check"></i></div>
                </div>
                <input type="file" id="fichaTecnica" name="fichaTecnica" class="d-none" 
                       accept="application/pdf, image/*" onchange="updateFileName(this)">
                <small class="text-muted d-block mt-2" style="font-size: 0.7rem;">* No se aceptan archivos .doc o similares</small>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-save-minimal">
                    <i class="fa-solid fa-flask-vial me-2"></i> Guardar en Inventario
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function updateFileName(input) {
        const fileName = input.files[0] ? input.files[0].name : "Haz clic para subir archivo";
        document.getElementById('fileName').textContent = fileName;
        if(input.files[0]) {
            document.getElementById('fileStatus').style.display = 'block';
        }
    }
</script>
@endsection