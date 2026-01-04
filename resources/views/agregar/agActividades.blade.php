@extends('layouts.plantilla')

@section('title', 'Agregar Actividad')

@section('titular')
<x-navbar-3 :id_mes="$id_mes" :empresa="$empresa">
    Nueva Actividad
</x-navbar-3>
@endsection

@section('contenido')
<style>
            /* Ajuste para que el buscador de Select2 sea oscuro */
        .select2-container--default .select2-selection--single {
            background-color: #0f1012 !important;
            border: 1px solid #2d3035 !important;
            color: #e0e0e0 !important;
            height: 38px !important;
        }
        .select2-dropdown {
            background-color: #1a1c20 !important;
            border: 1px solid #2d3035 !important;
            color: #e0e0e0 !important;
        }
        .select2-results__option--highlighted {
            background-color: #6dacd6 !important;
            color: #1a1c20 !important;
        }
        .card-dark { background-color: #1a1c20; border: 1px solid #2d3035; border-radius: 16px; color: #e0e0e0; }
        .text-label { color: #a0a0a0; font-size: 0.85rem; font-weight: 500; margin-bottom: 0.4rem; display: block; }
        .input-dark { 
            background-color: #0f1012; border: 1px solid #2d3035; color: #e0e0e0; 
            border-radius: 8px; padding: 0.6rem; font-size: 0.9rem;
        }
        .input-dark:focus { border-color: #6dacd6; box-shadow: none; }
        
        .section-divider { border-top: 1px solid #2d3035; margin: 1.5rem 0; position: relative; }
        .section-title { 
            position: absolute; top: -12px; left: 20px; background: #1a1c20; 
            padding: 0 10px; font-size: 0.75rem; color: #6dacd6; text-transform: uppercase; letter-spacing: 1px;
        }

        .foto-upload-zone {
            border: 2px dashed #2d3035; border-radius: 12px; padding: 1.5rem;
            background-color: #0f1012; transition: all 0.3s; cursor: pointer; text-align: center;
        }
        .foto-upload-zone:hover { border-color: #6dacd6; background-color: #141619; }
        .preview-img { max-height: 150px; border-radius: 8px; display: none; margin-top: 10px; }
        
        input[type="time"] { color-scheme: dark; }
        
        /* Contenedor principal de sugerencias (Efecto Cristal) */
        .ui-autocomplete {
            width: 70px;
            background: rgba(33, 34, 38, 0.276) !important; /* Color oscuro con 60% de opacidad */
            backdrop-filter: blur(12px) !important; /* El efecto de desenfoque tipo cristal */
            -webkit-backdrop-filter: blur(12px) !important; /* Compatibilidad con Safari */
            border: 1px solid rgba(255, 255, 255, 0.1) !important; /* Borde sutil brillante */
            border-radius: 12px !important;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.5) !important;
            padding: 5px 0 !important;
            z-index: 9999 !important;
            max-height: 250px;
            overflow-y: auto;
        }

    /* Cada opción individual */
    .ui-menu-item {
        padding: 2px 5px !important;
    }

    .ui-menu-item-wrapper {
        color: #e0e0e0 !important;
        padding: 10px 15px !important;
        border-radius: 8px !important;
        border: none !important;
        transition: all 0.2s ease;
    }

    /* Opción seleccionada o con el mouse encima */
    .ui-menu-item-wrapper.ui-state-active {
        background-color: rgba(109, 172, 214, 0.2) !important; /* Azul San Marcos semi-transparente */
        color: #ffffff !important;
        border: 1px solid rgba(109, 172, 214, 0.4) !important;
        font-weight: 500;
    }
    
    .ui-helper-hidden-accessible {
    display: none !important;
    }

        /* Feedback visual cuando la zona recibe el foco para pegar */
    .foto-upload-zone:focus {
        outline: none;
        border-color: #6dacd6;
        background-color: rgba(109, 172, 214, 0.05);
    }

    
</style>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            <form action="/addActividades" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id_servicio" value="{{ $id_servicio }}">

                <div class="card-dark shadow-lg">
                    <div class="card-body p-4">
                        <h4 class="fw-light mb-4">Registrar Actividad</h4>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="text-label">Nombre de la Actividad / Plaga</label>
                                <input type="text" name="nombre" class="form-control input-dark" placeholder="Ej. Control de Roedores" required value="{{ old('nombre') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="text-label">Hora</label>
                                <input type="time" name="hora" class="form-control input-dark" required value="{{ old('hora') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="text-label">Área</label>
                                <input type="text" name="area" class="form-control input-dark" placeholder="Ej. Almacén" value="{{ old('area') }}">
                            </div>
                        </div>

                     <div class="section-divider"><span class="section-title">Productos Utilizados</span></div>
                        
                        <div class="row g-3">
                            @foreach(['pr1', 'pr2', 'pr3', 'pr4'] as $pr)
                            <div class="col-md-3">
                                <label class="text-label">{{ strtoupper($pr) }}</label>
                                {{-- Input visible para escribir (Estilo Google) --}}
                                <input type="text" 
                                    data-url="{{ route('productos.buscar') }}"
                                    class="form-control input-dark buscar-producto" 
                                    placeholder="Escribe el producto..."
                                    value="{{ old($pr . '_nombre') }}">
                                
                                {{-- Input oculto que envía el ID real a la base de datos --}}
                                <input type="hidden" name="{{ $pr }}" value="{{ old($pr) }}">
                            </div>
                            @endforeach
                        </div>

                        <div class="section-divider"><span class="section-title">Personal Asignado</span></div>
                        <div class="row g-3">
                            @foreach(['tecnico1', 'tecnico2', 'tecnico3'] as $tec)
                            <div class="col-md-4">
                                <label class="text-label">Técnico {{ substr($tec, -1) }}</label>
                                {{-- Input visible --}}
                                <input type="text" 
                                    data-url="{{ route('tecnicos.buscar') }}"
                                    class="form-control input-dark buscar-tecnico" 
                                    placeholder="Escribe el nombre..."
                                    value="{{ old($tec . '_nombre') }}">
                                
                                {{-- Input oculto para el id_tec --}}
                                <input type="hidden" name="{{ $tec }}" value="{{ old($tec) }}">
                            </div>
                            @endforeach
                        </div>

                        <div class="section-divider"><span class="section-title">Evidencia y Detalles</span></div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="text-label">Observaciones</label>
                                <textarea name="observacion" class="form-control input-dark" rows="5" placeholder="Detalles encontrados durante la inspección...">{{ old('observacion') }}</textarea>
                            </div>
                            <div class="col-md-6 text-center">
                                <label class="text-label">Foto de Evidencia</label>
                                <div class="foto-upload-zone" onclick="document.getElementById('foto').click()">
                                    <div id="uploadPlaceholder">
                                        <i class="fa-solid fa-camera fa-2x mb-2 opacity-50"></i>
                                        <p class="small mb-0">Haz clic para subir foto</p>
                                    </div>
                                    <img id="preview" class="preview-img mx-auto">
                                </div>
                                <input type="file" id="foto" name="foto" class="d-none" accept="image/*" onchange="previewImage(event)">
                            </div>
                        </div>

                        <div class="d-flex gap-2 mt-5">
                            <a href="/actividades/{{ $id_servicio }}" class="btn w-50" style="background-color: #2c1a1a; color: #d66d6d; border: 1px solid #4a2424;">
                                Cancelar
                            </a>
                            <button type="submit" class="btn w-50" style="background-color: #1c2a35; color: #6dacd6; border: 1px solid #243b4a;">
                                <i class="fa-solid fa-check me-2"></i> Guardar Actividad
                            </button>
                        </div>

                    </div>
                </div>
            </form>
            
        </div>
    </div>
</div>

{{-- Añade esto antes del script de jquery-ui --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

<script>
    // 1. Función de previsualización (Ya la tienes, se mantiene igual)
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function() {
                const preview = document.getElementById('preview');
                const placeholder = document.getElementById('uploadPlaceholder');
                preview.src = reader.result;
                preview.style.display = 'block';
                placeholder.style.display = 'none';
            }
            reader.readAsDataURL(file);
        }
    }

    // 2. NUEVA LÓGICA: Escuchar el evento de "pegar" (Ctrl+V)
    window.addEventListener('paste', function(e) {
        const items = (e.clipboardData || e.originalEvent.clipboardData).items;
        
        for (let index in items) {
            const item = items[index];
            
            // Verificamos si lo que se pega es una imagen
            if (item.kind === 'file' && item.type.indexOf('image') !== -1) {
                const blob = item.getAsFile();
                
                // Creamos el contenedor de archivos para el input real
                const dataTransfer = new DataTransfer();
                const file = new File([blob], "evidencia_pegada.png", { type: blob.type });
                dataTransfer.items.add(file);
                
                // Inyectamos el archivo en tu input con id="foto"
                const inputFoto = document.getElementById('foto');
                inputFoto.files = dataTransfer.files;
                
                // Disparamos la previsualización simulando el evento
                const fakeEvent = { target: { files: [file] } };
                previewImage(fakeEvent);
                
                console.log('Evidencia pegada desde el portapapeles');
            }
        }
    });
    $(document).ready(function() {

    // 1. FUNCIÓN DE VALIDACIÓN Y ALERT (Para reutilizar en ambos)
    function validarSeleccion(event, ui) {
        if (!ui.item) {
            // Limpiamos los valores
            $(this).val(""); 
            $(this).next('input[type="hidden"]').val("");

            // Efecto visual: Borde rojo temporal
            $(this).css('border-color', '#d66d6d');

            // Alert (SweetAlert2 o tradicional)
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Selección inválida',
                    text: 'Debes elegir una opción de la lista desplegable.',
                    confirmButtonColor: '#6dacd6',
                    background: '#1a1c20',
                    color: '#e0e0e0'
                });
            } else {
                alert("¡Atención! Debes seleccionar un elemento de la lista desplegable.");
            }
        } else {
            // Si es válido, restauramos el color del borde
            $(this).css('border-color', '#2d3035');
        }
    }

    // 2. CONFIGURACIÓN BASE (AJAX y lógica común)
    const baseConfig = {
        minLength: 2,
        source: function(request, response) {
            $.ajax({
                url: $(this.element).data('url'),
                dataType: "json",
                data: { q: request.term },
                success: function(data) {
                    response($.map(data, function(item) {
                        return { 
                            label: item.text, 
                            value: item.text, 
                            id: item.id,
                            concentracion: item.concentracion // Solo lo usará productos
                        };
                    }));
                }
            });
        },
        select: function(event, ui) {
            $(this).next('input[type="hidden"]').val(ui.item.id);
        },
        change: validarSeleccion
    };

    // 3. INICIALIZAR TÉCNICOS (Diseño simple)
    $(".buscar-tecnico").autocomplete(baseConfig);

    // 4. INICIALIZAR PRODUCTOS (Con diseño especial de concentración)
    $(".buscar-producto").each(function() {
        $(this).autocomplete(baseConfig)
        .autocomplete("instance")._renderItem = function(ul, item) {
            return $("<li>")
                .append(`<div class="d-flex justify-content-between align-items-center" style="width: 100%;">
                    <span>${item.label}</span>
                    <small style="color: #6dacd6; font-weight: bold;">
                        <i class="fa-solid fa-percent me-1"></i>${item.concentracion ?? '0'}
                    </small>
                </div>`)
                .appendTo(ul);
        };
    });
});

</script>
@endsection