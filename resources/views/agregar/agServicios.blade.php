@extends('layouts.plantilla')

@section('title', 'Agregar Servicio')

@section('titular')
<x-navbar-3 :id_mes="$id_mes" :empresa="$empresa">
    Agregar Servicio
</x-navbar-3>
@endsection

@section('contenido')
<style>
    .card-dark { background-color: #1a1c20; border: 1px solid #2d3035; border-radius: 20px; color: #e0e0e0; }
    .input-dark { background-color: #0f1012; border: 1px solid #2d3035; color: #fff !important; border-radius: 12px; padding: 0.75rem; transition: 0.3s; }
    .input-dark:focus { border-color: #6dacd6; box-shadow: 0 0 0 4px rgba(109, 172, 214, 0.1); outline: none; color: #6dacd6 !important; }
    .text-label { color: rgba(224, 224, 224, 0.5); font-size: 0.75rem; font-weight: 700; margin-bottom: 0.5rem; display: block; text-transform: uppercase; letter-spacing: 0.5px; }

    /* Componente de Carga Estilo Glass */
    .file-glass-container {
        background: linear-gradient(145deg, #16181d, #1a1c20);
        border: 1px solid #2d3035;
        border-radius: 16px;
        padding: 1.25rem;
        position: relative;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .file-glass-container:hover { border-color: rgba(109, 172, 214, 0.5); transform: translateY(-2px); }
    
    .icon-shape {
        width: 44px; height: 44px; background: #0f1012; border-radius: 12px;
        display: flex; align-items: center; justify-content: center; color: #6dacd6;
    }

    /* Listas dinámicas y Badges */
    .selection-list { background: #0f1012; border: 1px solid #2d3035; border-radius: 16px; min-height: 100px; padding: 12px; display: flex; flex-wrap: wrap; gap: 8px; align-content: flex-start; }
    .badge-item { 
        background: rgba(109, 172, 214, 0.1); color: #6dacd6; border: 1px solid rgba(109, 172, 214, 0.2); 
        padding: 6px 14px; border-radius: 10px; display: inline-flex; align-items: center; font-size: 0.8rem; font-weight: 600;
    }
    .remove-item { cursor: pointer; margin-left: 10px; color: rgba(214, 109, 109, 0.6); transition: 0.2s; }
    .remove-item:hover { color: #d66d6d; }

    .input-file-real { position: absolute; width: 100%; height: 100%; top: 0; left: 0; opacity: 0; cursor: pointer; }
    input[type="date"] { color-scheme: dark; }
    
    .ui-autocomplete { 
        background: #1a1c20 !important; border: 1px solid #2d3035 !important; border-radius: 12px !important; 
        color: #fff; z-index: 9999 !important; box-shadow: 0 15px 30px rgba(0,0,0,0.5) !important;
    }
    .ui-helper.hidden-accesible{
        display: none;
    }
</style>

<div class="container py-4">
    <form action="/addServicio/{{ $id_mes }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-4">
            
            <div class="col-lg-4">
                <div class="card-dark p-4 h-100 shadow-lg border-0">
                    <h5 class="mb-4 fw-light text-white"><i class="fa-solid fa-sliders me-2 text-info"></i>Configuración</h5>
                    
                    <div class="mb-4">
                        <label class="text-label">Fecha del reporte</label>
                        <input type="date" name="fecha" class="form-control input-dark" required 
                               value="{{ date('Y-m-d') }}" min="{{ $mes->fecha_I }}" max="{{ $mes->fecha_f }}">
                    </div>

                    <div class="mb-4">
                        <label class="text-label">Control Perimetral (PDF)</label>
                        <div class="file-glass-container">
                            <div class="d-flex align-items-center gap-3">
                                <div class="icon-shape" id="iconPerimetral">
                                    <i class="fa-solid fa-file-shield fa-lg"></i>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <span class="d-block text-white small" id="namePerimetral" style="text-overflow: ellipsis; white-space: nowrap; overflow: hidden;">Seleccionar archivo</span>
                                    <span style="color: #6dacd6; font-size: 0.65rem; font-weight: 700; text-transform: uppercase;">Subir Reporte</span>
                                </div>
                                <input type="file" name="controlPerimetral" class="input-file-real" 
                                       accept="application/pdf, image/*" onchange="handleFileUpdate(this, 'namePerimetral', 'iconPerimetral')">
                            </div>
                        </div>
                    </div>

                    <div class="mb-0">
                        <label class="text-label">Observaciones generales</label>
                        <textarea name="observacion" class="form-control input-dark" rows="4" placeholder="Escribe detalles relevantes..."></textarea>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card-dark p-4 shadow-lg border-0 h-100 d-flex flex-column">
                    <h5 class="mb-4 fw-light text-white"><i class="fa-solid fa-boxes-stacked me-2 text-info"></i>Recursos Aplicados</h5>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="text-label">Añadir Productos</label>
                            <input type="text" id="buscar-pr" class="form-control input-dark mb-3" placeholder="Buscar por nombre..." data-url="{{ route('productos.buscar') }}">
                            <div id="lista-productos" class="selection-list">
                                </div>
                        </div>

                        <div class="col-md-6">
                            <label class="text-label">Asignar Técnicos</label>
                            <input type="text" id="buscar-tec" class="form-control input-dark mb-3" placeholder="Buscar personal..." data-url="{{ route('tecnicos.buscar') }}">
                            <div id="lista-tecnicos" class="selection-list">
                                </div>
                        </div>
                    </div>

                    <div class="mt-auto pt-5">
                        <div class="d-flex align-items-center justify-content-between">
                            <a href="/servicios/{{ $id_mes }}" class="btn btn-link text-decoration-none p-0" style="color: rgba(224,224,224,0.4); font-size: 0.9rem;">
                                <i class="fa-solid fa-chevron-left me-1"></i> Volver a la lista
                            </a>
                            <button type="submit" class="btn px-5 py-3 shadow-sm" style="background-color: #1c2a35; color: #6dacd6; border: 1px solid #243b4a; border-radius: 15px; font-weight: 600;">
                                <i class="fa-solid fa-paper-plane me-2"></i> Registrar Servicio
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

<script>
    function handleFileUpdate(input, labelId, iconId) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            document.getElementById(labelId).innerText = file.name;
            document.getElementById(labelId).style.color = "#fff";
            document.getElementById(iconId).style.background = "rgba(109, 172, 214, 0.15)";
        }
    }

    function addItem(containerId, inputName, id, text) {
        const container = $(`#${containerId}`);
        if (container.find(`input[value="${id}"]`).length > 0) return;
        const badge = $(`
            <div class="badge-item">
                <input type="hidden" name="${inputName}[]" value="${id}">
                <span>${text}</span>
                <i class="fa-solid fa-xmark remove-item" onclick="this.parentElement.remove()"></i>
            </div>
        `);
        container.append(badge);
    }

    $(document).ready(function() {
        const autocompleteConfig = (containerId, inputName) => ({
            source: function(request, response) {
                $.getJSON($(this.element).data('url'), { q: request.term }, response);
            },
            select: function(event, ui) {
                addItem(containerId, inputName, ui.item.id, ui.item.label);
                $(this).val('');
                return false;
            }
        });

        $("#buscar-pr").autocomplete(autocompleteConfig('lista-productos', 'productos'));
        $("#buscar-tec").autocomplete(autocompleteConfig('lista-tecnicos', 'tecnicos'));
    });
</script>
@endsection