@extends('layouts.plantilla')

@section('title', 'Editar empresa')

@section('titular')
    <x-navbar-3>Editar empresa</x-navbar-3>
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
        border-radius: 20px;
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
    }
    .input-dark:focus { border-color: #6dacd6 !important; box-shadow: 0 0 0 0.25rem rgba(109, 172, 214, 0.1) !important; }

    .file-box {
        background: #141619;
        border: 1px solid #2d3035;
        border-radius: 12px;
        padding: 12px;
        position: relative;
    }
    .file-label { font-size: 0.75rem; color: #6dacd6; font-weight: 700; text-transform: uppercase; margin-bottom: 8px; display: block; }
    .status-badge {
        font-size: 0.65rem;
        padding: 2px 8px;
        border-radius: 10px;
        position: absolute;
        top: 10px;
        right: 10px;
    }
    .badge-exists { background: rgba(109, 172, 214, 0.2); color: #6dacd6; }
</style>

<div class="container py-5">
    <div class="form-card-custom shadow-lg">
        <form action="/upEmpresa/{{$empresa_mod->id_empresa}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-lg-3 profile-section mb-4 mb-lg-0">
                    <div class="profile-upload-container">
                        <img src="{{ url('storage/' . $empresa_mod->foto) }}" id="profileImg" class="profile-img-preview" alt="Logo">
                        <input type="file" id="fotoEmpresa" accept="image/*" name="fotoEmpresa" class="d-none">
                        <button type="button" id="btnEditFoto" class="btn-edit-photo">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                    </div>
                    <div class="text-center mt-3">
                        <span class="fw-bold d-block">Logotipo Actual</span>
                        <span class="small text-muted">Pega para actualizar</span>
                    </div>
                </div>

                <div class="col-lg-9 ps-lg-5">
                    <h4 class="mb-4 text-info fw-light">Modificar Información</h4>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="file-label">Nombre Comercial</label>
                            <input type="text" name="nombre" class="form-control input-dark" required value="{{ $empresa_mod->nombre }}">
                        </div>
                        <div class="col-md-6">
                            <label class="file-label">Nombre del Encargado</label>
                            <input type="text" name="encargado" class="form-control input-dark" required value="{{ $empresa_mod->encargado }}">
                        </div>
                        <div class="col-md-12">
                            <label class="file-label">Ubicación Física</label>
                            <input type="text" name="ubicacion" class="form-control input-dark" value="{{ $empresa_mod->ubicacion }}">
                        </div>
                    </div>

                    <div class="row mt-4 g-3">
                        <div class="col-12">
                            <p class="file-label border-bottom pb-2" style="color: #a0a0a0;">Documentos Registrados (Formatos: PDF, Imagen)</p>
                        </div>
                        
                        @php
                            $docs = [
                                'calendario' => 'Calendario',
                                'esquemas' => 'Esquemas',
                                'especificaciones' => 'Especificaciones'
                            ];
                        @endphp

                        @foreach($docs as $campo => $titulo)
                        <div class="col-md-4">
                            <div class="file-box">
                                @if($empresa_mod->$campo)
                                    <span class="status-badge badge-exists"><i class="fa-solid fa-file-circle-check"></i> Registrado</span>
                                @endif
                                <label class="file-label">{{ $titulo }}</label>
                                <input type="file" name="{{ $campo }}" accept="application/pdf, image/*" class="form-control form-control-sm input-dark">
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="mt-5 d-flex justify-content-between align-items-center">
                        <a href="/" class="small text-decoration-none"><i class="fa-solid fa-arrow-left me-1"></i> Regresar</a>
                        <button type="submit" class="btn btn-lg px-5" style="background-color: #1c2a35; color: #6dacd6; border: 1px solid #243b4a; border-radius: 12px;">
                            <i class="fa-solid fa-arrows-rotate me-2"></i> Actualizar Registro
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