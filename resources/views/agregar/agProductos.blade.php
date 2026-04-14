@extends('layouts.plantilla')

@section('title', 'Agregar Producto')
    
@section('titular')
<x-navbar-3>
    Agregar productos
</x-navbar-3>
@endsection

@section('contenido')
<style>
    .form-card-minimal {
        background-color: #1a1c20;
        border: 1px solid #2d3035;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        color: #fff;
    }
    .form-label-dark {
        color: #a0a0a0;
        font-size: 0.85rem;
        font-weight: 500;
        margin-bottom: 0.4rem;
        display: block;
    }
    .input-dark {
        background-color: #0f1012;
        border: 1px solid #2d3035;
        color: #e0e0e0;
        border-radius: 8px;
        padding: 0.6rem 1rem;
        transition: all 0.3s ease;
    }
    .input-dark:focus {
        background-color: #141619;
        border-color: #6dacd6;
        box-shadow: none;
        color: #fff;
        outline: none;
    }
    
    /* Zona de carga de Ficha Técnica */
    .file-upload-wrapper {
        border: 2px dashed #2d3035;
        border-radius: 12px;
        padding: 1.5rem;
        background-color: #0f1012;
        text-align: center;
        cursor: pointer;
        transition: 0.3s;
    }
    .file-upload-wrapper:hover {
        border-color: #6dacd6;
        background-color: #141619;
    }
    .file-upload-wrapper i { color: #6dacd6; margin-bottom: 10px; }
    
    .btn-save-minimal {
        background-color: #1c2a35;
        color: #6dacd6;
        border: 1px solid #243b4a;
        width: 100%;
        padding: 0.7rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.2s;
    }
    .btn-save-minimal:hover {
        background-color: #243b4a;
        color: #fff;
    }
    .status-text { font-size: 0.75rem; color: #6dacd6; display: none; margin-top: 8px; }

    /* Zona principal interactiva */
.multi-upload-area {
    border: 2px dashed #2d3035;
    border-radius: 12px;
    padding: 1.5rem;
    background-color: #0f1012;
    text-align: center;
    cursor: pointer;
    transition: 0.3s;
    min-height: 140px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    outline: none; /* Para el focus al pegar */
}
.multi-upload-area:focus, .multi-upload-area:hover {
    border-color: #6dacd6;
    background-color: #141619;
}

/* Texto de instrucciones */
.upload-prompt { color: #6dacd6; pointer-events: none; }
.upload-prompt i { margin-bottom: 8px; }

/* Rejilla de miniaturas optimizada */
.preview-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(70px, 1fr));
    gap: 8px;
    width: 100%;
    margin-top: 10px;
}

/* Cada miniatura */
.preview-item {
    position: relative;
    padding-top: 100%; /* Fuerza proporción cuadrada 1:1 */
    border-radius: 8px;
    overflow: hidden;
    background: #1a1c20;
    border: 1px solid #2d3035;
}
.preview-item img {
    position: absolute;
    top: 0; left: 0; width: 100%; height: 100%;
    object-fit: cover;
}

/* Botón de eliminar (X) */
.btn-remove-img {
    position: absolute;
    top: 3px; right: 3px;
    background: rgba(220, 53, 69, 0.9);
    color: white;
    border: none;
    border-radius: 4px;
    width: 22px; height: 22px;
    font-size: 12px;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer;
    z-index: 10;
    transition: 0.2s;
}
.btn-remove-img:hover { background: #dc3545; transform: scale(1.1); }
</style>

<div class="container py-4">
    <div class="form-card-minimal p-4 mx-auto" style="max-width: 450px;">
        
        <div class="text-center mb-4">
            <h5 class="mt-2 text-light fw-light">Registro de Químicos</h5>
            <p class="small text-muted">Ingresa los datos técnicos del producto</p>
        </div>

        <form action="/addProductos" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-3">
                <label for="nombre" class="form-label-dark">Nombre del Producto</label>
                <input type="text" class="form-control input-dark w-100" id="nombre" name="nombre" 
                       placeholder="Ej. Cipermetrina 200">
            </div>

            <div class="mb-3">
                <label for="concentracion" class="form-label-dark">Concentración</label>
                <div class="input-group">
                    <span class="input-group-text bg-dark border-secondary text-muted" style="border-color: #2d3035;">
                        <i class="fa-solid fa-droplet fa-sm"></i>
                    </span>
                    <input type="text" class="form-control input-dark" id="concentracion" name="concentracion" 
                           placeholder="Ej. 20% C.E.">
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label-dark">Ficha Técnica (Páginas como imágenes)</label>
                
                <div class="multi-upload-area" id="zona_ficha" tabindex="0">
                    <div class="upload-prompt" id="prompt_ficha">
                        <i class="fa-solid fa-flask fa-2x"></i><br>
                        <span style="font-size: 0.8rem; color: #a0a0a0;">Clic para buscar o <b>Clic aquí + Ctrl+V</b> para pegar</span>
                    </div>
                    
                    <div class="preview-grid" id="grid_ficha"></div>
                </div>

                <input type="file" id="input_ficha" name="fichaTecnica[]" class="d-none" accept="image/*" multiple>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-save-minimal">
                    <i class="fa-solid fa-flask-vial me-2"></i> Guardar en Inventario
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function updateFileName(input) {
        const fileName = input.files[0] ? input.files[0].name : "Haz clic para subir archivo";
        document.getElementById('fileName').textContent = fileName;
        if(input.files[0]) {
            document.getElementById('fileStatus').style.display = 'block';
        }
    }
    document.addEventListener('DOMContentLoaded', function () {
    
    // Llamamos a la función constructora para la zona de la ficha técnica
    initMultiUploader('zona_ficha', 'input_ficha', 'grid_ficha', 'prompt_ficha');

    function initMultiUploader(zonaId, inputId, gridId, promptId) {
        const zona = document.getElementById(zonaId);
        const input = document.getElementById(inputId);
        const grid = document.getElementById(gridId);
        const prompt = document.getElementById(promptId);
        
        if(!zona) return; // Si no estamos en la vista de productos, se detiene aquí

        const dataTransfer = new DataTransfer();

        // Al hacer clic, abrimos el buscador de archivos
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

        // El evento PASTE solo se dispara si 'zona' tiene el foco (se le dio clic)
        zona.addEventListener('paste', (e) => {
            e.preventDefault(); // Evitamos que el navegador haga cosas raras
            const items = (e.clipboardData || window.clipboardData).items;
            
            for (let item of items) {
                if (item.type.startsWith('image/')) {
                    const file = item.getAsFile();
                    // Renombramos la imagen para evitar conflictos en Laravel
                    const newFile = new File([file], `ficha_${Date.now()}.png`, { type: file.type });
                    dataTransfer.items.add(newFile);
                }
            }
            actualizarUI();
        });

        // Borrar imagen individual
        grid.addEventListener('click', (e) => {
            const btn = e.target.closest('.btn-remove-img');
            if (btn) {
                dataTransfer.items.remove(parseInt(btn.dataset.index));
                actualizarUI();
            }
        });

        function actualizarUI() {
            grid.innerHTML = '';
            input.files = dataTransfer.files; // Sincroniza el input oculto

            if (dataTransfer.files.length > 0) {
                prompt.style.display = 'none';
                zona.style.minHeight = 'auto';
                zona.style.padding = '10px';
            } else {
                prompt.style.display = 'block';
                zona.style.minHeight = '140px';
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