@extends('layouts.plantilla')

@section('tittle', 'Agregar empresa')

@section('titular')
    <x-navbar>
        Agregar empresa
    </x-navbar>
@endsection

@section('contenido')
<style>
    /* Estilos específicos para la foto */
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
                <p class="small mt-2">Logotipo de la empresa</p>
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

    btnEditFoto.addEventListener('click', function() { fotoInput.click(); });

    fotoInput.addEventListener('change', function(event) {
        if (event.target.files && event.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) { profileImage.src = e.target.result; }
            reader.readAsDataURL(event.target.files[0]);
        }
    });
});
</script>
@endsection