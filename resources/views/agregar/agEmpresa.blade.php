@extends('layouts.plantilla')

@section('title', 'Agregar Empresa')

@section('titular')
    <x-navbar-3>Agregar empresa</x-navbar-3>
@endsection

@section('contenido')
<style>
    .form-card-custom {
        background-color: #1a1c20;
        border: 1px solid #2d3035;
        border-radius: 20px;
        color: #fff;
        padding: 2rem;
    }
    .profile-section {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        border-right: 1px solid #2d3035;
    }
    .profile-upload-container {
        position: relative;
        width: 130px;
        height: 130px;
    }
    .profile-img-preview {
        width: 100%; height: 100%;
        object-fit: cover;
        border-radius: 20px; /* Estilo moderno cuadrado-redondeado */
        border: 2px solid #2d3035;
        background-color: #0f1012;
    }
    .btn-edit-photo {
        position: absolute; bottom: -10px; right: -10px;
        background-color: #6dacd6; color: #1a1c20;
        border: none; width: 38px; height: 38px;
        border-radius: 12px; display: flex;
        align-items: center; justify-content: center;
        cursor: pointer; transition: 0.3s;
        box-shadow: 0 4px 15px rgba(0,0,0,0.4);
    }
    .btn-edit-photo:hover { transform: translateY(-3px); background-color: #fff; }
    
    .input-dark {
        background-color: #0f1012 !important;
        border: 1px solid #2d3035 !important;
        color: #fff !important;
        border-radius: 10px !important;
        padding: 10px 15px !important;
    }
    .input-dark:focus { border-color: #6dacd6 !important; box-shadow: 0 0 0 0.25rem rgba(109, 172, 214, 0.1) !important; }

    .file-box {
        background: #141619;
        border: 1px dashed #2d3035;
        border-radius: 12px;
        padding: 12px;
        transition: 0.3s;
    }
    .file-box:hover { border-color: #6dacd6; background: #1a1c20; }
    .file-label { font-size: 0.75rem; color: #6dacd6; font-weight: 700; text-transform: uppercase; margin-bottom: 8px; display: block; }
    .paste-hint { font-size: 0.7rem; color: #a0a0a0; margin-top: 5px; display: block; }
</style>

<div class="container py-1">
    <div class="form-card-custom shadow-lg">
        <form action="/addEmpresa" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-lg-3 profile-section mb-4 mb-lg-0">
                    <div class="profile-upload-container">
                        <img src="{{ url('imagenes/profile.jpg') }}" id="profileImg" class="profile-img-preview" alt="Logo">
                        <input type="file" id="fotoEmpresa" accept="image/*" name="fotoEmpresa" class="d-none">
                        <button type="button" id="btnEditFoto" class="btn-edit-photo">
                            <i class="fa-solid fa-camera"></i>
                        </button>
                    </div>
                    <div class="text-center mt-3">
                        <span class="fw-bold d-block">Logotipo</span>
                        <span class="paste-hint">Pega con Ctrl + V</span>
                    </div>
                </div>

                <div class="col-lg-9 ps-lg-5">
                    <h4 class="mb-4 text-info fw-light">Información de la Empresa</h4>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="file-label">Nombre Comercial</label>
                            <input type="text" name="nombre" class="form-control input-dark" required value="{{ old('nombre') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="file-label">Nombre del Encargado</label>
                            <input type="text" name="encargado" class="form-control input-dark" required value="{{ old('encargado') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="file-label">Ubicación Física</label>
                            <input type="text" name="ubicacion" class="form-control input-dark" value="{{ old('ubicacion') }}">
                        </div>

                        <div class="col-md-6">
                            <label class="file-label">Correo electronico</label>
                            
                            <input type="email" name="correo" class="form-control input-dark" value="{{ old('correo') }}"
                            placeholder="ejemplo@empresa.com">
                        </div>
                    </div>

                    <div class="row mt-4 g-3">
                        <div class="col-12">
                            <p class="file-label border-bottom pb-2" style="color: #a0a0a0;">Documentos (Formatos: PDF, JPG, PNG)</p>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="file-box text-center">
                                <label class="file-label"><i class="fa-solid fa-calendar-check me-2"></i>Calendario</label>
                                <input type="file" name="calendario" accept="application/pdf, image/*" class="form-control form-control-sm input-dark">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="file-box text-center">
                                <label class="file-label"><i class="fa-solid fa-diagram-project me-2"></i>Esquemas</label>
                                <input type="file" name="esquemas" accept="application/pdf, image/*" class="form-control form-control-sm input-dark">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="file-box text-center">
                                <label class="file-label"><i class="fa-solid fa-file-contract me-2"></i>Especificaciones</label>
                                <input type="file" name="especificaciones" accept="application/pdf, image/*" class="form-control form-control-sm input-dark">
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 d-flex justify-content-end">
                        <button type="submit" class="btn btn-lg px-5" style="background-color: #1c2a35; color: #6dacd6; border: 1px solid #243b4a; border-radius: 12px;">
                            <i class="fa-solid fa-save me-2"></i> Registrar Empresa
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const btnEditFoto = document.getElementById('btnEditFoto');
        const fotoInput = document.getElementById('fotoEmpresa');
        const profileImage = document.getElementById('profileImg');

        function updatePreview(file) {
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = (e) => profileImage.src = e.target.result;
                reader.readAsDataURL(file);
            }
        }

        btnEditFoto.addEventListener('click', () => fotoInput.click());
        fotoInput.addEventListener('change', (e) => updatePreview(e.target.files[0]));

        document.addEventListener('paste', (e) => {
            const items = (e.clipboardData || e.originalEvent.clipboardData).items;
            for (let item of items) {
                if (item.kind === 'file' && item.type.startsWith('image/')) {
                    const blob = item.getAsFile();
                    updatePreview(blob);
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(blob);
                    fotoInput.files = dataTransfer.files;
                }
            }
        });
    });
</script>
@endsection