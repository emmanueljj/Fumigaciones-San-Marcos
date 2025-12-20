@extends('layouts.plantilla')

@section('tittle', 'Productos')

@section('titular')
    <x-navbar>
        Productos
    </x-navbar>
@endSection

@section('contenido')

<style>
    /* Contenedor centralizado */
    .products-container {
        max-width: 1000px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 0.8rem;
    }

    /* La Tarjeta de Producto */
    .product-card {
        background-color: #1a1c20; /* Off-Black */
        border: 1px solid #2d3035;
        border-radius: 12px;
        padding: 1rem 1.25rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: all 0.2s ease;
        flex-wrap: wrap; /* Clave para responsividad */
        gap: 1rem;
    }

    .product-card:hover {
        background-color: #202329;
        border-color: #3f444d;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }

    /* Sección Izquierda: Icono + Nombre + Plaga */
    .product-info {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex: 1; /* Ocupa el espacio disponible */
        min-width: 250px;
    }

    /* Icono Decorativo (Matraz/Químico) */
    .product-icon-box {
        width: 42px;
        height: 42px;
        background-color: #1c222b;
        border: 1px solid #2d3035;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6dacd6; /* Azul suave */
        flex-shrink: 0;
    }

    /* Textos Principales */
    .product-name {
        font-size: 1rem;
        font-weight: 600;
        color: #e0e0e0;
        margin: 0;
        line-height: 1.2;
    }

    .product-target {
        font-size: 0.85rem;
        color: #d66d6d; /* Rojo suave para indicar "Plaga/Enemigo" */
        margin: 2px 0 0 0;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* Sección Central: Especificaciones Técnicas (Chips) */
    .product-specs {
        display: flex;
        gap: 0.5rem;
        align-items: center;
        flex-wrap: wrap;
    }

    /* Diseño de los Chips (Etiquetas) */
    .spec-chip {
        font-size: 0.75rem;
        padding: 4px 10px;
        border-radius: 20px;
        font-weight: 500;
        border: 1px solid;
    }

    .chip-method {
        background-color: rgba(23, 162, 184, 0.1);
        color: #17a2b8;
        border-color: rgba(23, 162, 184, 0.2);
    }

    .chip-concentration {
        background-color: rgba(108, 117, 125, 0.1);
        color: #aab0b6;
        border-color: rgba(108, 117, 125, 0.2);
    }

    /* Sección Derecha: Acciones */
    .product-actions {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }

    /* Botones sutiles (Reutilizados del diseño anterior para consistencia) */
    .btn-icon-soft {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid transparent;
        background-color: transparent;
        color: #5c6068;
        transition: all 0.2s;
    }

    .btn-icon-soft:hover {
        background-color: #2d3035;
        color: #e0e0e0;
    }
    
    .btn-icon-soft.delete:hover {
        background-color: #2c1a1a;
        color: #d66d6d;
    }

    /* Responsividad Móvil */
    @media (max-width: 768px) {
        .product-card {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.75rem;
        }
        .product-info { width: 100%; }
        .product-specs { width: 100%; margin-left: 3.5rem; /* Alinear con texto, saltando icono */ }
        .product-actions { 
            width: 100%; 
            justify-content: flex-end; 
            border-top: 1px solid #2d3035;
            padding-top: 0.5rem;
        }
    }
</style>

<div class="container pb-5">
    <div class="products-container">
        
        <div class="d-none d-md-flex px-3 small text-uppercase fw-bold" style="letter-spacing: 1px;">
            <div style="flex: 1;">Producto y Plaga</div>
            <div style="width: 250px;">Especificaciones</div>
            <div style="width: 80px; text-align: right;">Acciones</div>
        </div>

        @forelse ($productos as $producto)
        <div class="product-card">
            
            <div class="product-info">
                <div class="product-icon-box">
                    <i class="fa-solid fa-flask"></i>
                </div>
                <div>
                    <h4 class="product-name">{{ $producto->nombre }}</h4>
                    <p class="product-target">
                        <i class="fa-solid fa-bug fa-xs"></i> {{ $producto->plaga }}
                    </p>
                </div>
            </div>

            <div class="product-specs">
                <span class="spec-chip chip-method" title="Método de aplicación">
                    <i class="fa-solid fa-spray-can me-1"></i> {{ $producto->metodo }}
                </span>
                <span class="spec-chip chip-concentration" title="Concentración">
                    <i class="fa-solid fa-percent me-1"></i> {{ $producto->concentracion }}
                </span>
            </div>

            <div class="product-actions">
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
            <div class="text-center py-5 text-muted">
                <i class="fa-solid fa-flask-vial fa-3x mb-3 opacity-25"></i>
                <p>No hay productos registrados.</p>
            </div>
        @endforelse

    </div>
</div>

@endsection