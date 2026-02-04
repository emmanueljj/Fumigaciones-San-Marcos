@extends('layouts.plantilla')

@section('title', 'Agregar Empresa')

@section('titular')
    <x-navbar-3>Agregar empresa</x-navbar-3>
@endsection

@section('contenido')
<style>
    .form-card-custom { background-color: #1a1c20; border: 1px solid #2d3035; border-radius: 20px; color: #fff; padding: 2rem; }
    .profile-section { display: flex; flex-direction: column; align-items: center; justify-content: center; border-right: 1px solid #2d3035; }
    
    .profile-upload-container { 
        position: relative; width: 130px; height: 130px; 
        cursor: pointer; border-radius: 20px; transition: 0.3s;
    }
    .profile-upload-container.active-paste { outline: 3px solid #6dacd6; outline-offset: 5px; }
    .profile-img-preview { width: 100%; height: 100%; object-fit: cover; border-radius: 20px; border: 2px solid #2d3035; background-color: #0f1012; }
    
    .btn-edit-photo {
        position: absolute; bottom: -10px; right: -10px; background-color: #6dacd6; color: #1a1c20;
        border: none; width: 38px; height: 38px; border-radius: 12px; display: flex;
        align-items: center; justify-content: center; pointer-events: none;
    }
    
    .input-dark { background-color: #0f1012 !important; border: 1px solid #2d3035 !important; color: #fff !important; border-radius: 10px !important; padding: 10px 15px !important; }
    .input-dark:focus { border-color: #6dacd6 !important; outline: none; }

    .file-box { 
        background: #141619; border: 1px dashed #2d3035; border-radius: 12px; 
        padding: 15px; transition: 0.3s; min-height: 160px; 
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        cursor: pointer; outline: none;
    }
    .file-box:hover, .file-box:focus { border-color: #6dacd6; background: #1a1c20; }
    .file-box.active-paste { border-color: #6dacd6; background: rgba(109, 172, 214, 0.05); border-style: solid; }

    .file-label { font-size: 0.75rem; color: #6dacd6; font-weight: 700; text-transform: uppercase; margin-bottom: 8px; pointer-events: none; }
    .doc-preview { width: 100%; max-width: 120px; max-height: 80px; object-fit: contain; margin-top: 10px; display: none; border-radius: 5px; }
    .icon-placeholder { font-size: 1.5rem; opacity: 0.3; margin-bottom: 5px; pointer-events: none; }
</style>

<div class="container py-1">
    <div class="form-card-custom shadow-lg">
        <form action="/addEmpresa" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-3 profile-section mb-4 mb-lg-0">
                    <div class="profile-upload-container paste-area" data-input="fotoEmpresa" tabindex="0">
                        <img src="{{ url('imagenes/profile.jpg') }}" id="pv_fotoEmpresa" class="profile-img-preview" alt="Logo">
                        <input type="file" id="fotoEmpresa" accept="image/*" name="fotoEmpresa" class="d-none">
                        <div class="btn-edit-photo"><i class="fa-solid fa-camera"></i></div>
                    </div>
                    <div class="text-center mt-3">
                        <span class="fw-bold d-block">Logotipo</span>
                        <small class="opacity-50">Click o Pegar</small>
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
                            <label class="file-label">Correo Electrónico</label>
                            <input type="email" name="correo" class="form-control input-dark" required value="{{ old('correo') }}" placeholder="ejemplo@correo.com">
                        </div>
                        <div class="col-md-6">
                            <label class="file-label">Ubicación Física</label>
                            <input type="text" name="ubicacion" class="form-control input-dark" required value="{{ old('ubicacion') }}" placeholder="Calle, Número, Colonia">
                        </div>
                    </div>

                    <div class="row mt-4 g-3">
                        <div class="col-md-4">
                            <div class="file-box paste-area" data-input="inCalendario" tabindex="0">
                                <label class="file-label"><i class="fa-solid fa-calendar-check me-2"></i>Calendario</label>
                                <div id="ph_inCalendario" class="icon-placeholder"><i class="fa-regular fa-image"></i></div>
                                <img id="pv_inCalendario" class="doc-preview">
                                <input type="file" id="inCalendario" name="calendario" accept="image/*" class="d-none">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="file-box text-center" onclick="document.getElementById('inEsquemas').click()" style="cursor: pointer;">
                                <label class="file-label"><i class="fa-solid fa-diagram-project me-2"></i>Esquemas</label>
                                <div id="displayEsquemas" class="d-flex flex-column align-items-center justify-content-center">
                                    <div class="icon-shape mb-2" id="iconEsquemas" style="width: 45px; height: 45px; background: rgba(109, 172, 214, 0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #6dacd6;">
                                        <i class="fa-solid fa-file-pdf fa-xl"></i>
                                    </div>
                                    <span id="nameEsquemas" style="font-size: 0.75rem; color: #e0e0e0; max-width: 140px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        Subir plano PDF
                                    </span>
                                </div>
                                <input type="file" id="inEsquemas" name="esquemas" accept="application/pdf" class="d-none" onchange="updateFileName(this, 'nameEsquemas', 'iconEsquemas')">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="file-box paste-area" data-input="inEspec" tabindex="0">
                                <label class="file-label"><i class="fa-solid fa-file-contract me-2"></i>Especificaciones</label>
                                <div id="ph_inEspec" class="icon-placeholder"><i class="fa-regular fa-image"></i></div>
                                <img id="pv_inEspec" class="doc-preview">
                                <input type="file" id="inEspec" name="especificaciones" accept="image/*" class="d-none">
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
    function updateFileName(input, labelId, iconId) {
        const fileName = input.files[0] ? input.files[0].name : "Subir plano PDF";
        document.getElementById(labelId).innerText = fileName;
        if (input.files[0]) {
            document.getElementById(iconId).style.color = "#fff";
            document.getElementById(iconId).style.background = "#6dacd6";
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        let activeInputId = null;

        document.querySelectorAll('.paste-area').forEach(area => {
            area.addEventListener('click', function() { this.focus(); });
            area.addEventListener('focus', function() {
                activeInputId = this.dataset.input;
                this.classList.add('active-paste');
            });
            area.addEventListener('blur', function() { this.classList.remove('active-paste'); });
        });

        function updatePreview(file, inputId) {
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const previewImg = document.getElementById('pv_' + inputId);
                    const placeholder = document.getElementById('ph_' + inputId);
                    if (previewImg) { previewImg.src = e.target.result; previewImg.style.display = 'block'; }
                    if (placeholder) { placeholder.style.display = 'none'; }
                };
                reader.readAsDataURL(file);
            }
        }

        document.addEventListener('paste', function (e) {
            if (!activeInputId) return;
            const items = (e.clipboardData || e.originalEvent.clipboardData).items;
            for (let item of items) {
                if (item.kind === 'file' && item.type.startsWith('image/')) {
                    const blob = item.getAsFile();
                    const targetInput = document.getElementById(activeInputId);
                    updatePreview(blob, activeInputId);
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(blob);
                    targetInput.files = dataTransfer.files;
                }
            }
        });

        document.querySelectorAll('input[type="file"]').forEach(input => {
            input.addEventListener('change', function() {
                if(this.id !== 'inEsquemas') updatePreview(this.files[0], this.id);
            });
        });
    });
</script>
@endsection