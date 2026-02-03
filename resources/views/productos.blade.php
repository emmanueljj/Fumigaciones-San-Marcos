@extends('layouts.plantilla')

@section('tittle', 'productos')

@section('titular')
    <x-navbar>
        Productos
    </x-navbar>
@endsection

@section('contenido')

<style>
    .products-container {
        max-width: 1000px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 0.8rem;
    }

    .product-card {
        background-color: #1a1c20;
        border: 1px solid #2d3035;
        border-radius: 12px;
        padding: 0.8rem 1.25rem;
        display: flex;
        align-items: center;
        transition: all 0.2s ease;
    }

    .product-card:hover {
        background-color: #202329;
        border-color: #6dacd6;
        transform: translateY(-2px);
    }

    /* Columnas Equilibradas */
    .col-info { flex: 1.5; display: flex; align-items: center; gap: 1rem; }
    .col-concentration { flex: 1; text-align: center; display: flex; justify-content: center; }
    .col-actions { flex: 0.5; display: flex; justify-content: flex-end; gap: 0.5rem; }

    .product-icon-box {
        width: 42px; height: 42px;
        background-color: #1c222b;
        border: 1px solid #2d3035;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        color: #6dacd6;
    }

    .product-name { font-size: 1rem; font-weight: 600; color: #e0e0e0; margin: 0; }

    /* Estilo para Concentración y Ficha */
    .spec-chip {
        font-size: 0.75rem;
        padding: 5px 12px;
        border-radius: 20px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        transition: 0.2s;
    }

    .chip-concentration {
        background-color: rgba(109, 172, 214, 0.1);
        color: #6dacd6;
        border: 1px solid rgba(109, 172, 214, 0.2);
    }

    .chip-file {
        background-color: rgba(214, 109, 109, 0.1);
        color: #d66d6d;
        border: 1px solid rgba(214, 109, 109, 0.2);
        margin-left: 10px;
    }
    .chip-file:hover { background-color: rgba(214, 109, 109, 0.2); color: #fff; }

    .btn-icon-soft {
        width: 34px; height: 34px; border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        color: #5c6068; transition: 0.2s; background: none; border: none;
    }
    .btn-icon-soft:hover { background-color: #2d3035; color: #fff; }
    .btn-icon-soft.delete:hover { background-color: #2c1a1a; color: #d66d6d; }

    /* Paginación Dark */
    .pagination .page-item .page-link {
        background-color: #1a1c20; border: 1px solid #2d3035; color: #e0e0e0;
    }
    .pagination .page-item.active .page-link {
        background-color: #6dacd6; border-color: #6dacd6; color: #1a1c20;
    }
</style>

<div class="container pb-5">
    <div class="products-container">
        
        <div class="d-none d-md-flex px-3 small text-uppercase fw-bold mb-2" style="letter-spacing: 1px;">
            <div style="flex: 1.5;">Producto</div>
            <div style="flex: 1; text-align: center;">Concentración y Documentos</div>
            <div style="flex: 0.5; text-align: right;">Acciones</div>
        </div>

        @forelse ($productos as $producto)
        <div class="product-card">
            
            <div class="col-info">
                <div class="product-icon-box">
                    <i class="fa-solid fa-flask-vial"></i>
                </div>
                <div>
                    <h4 class="product-name">{{ $producto->nombre }}</h4>
                </div>
            </div>

            <div class="col-concentration">
                <span class="spec-chip chip-concentration" title="Concentración del producto">
                    <i class="fa-solid fa-percent me-1"></i> {{ $producto->concentracion }}
                </span>

                @if($producto->fichaTecnica)
                    <a href="{{ asset('storage/' . $producto->fichaTecnica) }}" target="_blank" class="spec-chip chip-file" title="Ver Ficha Técnica">
                        <i class="fa-solid fa-file-pdf"></i> Ficha
                    </a>
                @endif
            </div>

            <div class="col-actions">
                <a href="/edProducto/{{$producto->id_pr}}" class="btn-icon-soft" title="Editar">
                    <i class="fa-solid fa-pencil"></i>
                </a>

                <form action="/delProd/{{$producto->id_pr}}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-icon-soft delete" 
                            title="Eliminar"
                            onclick="return confirm('¿Eliminar {{ $producto->nombre }}?')">
                        <i class="fa-regular fa-trash-can"></i>
                    </button>
                </form>
            </div>

        </div>
        @empty
            <div class="text-center py-5 card-dark" style="border-radius: 16px;">
                <i class="fa-solid fa-flask-vial fa-3x mb-3 "></i>
                <p>No hay productos registrados en el sistema.</p>
            </div>
        @endforelse

    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $productos->links() }}
    </div>
</div>

@endsection