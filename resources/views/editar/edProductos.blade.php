@extends('layouts.plantilla')

@section('title', 'Editar Producto')
    
@section('titular')
<x-navbar-3>
    Editar productos
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

    /* CORRECCIÓN: Color de texto definido para evitar el blanco invisible */
    .input-dark {
        background-color: #0f1012;
        border: 1px solid #2d3035;
        color: #e0e0e0 !important; /* Forzamos color legible */
        border-radius: 8px;
        padding: 0.6rem 1rem;
    }

    /* CORRECCIÓN: Al escribir (focus), el texto ahora es azul claro para máxima visibilidad */
    .input-dark:focus {
        background-color: #141619;
        border-color: #6dacd6;
        box-shadow: none;
        outline: none;
        color: #6dacd6 !important; 
    }

    /* CORRECCIÓN: Estilo para el botón de regresar */
    .btn-back-minimal {
        background-color: transparent;
        color: rgba(224, 224, 224, 0.6);
        border: 1px solid #2d3035;
        border-radius: 8px;
        transition: all 0.3s;
        text-decoration: none;
        font-size: 0.85rem;
    }
    .btn-back-minimal:hover {
        background-color: #2d3035;
        color: #fff;
    }
    
    .btn-save-minimal {
        background-color: #1c2a35;
        color: #6dacd6;
        border: 1px solid #243b4a;
        width: 100%;
        padding: 0.7rem;
        border-radius: 8px;
        font-weight: 600;
        transition: 0.2s;
    }
    .btn-save-minimal:hover {
        background-color: #243b4a;
        color: #fff;
    }

    .text-secondary-custom { color: rgba(224, 224, 224, 0.5); font-size: 0.75rem; }
    .text-accent { color: #6dacd6; font-weight: 600; }

    .file-glass-container {
        background: linear-gradient(145deg, #16181d, #1a1c20);
        border: 1px solid #2d3035;
        border-radius: 16px;
        padding: 1.25rem;
        position: relative;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
    }
    .file-glass-container:hover {
        border-color: rgba(109, 172, 214, 0.5);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4);
    }

    .status-indicator {
        position: absolute;
        top: 12px;
        right: 12px;
        background: rgba(109, 172, 214, 0.1);
        border: 1px solid rgba(109, 172, 214, 0.2);
        color: #6dacd6;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 0.65rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .input-wrapper-hidden {
        display: flex;
        align-items: center;
        gap: 15px;
        cursor: pointer;
    }

    .icon-shape {
        width: 48px;
        height: 48px;
        background: #0f1012;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6dacd6;
        box-shadow: inset 0 0 10px rgba(109, 172, 214, 0.05);
    }

    .input-file-real {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0; left: 0;
        opacity: 0;
        cursor: pointer;
    }

    .file-info-text { flex-grow: 1; }

    .file-name-display {
        display: block;
        color: #e0e0e0;
        font-size: 0.9rem;
        margin-bottom: 2px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 200px;
    }
</style>

<div class="container py-4">
    <div class="form-card-minimal p-4 mx-auto" style="max-width: 450px;">
        
        <div class="text-center mb-4">
            <h5 class="mt-2 text-light fw-light">Modificar Producto</h5>
            <p class="small text-secondary-custom">ID: #{{ $prod_mod->id_pr }}</p>
        </div>

        <form action="/upProducto/{{$prod_mod->id_pr}}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            
            <div class="mb-3">
                <label for="nombre" class="form-label-dark">Nombre Comercial</label>
                <input type="text" class="form-control input-dark w-100" id="nombre" name="nombre" 
                       value="{{ $prod_mod->nombre }}" required>
            </div>

            <div class="mb-3">
                <label for="concentracion" class="form-label-dark">Concentración</label>
                <input type="text" class="form-control input-dark w-100" id="concentracion" name="concentracion" 
                       value="{{ $prod_mod->concentracion }}" required>
            </div>

            <div class="mb-4">
                <label class="form-label-dark">Ficha Técnica</label>
                
                <div class="file-glass-container">
                    @if($prod_mod->fichaTecnica)
                        <div class="status-indicator">
                            <i class="fa-solid fa-cloud-check me-1"></i> En la nube
                        </div>
                    @endif

                    <div class="input-wrapper-hidden">
                        <div class="icon-shape" id="iconBox">
                            <i class="fa-solid fa-file-pdf fa-lg"></i>
                        </div>
                        
                        <div class="file-info-text">
                            <span class="file-name-display" id="fileNameDisplay">
                                {{ $prod_mod->fichaTecnica ? 'documento_actual.pdf' : 'No se ha seleccionado archivo' }}
                            </span>
                            <span class="text-secondary-custom">
                                Toca para <span class="text-accent">reemplazar</span> (PDF o Imagen)
                            </span>
                        </div>

                        <input type="file" 
                               name="fichaTecnica" 
                               class="input-file-real" 
                               accept="application/pdf, image/*"
                               onchange="handleFileUpdate(this)">
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2">
                <a href="/productos" class="btn btn-back-minimal w-25 d-flex align-items-center justify-content-center">
                    Regresar
                </a>
                <button type="submit" class="btn btn-save-minimal w-75">
                    <i class="fa-solid fa-arrows-rotate me-2"></i> Actualizar Producto
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function handleFileUpdate(input) {
        const fileNameDisplay = document.getElementById('fileNameDisplay');
        const iconBox = document.getElementById('iconBox');
        
        if (input.files && input.files[0]) {
            const file = input.files[0];
            fileNameDisplay.innerText = file.name;
            fileNameDisplay.style.color = "#6dacd6"; 
            
            iconBox.style.background = "rgba(109, 172, 214, 0.15)";
            iconBox.style.borderColor = "#6dacd6";
        }
    }
</script>
@endsection