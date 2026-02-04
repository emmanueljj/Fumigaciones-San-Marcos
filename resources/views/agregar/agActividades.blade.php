@extends('layouts.plantilla')

@section('title', 'Agregar Actividad')

@section('titular')
<x-navbar-3 :id_mes="$id_mes" :empresa="$empresa">
    Nueva Actividad
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
    
    /* Efecto visual de selección (Igual a vista empresas) */
    .upload-zone-custom:focus, .upload-zone-custom.active-paste { 
        border-color: #6dacd6; 
        background: rgba(109, 172, 214, 0.05);
        border-style: solid;
        box-shadow: 0 0 0 3px rgba(109, 172, 214, 0.1);
    }

    .preview-render { max-height: 150px; border-radius: 12px; display: none; margin: 10px auto 0; box-shadow: 0 10px 20px rgba(0,0,0,0.4); }
    .firma-render { max-height: 100px; filter: invert(0.9); } 

    input[type="time"] { color-scheme: dark; }

    .btn-save-custom {
        background-color: #1c2a35; color: #6dacd6; border: 1px solid #243b4a; 
        border-radius: 15px; padding: 0.8rem; font-weight: 600; transition: 0.3s;
    }
    .btn-save-custom:hover { background-color: #243b4a; color: #fff; transform: translateY(-2px); }
</style>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <form action="/addActividades" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id_servicio" value="{{ $id_servicio }}">

                <div class="card-dark shadow-lg border-0">
                    <div class="card-body p-4 p-md-5">
                        <h4 class="fw-light mb-4"><i class="fa-solid fa-list-check me-2 text-info"></i>Registrar Actividad</h4>

                        <div class="row g-4 mb-4">
                            <div class="col-md-7">
                                <label class="text-label">Actividad / Plaga</label>
                                <input type="text" name="nombre" class="form-control input-dark" required value="{{ old('nombre') }}">
                            </div>
                            <div class="col-md-5">
                                <label class="text-label">Área</label>
                                <input type="text" name="area" class="form-control input-dark" required value="{{ old('area') }}">
                            </div>
                        </div>

                        <div class="row g-4 mb-4">
                            <div class="col-md-4">
                                <label class="text-label">Hora</label>
                                <input type="time" name="hora" class="form-control input-dark" required value="{{ old('hora', date('H:i')) }}">
                            </div>
                            <div class="col-md-8">
                                <label class="text-label">Visto Bueno (Nombre)</label>
                                <input type="text" name="vbNombre" class="form-control input-dark" required>
                            </div>
                        </div>

                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label class="text-label">Foto de Evidencia</label>
                                <div class="upload-zone-custom paste-area" data-input="foto" tabindex="0">
                                    <div id="evidenciaPlaceholder">
                                        <i class="fa-solid fa-camera fa-lg mb-2" style="color: #6dacd6;"></i>
                                        <p class="small mb-0 text-white">Haz clic y pega</p>
                                    </div>
                                    <img id="previewFoto" class="preview-render">
                                </div>
                                <input type="file" id="foto" name="foto" class="d-none" accept="image/*">
                            </div>

                            <div class="col-md-6">
                                <label class="text-label">Firma de Conformidad</label>
                                <div class="upload-zone-custom paste-area" data-input="vbFirma" tabindex="0">
                                    <div id="firmaPlaceholder">
                                        <i class="fa-solid fa-signature fa-lg mb-2" style="color: #6dacd6;"></i>
                                        <p class="small mb-0 text-white">Haz clic y pega</p>
                                    </div>
                                    <img id="previewFirma" class="preview-render firma-render">
                                </div>
                                <input type="file" id="vbFirma" name="vbFirma" class="d-none" accept="image/*">
                            </div>
                        </div>

                        <div class="d-flex gap-3 mt-5">
                            <a href="/actividades/{{ $id_servicio }}" class="btn btn-link text-decoration-none w-25" style="color: rgba(224,224,224,0.4);">Cancelar</a>
                            <button type="submit" class="btn btn-save-custom flex-grow-1">
                                <i class="fa-solid fa-circle-check me-2"></i> Finalizar Actividad
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

        // 1. Manejar el enfoque de las áreas de pegado
        document.querySelectorAll('.paste-area').forEach(area => {
            // Al hacer clic, activamos esta área y abrimos selector si se desea
            area.addEventListener('click', function() {
                this.focus();
                activeInputId = this.dataset.input;
            });

            // Al ganar foco (por tabulación o clic)
            area.addEventListener('focus', function() {
                activeInputId = this.dataset.input;
                this.classList.add('active-paste');
            });

            area.addEventListener('blur', function() {
                this.classList.remove('active-paste');
            });
        });

        // 2. Función de Previsualización
        function processPreview(file, inputId) {
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

        // 3. Escuchar el evento de pegado global basado en la zona activa
        document.addEventListener('paste', function (e) {
            if (!activeInputId) return; // Solo pega si hay un área seleccionada

            const items = (e.clipboardData || e.originalEvent.clipboardData).items;
            for (let item of items) {
                if (item.kind === 'file' && item.type.startsWith('image/')) {
                    const blob = item.getAsFile();
                    const dataTransfer = new DataTransfer();
                    const file = new File([blob], "pasted_image.png", { type: blob.type });
                    dataTransfer.items.add(file);
                    
                    const targetInput = document.getElementById(activeInputId);
                    targetInput.files = dataTransfer.files;
                    
                    processPreview(blob, activeInputId);
                }
            }
        });

        // 4. Sincronizar también con el selector de archivos normal
        document.querySelectorAll('input[type="file"]').forEach(input => {
            input.addEventListener('change', function() {
                processPreview(this.files[0], this.id);
            });
        });
    });
</script>
@endsection