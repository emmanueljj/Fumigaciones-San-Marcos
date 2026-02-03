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

    /* Estilo para Zonas de Carga (Evidencia y Firma) */
    .upload-zone-custom {
        border: 2px dashed #2d3035; border-radius: 16px; padding: 1.5rem;
        background-color: #0f1012; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer; text-align: center; position: relative;
    }
    .upload-zone-custom:hover { border-color: #6dacd6; background-color: #141619; transform: translateY(-2px); }
    .preview-render { max-height: 150px; border-radius: 12px; display: none; margin: 10px auto 0; box-shadow: 0 10px 20px rgba(0,0,0,0.4); }
    
    /* Variación específica para firma (más pequeña) */
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
                        <div class="d-flex align-items-center mb-4">
                            <div class="icon-shape me-3" style="width: 40px; height: 40px; background: rgba(109, 172, 214, 0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #6dacd6;">
                                <i class="fa-solid fa-list-check"></i>
                            </div>
                            <h4 class="fw-light m-0">Registrar Actividad</h4>
                        </div>

                        <div class="row g-4 mb-4">
                            <div class="col-md-7">
                                <label class="text-label">Nombre de la Actividad / Plaga</label>
                                <input type="text" name="nombre" class="form-control input-dark" placeholder="Ej. Revisión de cebaderos" required value="{{ old('nombre') }}">
                            </div>
                            <div class="col-md-5">
                                <label class="text-label">Área intervenida</label>
                                <input type="text" name="area" class="form-control input-dark" placeholder="Ej. Cocina / Almacén" required value="{{ old('area') }}">
                            </div>
                        </div>

                        <div class="row g-4 mb-4">
                            <div class="col-md-4">
                                <label class="text-label">Hora</label>
                                <input type="time" name="hora" class="form-control input-dark" required value="{{ old('hora', date('H:i')) }}">
                            </div>
                            <div class="col-md-8">
                                <label class="text-label">Visto Bueno (Nombre)</label>
                                <input type="text" name="vbNombre" class="form-control input-dark" placeholder="Nombre del responsable" required>
                            </div>
                        </div>

                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label class="text-label">Foto de Evidencia</label>
                                <div class="upload-zone-custom" onclick="document.getElementById('foto').click()">
                                    <div id="evidenciaPlaceholder">
                                        <i class="fa-solid fa-camera fa-lg mb-2" style="color: #6dacd6;"></i>
                                        <p class="small mb-0 text-white">Subir Foto</p>
                                    </div>
                                    <img id="previewFoto" class="preview-render">
                                </div>
                                <input type="file" id="foto" name="foto" class="d-none" accept="image/*" onchange="processPreview(this, 'previewFoto', 'evidenciaPlaceholder')">
                            </div>

                            <div class="col-md-6">
                                <label class="text-label">Firma de Conformidad</label>
                                <div class="upload-zone-custom" onclick="document.getElementById('vbFirma').click()">
                                    <div id="firmaPlaceholder">
                                        <i class="fa-solid fa-signature fa-lg mb-2" style="color: #6dacd6;"></i>
                                        <p class="small mb-0 text-white">Pegar Firma (Ctrl+V)</p>
                                    </div>
                                    <img id="previewFirma" class="preview-render firma-render">
                                </div>
                                <input type="file" id="vbFirma" name="vbFirma" class="d-none" accept="image/*" onchange="processPreview(this, 'previewFirma', 'firmaPlaceholder')">
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
    // Función genérica para previsualizar
    function processPreview(input, imgId, placeholderId) {
        const file = input.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById(imgId).src = e.target.result;
                document.getElementById(imgId).style.display = 'block';
                document.getElementById(placeholderId).style.display = 'none';
            }
            reader.readAsDataURL(file);
        }
    }

    // Manejo de pegado inteligente
    window.addEventListener('paste', function(e) {
        const items = (e.clipboardData || e.originalEvent.clipboardData).items;
        for (let item of items) {
            if (item.kind === 'file' && item.type.startsWith('image/')) {
                const blob = item.getAsFile();
                const dataTransfer = new DataTransfer();
                const file = new File([blob], "upload.png", { type: blob.type });
                dataTransfer.items.add(file);
                
                // Si la firma está vacía, priorizamos la firma al pegar, si no, va a la foto.
                const firmaInput = document.getElementById('vbFirma');
                const fotoInput = document.getElementById('foto');
                
                if (document.getElementById('previewFirma').style.display !== 'block') {
                    firmaInput.files = dataTransfer.files;
                    processPreview(firmaInput, 'previewFirma', 'firmaPlaceholder');
                } else {
                    fotoInput.files = dataTransfer.files;
                    processPreview(fotoInput, 'previewFoto', 'evidenciaPlaceholder');
                }
            }
        }
    });
</script>
@endsection