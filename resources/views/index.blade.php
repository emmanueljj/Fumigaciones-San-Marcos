@extends('layouts.plantilla')

@section('tittle', 'Inicio')

@section('titular')
    <x-navbar>
        Empresas
    </x-navbar>
@endSection

@section('contenido')

<style>
    /* Contenedor principal para dar aire */
    .list-container {
        max-width: 900px; /* Ancho controlado para mejor lectura */
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 0.75rem; /* Espacio entre filas */
    }

    /* La fila de la empresa (Row) */
    .company-row {
        background-color: #1a1c20; /* Off-Black */
        border: 1px solid #2d3035;
        border-radius: 12px;
        padding: 0.75rem 1rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: all 0.2s ease;
        position: relative;
    }

    /* Efecto Hover sutil en toda la fila */
    .company-row:hover {
        background-color: #202329;
        border-color: #3f444d;
        transform: translateX(5px); /* Pequeño desplazamiento a la derecha */
    }

    /* Enlace invisible que cubre el área de texto e imagen (UX: Click Area) */
    .company-info-link {
        display: flex;
        align-items: center;
        gap: 1rem;
        text-decoration: none;
        flex-grow: 1; /* Ocupa todo el espacio disponible a la izquierda */
        min-width: 0; /* Permite truncar texto */
    }

    /* Avatar Pequeño y Elegante */
    .company-avatar {
        width: 48px;
        height: 48px;
        border-radius: 10px; /* Cuadrado suavizado (Squircle) */
        object-fit: cover;
        background-color: #2d3035;
        border: 1px solid #333;
    }

    /* Textos */
    .company-details {
        display: flex;
        flex-direction: column;
        justify-content: center;
        min-width: 0; /* Necesario para text-truncate */
    }

    .company-name {
        color: #e0e0e0;
        font-weight: 600;
        font-size: 1rem;
        margin: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis; /* Puntos suspensivos si es muy largo */
    }

    .company-manager {
        color: #6c757d;
        font-size: 0.8rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    /* Grupo de Botones (Derecha) */
    .action-group {
        display: flex;
        gap: 0.5rem;
        margin-left: 1rem;
        /* Separación visual vertical */
        padding-left: 1rem;
        border-left: 1px solid #333; 
    }

    /* Botones Icon-Only (Minimalistas) */
    .btn-icon-ghost {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        border: none;
        background: transparent;
        color: #5c6068; /* Color apagado por defecto */
        transition: all 0.2s;
        cursor: pointer;
    }

    .btn-icon-ghost:hover {
        background-color: #2d3035;
    }

    .btn-icon-ghost.edit:hover { color: #6dacd6; } /* Azul suave al hover */
    .btn-icon-ghost.delete:hover { color: #d66d6d; background-color: #2c1a1a; } /* Rojo suave al hover */

    /* Ajuste Móvil: Avatar más pequeño */
    @media (max-width: 576px) {
        .company-avatar { width: 40px; height: 40px; }
        .action-group { padding-left: 0.5rem; border: none; }
        .company-manager { display: none; } /* Ocultar encargado en móviles muy pequeños para limpiar vista */
    }

    /* Ajuste para que los botones de paginación sean oscuros */
    .pagination .page-item .page-link {
        background-color: rgba(26, 28, 32, 0.6) !important;
        backdrop-filter: blur(8px);
        border: 1px solid #2d3035 !important;
        color: #e0e0e0 !important;

    }

    .pagination .page-item.active .page-link {
        background-color: #6dacd6 !important; /* Azul San Marcos */
        border-color: #6dacd6 !important;
        color: #1a1c20 !important;
    }

    .pagination .page-item.disabled .page-link {
        background-color: #0f1012 !important;
        color: #5c6068 !important;
    }

    .contenedor_paginacion{
        position: relative;
        display: flex;
        justify-content: space-around;
    }
</style>

<div class="container pb-5">
    <div class="list-container">
        
        @forelse ($empresas as $empresa)
            <div class="company-row">
                
                <a href="/meses/{{$empresa->id_empresa}}" class="company-info-link">
                    
                    @if($empresa->foto)
                        <img src="{{ asset('storage/' . $empresa->foto) }}" class="company-avatar" alt="Logo">
                    @else
                        <div class="company-avatar d-flex align-items-center justify-content-center text-muted">
                            <i class="fa-solid fa-building"></i>
                        </div>
                    @endif

                    <div class="company-details">
                        <h3 class="company-name">{{$empresa->nombre}}</h3>
                        <p class="company-manager">
                            <i class="fa-solid fa-user-tie fa-xs"></i> 
                            {{$empresa->encargado}}
                        </p>
                    </div>
                </a>

                <div class="action-group">
                    
                    <button onclick="window.location.href='edEmpresa/{{$empresa->id_empresa}}'" 
                            class="btn-icon-ghost edit" 
                            title="Editar">
                        <i class="fa-solid fa-pencil"></i>
                    </button>

                    <form action="/delEmp/{{$empresa->id_empresa}}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="btn-icon-ghost delete" 
                                title="Eliminar"
                                onclick="return confirm('¿Eliminar {{ $empresa->nombre }}?')">
                            <i class="fa-regular fa-trash-can"></i>
                        </button>
                    </form>
                </div>

            </div>
        @empty
            <div class="text-center py-5 text-muted">
                <i class="fa-regular fa-folder-open fa-3x mb-3 opacity-25"></i>
                <p>No hay empresas registradas aún.</p>
            </div>
        @endforelse

    </div>

    <div class="d-flex justify-content-center mt-4 contenedor_paginacion">
    {{ $empresas->links() }}
    </div>

</div>



@endSection