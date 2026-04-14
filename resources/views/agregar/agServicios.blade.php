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

    /* Estilos para carga múltiple interactiva */
    .multi-upload-area {
        background: linear-gradient(145deg, #16181d, #1a1c20);
        border: 2px dashed #2d3035;
        border-radius: 16px;
        padding: 1.5rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        min-height: 120px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        outline: none; /* Crucial para Ctrl+V */
    }
    .multi-upload-area:focus, .multi-upload-area:hover {
        border-color: #6dacd6;
        background-color: #141619;
    }
    .upload-prompt { color: #6dacd6; pointer-events: none; }
    .preview-grid {
        display: grid; grid-template-columns: repeat(auto-fill, minmax(70px, 1fr));
        gap: 8px; width: 100%; margin-top: 10px;
    }
    .preview-item {
        position: relative; padding-top: 100%; border-radius: 8px;
        overflow: hidden; background: #1a1c20; border: 1px solid #2d3035;
    }
    .preview-item img {
        position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;
    }
    .btn-remove-img {
        position: absolute; top: 3px; right: 3px; background: rgba(220, 53, 69, 0.9);
        color: white; border: none; border-radius: 4px; width: 22px; height: 22px;
        font-size: 12px; display: flex; align-items: center; justify-content: center;
        cursor: pointer; z-index: 10; transition: 0.2s;
    }
    .btn-remove-img:hover { background: #dc3545; transform: scale(1.1); }

    /* Listas dinámicas */
    .selection-list { background: #0f1012; border: 1px solid #2d3035; border-radius: 16px; min-height: 100px; padding: 12px; display: flex; flex-wrap: wrap; gap: 8px; align-content: flex-start; }
    .badge-item { background: rgba(109, 172, 214, 0.1); color: #6dacd6; border: 1px solid rgba(109, 172, 214, 0.2); padding: 6px 14px; border-radius: 10px; display: inline-flex; align-items: center; font-size: 0.8rem; font-weight: 600; }
    .remove-item { cursor: pointer; margin-left: 10px; color: rgba(214, 109, 109, 0.6); transition: 0.2s; }
    .remove-item:hover { color: #d66d6d; }
    input[type="date"] { color-scheme: dark; }
    .ui-autocomplete { background: #1a1c20 !important; border: 1px solid #2d3035 !important; border-radius: 12px !important; color: #fff; z-index: 9999 !important; box-shadow: 0 15px 30px rgba(0,0,0,0.5) !important; }
    .ui-helper-hidden-accessible { display: none; }
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
                        <label class="text-label">Control Perimetral (Páginas como imágenes)</label>
                        
                        <div class="multi-upload-area" id="zona_perimetral" tabindex="0">
                            <div class="upload-prompt" id="prompt_perimetral">
                                <i class="fa-solid fa-file-shield fa-2x"></i><br>
                                <span style="font-size: 0.75rem; color: #a0a0a0; display: block; margin-top: 5px;">
                                    Clic aquí o presiona <b>Ctrl+V</b> para pegar imágenes
                                </span>
                            </div>
                            
                            <div class="preview-grid" id="grid_perimetral"></div>
                        </div>

                        <input type="file" id="input_perimetral" name="controlPerimetral[]" class="d-none" accept="image/*" multiple>
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
                            <div id="lista-productos" class="selection-list"></div>
                        </div>

                        <div class="col-md-6">
                            <label class="text-label">Asignar Técnicos</label>
                            <input type="text" id="buscar-tec" class="form-control input-dark mb-3" placeholder="Buscar personal..." data-url="{{ route('tecnicos.buscar') }}">
                            <div id="lista-tecnicos" class="selection-list"></div>
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
    // ---------------------------------------------------------
    // LÓGICA DE AUTOCOMPLETADO (Se mantiene igual)
    // ---------------------------------------------------------
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

    // ---------------------------------------------------------
    // LÓGICA DEL MULTI-UPLOADER (Ctrl+V y Clic)
    // ---------------------------------------------------------
    document.addEventListener('DOMContentLoaded', function () {
        
        initMultiUploader('zona_perimetral', 'input_perimetral', 'grid_perimetral', 'prompt_perimetral');

        function initMultiUploader(zonaId, inputId, gridId, promptId) {
            const zona = document.getElementById(zonaId);
            const input = document.getElementById(inputId);
            const grid = document.getElementById(gridId);
            const prompt = document.getElementById(promptId);
            
            if(!zona) return; 

            const dataTransfer = new DataTransfer();

            // Al hacer clic, abre buscador de archivos
            zona.addEventListener('click', (e) => {
                if (!e.target.closest('.btn-remove-img')) {
                    input.click();
                }
            });

            // Al seleccionar archivos tradicionales
            input.addEventListener('change', () => {
                Array.from(input.files).forEach(file => {
                    if (file.type.startsWith('image/')) dataTransfer.items.add(file);
                });
                actualizarUI();
            });

            // Al pegar imágenes (Ctrl+V) sobre la zona enfocada
            zona.addEventListener('paste', (e) => {
                e.preventDefault(); 
                const items = (e.clipboardData || window.clipboardData).items;
                
                for (let item of items) {
                    if (item.type.startsWith('image/')) {
                        const file = item.getAsFile();
                        const newFile = new File([file], `perimetral_${Date.now()}.png`, { type: file.type });
                        dataTransfer.items.add(newFile);
                    }
                }
                actualizarUI();
            });

            // Eliminar imagen específica
            grid.addEventListener('click', (e) => {
                const btn = e.target.closest('.btn-remove-img');
                if (btn) {
                    dataTransfer.items.remove(parseInt(btn.dataset.index));
                    actualizarUI();
                }
            });

            // Refrescar UI y sincronizar input
            function actualizarUI() {
                grid.innerHTML = '';
                input.files = dataTransfer.files;

                if (dataTransfer.files.length > 0) {
                    prompt.style.display = 'none';
                    zona.style.padding = '10px';
                } else {
                    prompt.style.display = 'block';
                    zona.style.padding = '1.5rem';
                }

                Array.from(dataTransfer.files).forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const div = document.createElement('div');
                        div.className = 'preview-item';
                        div.innerHTML = `
                            <img src="${e.target.result}" title="${file.name}">
                            <button type="button" class="btn-remove-img" data-index="${index}">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        `;
                        grid.appendChild(div);
                    };
                    reader.readAsDataURL(file);
                });
            }
        }
    });
</script>
@endsection