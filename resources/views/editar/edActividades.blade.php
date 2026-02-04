@extends('layouts.plantilla')

@section('title', 'Editar Actividad')

@section('titular')
<x-navbar-3 :id_mes="$id_mes" :empresa="$empresa">
    Editar Actividad
</x-navbar-3>
@endsection

@section('contenido')
<style>
    .card-dark { background-color: #1a1c20; border: 1px solid #2d3035; border-radius: 20px; color: #e0e0e0; }
    .input-dark { 
        background-color: #0f1012; border: 1px solid #2d3035; color: #e0e0e0 !important; 
        border-radius: 12px; padding: 0.7rem 1rem; transition: 0.3s;
    }
    .input-dark:focus { border-color: #6dacd6; outline: none; color: #6dacd6 !important; background-color: #141619; }
    .text-label { color: rgba(224, 224, 224, 0.5); font-size: 0.75rem; font-weight: 700; margin-bottom: 0.5rem; display: block; text-transform: uppercase; }

    /* Estilo para Zonas de Carga */
    .upload-zone-custom {
        border: 2px dashed #2d3035; border-radius: 16px; padding: 1.5rem;
        background-color: #0f1012; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer; text-align: center; position: relative; outline: none;
    }
    .upload-zone-custom:hover { border-color: #6dacd6; background-color: #141619; }
    
    /* Selección por Enfoque (Igual que en agregar empresa) */
    .upload-zone-custom:focus, .upload-zone-custom.active-paste { 
        border-color: #6dacd6; 
        background: rgba(109, 172, 214, 0.05);
        border-style: solid;
        box-shadow: 0 0 0 3px rgba(109, 172, 214, 0.1);
    }

    .preview-render { max-height: 150px; border-radius: 12px; display: none; margin: 10px auto 0; box-shadow: 0 10px 20px rgba(0,0,0,0.4); }
    .firma-render { max-height: 100px; filter: invert(0.9); } 

    .btn-back-minimal {
        background-color: transparent; color: rgba(224, 224, 224, 0.6);
        border: 1px solid #2d3035; border-radius: 12px; transition: 0.3s;
        text-decoration: none; font-size: 0.85rem; padding: 0.8rem;
    }
    .btn-back-minimal:hover { background-color: #2d3035; color: #fff; }

    .btn-save-custom {
        background-color: #1c2a35; color: #6dacd6; border: 1px solid #243b4a; 
        border-radius: 15px; padding: 0.8rem; font-weight: 600; transition: 0.3s;
    }
    .btn-save-custom:hover { background-color: #243b4a; color: #fff; transform: translateY(-2px); }

    input[type="time"] { color-scheme: dark; }
</style>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <form action="/updateActividades/{{$actividad->id}}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <input type="hidden" name="id_servicio" value="{{ $id_servicio }}">

                <div class="card-dark shadow-lg border-0">
                    <div class="card-body p-4 p-md-5">
                        <h4 class="fw-light mb-4 text-white">Modificar Actividad</h4>

                        <div class="row g-4 mb-4">
                            <div class="col-md-7">
                                <label class="text-label">Nombre de la Actividad / Plaga</label>
                                <input type="text" name="nombre" class="form-control input-dark" required 
                                       value="{{ old('nombre', $actividad->nombre) }}">
                            </div>
                            <div class="col-md-5">
                                <label class="text-label">Área intervenida</label>
                                <input type="text" name="area" class="form-control input-dark" required 
                                       value="{{ old('area', $actividad->area) }}">
                            </div>
                        </div>

                        <div class="row g-4 mb-4">
                            <div class="col-md-4">
                                <label class="text-label">Hora</label>
                                <input type="time" name="hora" class="form-control input-dark" required 
                                       value="{{ old('hora', \Carbon\Carbon::parse($actividad->hora)->format('H:i')) }}">
                            </div>
                            <div class="col-md-8">
                                <label class="text-label">Visto Bueno (Nombre)</label>
                                <input type="text" name="vbNombre" class="form-control input-dark" required 
                                       value="{{ old('vbNombre', $actividad->vbNombre) }}">
                            </div>
                        </div>

                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label class="text-label">Foto de Evidencia</label>
                                <div class="upload-zone-custom paste-area" data-input="foto" tabindex="0" onclick="document.getElementById('foto').click()">
                                    <div id="evidenciaPlaceholder" style="{{ $actividad->foto ? 'display:none' : '' }}">
                                        <i class="fa-solid fa-camera fa-lg mb-2" style="color: #6dacd6;"></i>
                                        <p class="small mb-0 text-white">Clic o Pegar</p>
                                    </div>
                                    <img id="previewFoto" class="preview-render" 
                                         src="{{ $actividad->foto ? asset('storage/' . $actividad->foto) : '' }}"
                                         style="{{ $actividad->foto ? 'display:block' : 'display:none' }}">
                                </div>
                                <input type="file" id="foto" name="foto" class="d-none" accept="image/*">
                            </div>

                            <div class="col-md-6">
                                <label class="text-label">Firma de Conformidad</label>
                                <div class="upload-zone-custom paste-area" data-input="vbFirma" tabindex="0" onclick="document.getElementById('vbFirma').click()">
                                    <div id="firmaPlaceholder" style="{{ $actividad->vbFirma ? 'display:none' : '' }}">
                                        <i class="fa-solid fa-signature fa-lg mb-2" style="color: #6dacd6;"></i>
                                        <p class="small mb-0 text-white">Clic o Pegar</p>
                                    </div>
                                    <img id="previewFirma" class="preview-render firma-render" 
                                         src="{{ $actividad->vbFirma ? asset('storage/' . $actividad->vbFirma) : '' }}"
                                         style="{{ $actividad->vbFirma ? 'display:block' : 'display:none' }}">
                                </div>
                                <input type="file" id="vbFirma" name="vbFirma" class="d-none" accept="image/*">
                            </div>
                        </div>

                        <div class="d-flex gap-3 mt-5">
                            <a href="/actividades/{{ $id_servicio }}" class="btn btn-back-minimal w-25 d-flex align-items-center justify-content-center">
                                Regresar
                            </a>
                            <button type="submit" class="btn btn-save-custom flex-grow-1">
                                <i class="fa-solid fa-arrows-rotate me-2"></i> Actualizar Actividad
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let activeInputId = null;

        // 1. Manejar el enfoque de las áreas
        document.querySelectorAll('.paste-area').forEach(area => {
            area.addEventListener('click', function() { this.focus(); });
            
            area.addEventListener('focus', function() {
                activeInputId = this.dataset.input;
                this.classList.add('active-paste');
            });

            area.addEventListener('blur', function() {
                this.classList.remove('active-paste');
            });
        });

        // 2. Previsualización dinámica
        function updatePreview(file, inputId) {
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewId = inputId === 'vbFirma' ? 'previewFirma' : 'previewFoto';
                    const placeholderId = inputId === 'vbFirma' ? 'firmaPlaceholder' : 'evidenciaPlaceholder';
                    
                    const img = document.getElementById(previewId);
                    const ph = document.getElementById(placeholderId);
                    
                    img.src = e.target.result;
                    img.style.display = 'block';
                    ph.style.display = 'none';
                }
                reader.readAsDataURL(file);
            }
        }

        // 3. Pegado Global
        document.addEventListener('paste', function (e) {
            if (!activeInputId) return;

            const items = (e.clipboardData || e.originalEvent.clipboardData).items;
            for (let item of items) {
                if (item.kind === 'file' && item.type.startsWith('image/')) {
                    const blob = item.getAsFile();
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(new File([blob], "edit_pasted.png", { type: blob.type }));
                    
                    const targetInput = document.getElementById(activeInputId);
                    targetInput.files = dataTransfer.files;
                    
                    updatePreview(blob, activeInputId);
                }
            }
        });

        // 4. Sincronizar con selección manual
        document.querySelectorAll('input[type="file"]').forEach(input => {
            input.addEventListener('change', function() {
                updatePreview(this.files[0], this.id);
            });
        });
    });
</script>
@endsection