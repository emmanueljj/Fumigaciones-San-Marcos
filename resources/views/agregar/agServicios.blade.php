@extends('layouts.plantilla')

@section('tittle', 'Agregar Servicio')

@section('titular')
<x-navbar :id_mes="$id_mes" :empresa="$empresa">
    Agregar Servicio
</x-navbar>
@endSection

@section('contenido')
<style>
    /* Estilos Dark Específicos */
    .card-dark {
        background-color: #1a1c20;
        border: 1px solid #2d3035;
        border-radius: 16px;
        color: #e0e0e0;
    }
    .text-label { color: #a0a0a0; font-size: 0.9rem; margin-bottom: 0.5rem; display: block; }
    .input-dark {
        background-color: #0f1012;
        border: 1px solid #2d3035;
        color: #e0e0e0;
        border-radius: 8px;
        padding: 0.7rem;
    }
    .input-dark:focus { background-color: #141619; border-color: #4a4d55; color: #fff; outline: none; }
    
    /* Zona de firma oscura */
    .firma-preview-dark {
        border: 2px dashed #3f444d;
        border-radius: 12px;
        padding: 2rem;
        background-color: #141619; /* Fondo muy oscuro para contraste */
        min-height: 150px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        transition: border-color 0.3s;
    }
    .firma-preview-dark:hover { border-color: #6dacd6; }
    
    .firma-preview-dark img {
        max-width: 100%;
        max-height: 200px;
        filter: invert(1); /* Truco: si la firma es negra y el fondo oscuro, invertimos para que sea blanca (opcional) */
        border-radius: 8px;
    }

    /* Input date dark mode */
    input[type="date"] { color-scheme: dark; }
</style>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            
            <div class="card-dark mb-4 p-3 d-flex flex-row align-items-center justify-content-between">
                <div>
                    <h5 class="mb-1 text-light">{{ $empresa->nombre }}</h5>
                    <p class="mb-0 small">
                        <i class="fa-solid fa-calendar-days me-1"></i> 
                        {{ $mes->fecha_I }} / {{ $mes->fecha_f }}
                    </p>
                </div>
                <i class="fa-solid fa-building fa-2x opacity-25"></i>
            </div>

            <div class="card-dark shadow-lg">
                <div class="card-body p-4">
                    <h4 class="card-title mb-4 text-light fw-light">
                        Nuevo Servicio
                    </h4>

                    <form action="/addServicio/{{ $id_mes }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="fecha" class="text-label">
                                Fecha del Servicio <span class="text-danger">*</span>
                            </label>
                            <input type="date" 
                                   class="form-control input-dark @error('fecha') is-invalid @enderror" 
                                   id="fecha" 
                                   name="fecha" 
                                   value="{{ old('fecha', date('Y-m-d')) }}"
                                   min="{{ $mes->fecha_I }}"
                                   max="{{ $mes->fecha_f }}"
                                   required>
                        </input>
                            @error('fecha') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="vb_nombre" class="text-label">
                                Nombre (Visto Bueno)
                            </label>
                            <input type="text" 
                                   class="form-control input-dark @error('vb_nombre') is-invalid @enderror" 
                                   id="vb_nombre" 
                                   name="vb_nombre" 
                                   value="{{ old('vb_nombre') }}"
                                   placeholder="Nombre de quien autoriza"
                                   maxlength="255">
                            @error('vb_nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="vb_firma" class="text-label">
                                Firma Digital (Imagen)
                            </label>
                            
                            <div class="text-center mb-3">
                                <div class="firma-preview-dark" id="firmaPreview">
                                    <i class="fa-solid fa-signature text-secondary opacity-50" style="font-size: 2.5rem;"></i>
                                    <p class="text-secondary opacity-50 mt-2 small">Vista previa de firma</p>
                                </div>
                            </div>

                            <input type="file" 
                                   class="form-control input-dark @error('vb_firma') is-invalid @enderror" 
                                   id="vb_firma" 
                                   name="vb_firma"
                                   accept="image/*"
                                   onchange="previewFirma(event)">
                            @error('vb_firma') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="d-flex gap-2 pt-2">
                            <a href="/servicios/{{ $id_mes }}" class="btn w-50" style="background-color: #2c1a1a; color: #d66d6d; border: 1px solid #4a2424;">
                                Cancelar
                            </a>
                            <button type="submit" class="btn w-50" style="background-color: #1c2a35; color: #6dacd6; border: 1px solid #243b4a;">
                                <i class="fa-solid fa-check me-2"></i> Guardar
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            @if(session('errorMensaje'))
                <div class="alert alert-danger bg-opacity-10 border-danger text-danger mt-3" role="alert">
                    <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ session('errorMensaje') }}
                </div>
            @endif

        </div>
    </div>
</div>

<script>
    function previewFirma(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('firmaPreview');
        
        if (file) {
            if (file.size > 2 * 1024 * 1024) {
                alert('La imagen es muy grande. Máximo 2MB permitido.');
                event.target.value = '';
                return;
            }
            if (!file.type.startsWith('image/')) {
                alert('Por favor selecciona una imagen válida.');
                event.target.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                // Quitamos el icono y ponemos la imagen
                preview.innerHTML = `<img src="${e.target.result}" alt="Preview" style="max-height: 120px;">`;
            };
            reader.readAsDataURL(file);
        } else {
            preview.innerHTML = `
                <i class="fa-solid fa-signature text-secondary opacity-50" style="font-size: 2.5rem;"></i>
                <p class="text-secondary opacity-50 mt-2 small">Vista previa de firma</p>
            `;
        }
    }

    // JS Original de fechas
    document.addEventListener('DOMContentLoaded', function() {
        const fechaInput = document.getElementById('fecha');
        if(fechaInput){
            const min = fechaInput.getAttribute('min');
            const max = fechaInput.getAttribute('max');
            fechaInput.addEventListener('change', function() {
                const fecha = this.value;
                if (fecha < min || fecha > max) {
                    alert('La fecha debe estar dentro del periodo: ' + min + ' a ' + max);
                    this.value = min;
                }
            });
        }
    });
</script>
@endSection