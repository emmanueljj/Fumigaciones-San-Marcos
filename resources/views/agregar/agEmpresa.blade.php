@extends('layouts.plantilla')

@section('tittle', 'Agregar empresa')

@section('titular')
    <x-navbar-3>
        Agregar empresa
    </x-navbar-3>
@endsection

@section('contenido')
<style>
    /* Estilos existentes */
    .profile-upload-container {
        position: relative;
        width: 100px;
        height: 100px;
        margin: 0 auto;
    }
    .profile-img-preview {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid #2d3035;
        background-color: #0f1012;
    }
    .btn-edit-photo {
        position: absolute;
        bottom: 0;
        right: 0;
        background-color: #6dacd6;
        color: #1a1c20;
        border: none;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: transform 0.2s;
        box-shadow: 0 4px 10px rgba(0,0,0,0.3);
    }
    .btn-edit-photo:hover {
        transform: scale(1.1);
        background-color: #fff;
    }
    /* Estilo para indicar que se puede pegar */
    .paste-hint {
        font-size: 0.75rem;
        color: #6dacd6;
        opacity: 0.8;
    }
</style>

<div class="container py-4">
    <div class="form-card-minimal p-4 mx-auto" style="max-width: 400px; background-color: #1a1c20; border: 1px solid #2d3035; border-radius: 16px;">
        
        <form action="/addEmpresa" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4 text-center">
                <div class="profile-upload-container">
                    <img src="{{ url('imagenes/profile.jpg') }}" id="profileImg" class="profile-img-preview" alt="Logo Empresa">
                    
                    <input type="file" id="fotoEmpresa" accept="image/*" name="fotoEmpresa" class="d-none">
                    
                    <button type="button" id="btnEditFoto" class="btn-edit-photo" aria-label="Subir foto">
                        <i class="fa-solid fa-camera fa-xs"></i>
                    </button>
                </div>
                <p class="small mt-2 mb-0">Logotipo de la empresa</p>
                <span class="paste-hint">(Puedes pegar una imagen con Ctrl+V)</span>
            </div>

            <div class="mb-3">
                <label for="nombre" class="form-label-dark small fw-bold">Nombre Comercial</label>
                <input type="text" name="nombre" class="form-control input-dark" id="nombre" 
                       style="background-color: #0f1012; border: 1px solid #2d3035; color: #fff;">
            </div>

            <div class="mb-4">
                <label for="encargado" class="form-label-dark small fw-bold">Nombre del Encargado</label>
                <input type="text" name="encargado" class="form-control input-dark" id="encargado"
                       style="background-color: #0f1012; border: 1px solid #2d3035; color: #fff;">
            </div>

            <button type="submit" class="btn w-100" style="background-color: #1c2a35; color: #6dacd6; border: 1px solid #243b4a;">
                <i class="fa-solid fa-floppy-disk me-2"></i> Guardar Empresa
            </button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const btnEditFoto = document.getElementById('btnEditFoto');
        const fotoInput = document.getElementById('fotoEmpresa');
        const profileImage = document.getElementById('profileImg');

        // Función para actualizar la vista previa
        function updatePreview(file) {
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) { profileImage.src = e.target.result; }
                reader.readAsDataURL(file);
            }
        }

        // Click en el botón de cámara
        btnEditFoto.addEventListener('click', function() { fotoInput.click(); });

        // Cambio manual de archivo
        fotoInput.addEventListener('change', function(event) {
            updatePreview(event.target.files[0]);
        });

        // LÓGICA PARA PEGAR IMAGEN
        document.addEventListener('paste', function (e) {
            const items = (e.clipboardData || e.originalEvent.clipboardData).items;
            
            for (let index in items) {
                const item = items[index];
                if (item.kind === 'file' && item.type.startsWith('image/')) {
                    const blob = item.getAsFile();
                    
                    // 1. Mostrar la vista previa
                    updatePreview(blob);

                    // 2. Sincronizar con el input file (necesario para que se envíe en el POST)
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(blob);
                    fotoInput.files = dataTransfer.files;
                }
            }
        });
    });
</script>
@endsection