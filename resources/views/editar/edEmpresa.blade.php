@extends('layouts.plantilla')

@section('tittle', 'Editar empresa')

@section('titular')
    <x-navbar-3>
        Editar empresa
    </x-navbar-3>
@endsection

@section('contenido')
<style>
    /* Estilos Dark Específicos */
    .form-card-minimal { background-color: #1a1c20; border: 1px solid #2d3035; border-radius: 16px; }
    .input-dark { background-color: #0f1012; border: 1px solid #2d3035; color: #e0e0e0; border-radius: 8px; padding: 0.6rem 1rem; }
    .input-dark:focus { background-color: #141619; border-color: #4a4d55; color: #fff; outline: none; }
    .form-label-dark { color: #a0a0a0; font-size: 0.85rem; margin-bottom: 0.4rem; }
    
    /* Foto Circular */
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
    .btn-edit-photo:hover { transform: scale(1.1); background-color: #fff; }
</style>

<div class="container py-4">
    <div class="form-card-minimal p-4 mx-auto" style="max-width: 400px;">
        <form action="/upEmpresa/{{$empresa_mod->id_empresa}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')  
            
            <div class="mb-4 text-center">
                <div class="profile-upload-container">
                    <img src="{{ url('storage/' . $empresa_mod->foto) }}" id="profileImg" class="profile-img-preview" alt="Foto Actual">
                    
                    <input type="file" id="fotoEmpresa" accept="image/*" name="fotoEmpresa" class="d-none">
                    
                    <button type="button" id="btnEditFoto" class="btn-edit-photo" aria-label="Editar foto">
                        <i class="fa-solid fa-pen-to-square fa-xs"></i>
                    </button>
                </div>
                <p class="text small mt-2">Logotipo Actual</p>
            </div>

            <div class="mb-3">
                <label for="nombre" class="form-label-dark">Nombre</label>
                <input type="text" name="nombre" class="form-control input-dark" id="nombre" value="{{$empresa_mod->nombre}}">
            </div>

            <div class="mb-4">
                <label for="encargado" class="form-label-dark">Encargado</label>
                <input type="text" name="encargado" class="form-control input-dark" id="encargado" value="{{$empresa_mod->encargado}}">
            </div>

            <button type="submit" class="btn w-100" style="background-color: #1c2a35; color: #6dacd6; border: 1px solid #243b4a;">
                <i class="fa-solid fa-floppy-disk me-2"></i> Actualizar Empresa
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