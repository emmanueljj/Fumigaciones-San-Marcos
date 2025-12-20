@extends('layouts.plantilla')

@section('tittle', 'Técnicos')

@section('titular')
    <x-navbar>
        Tecnicos
    </x-navbar>
@endSection

@section('contenido')

<style>
    .tech-container {
        max-width: 800px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 0.8rem;
    }

    /* La Tarjeta de Técnico */
    .tech-card {
        background-color: #1a1c20; /* Off-Black */
        border: 1px solid #2d3035;
        border-radius: 12px;
        padding: 0.8rem 1.2rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: all 0.2s ease;
    }

    .tech-card:hover {
        background-color: #202329;
        border-color: #3f444d;
        transform: translateX(4px); /* Sutil movimiento a la derecha */
    }

    /* Lado Izquierdo: Avatar + Info */
    .tech-profile {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex: 1;
    }

    /* Avatar Generado (Círculo con icono) */
    .tech-avatar {
        width: 45px;
        height: 45px;
        background-color: #1c222b;
        border: 1px solid #2d3035;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #e0e0e0;
        flex-shrink: 0;
    }

    /* Detalles de texto */
    .tech-info {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .tech-name {
        font-size: 1rem;
        font-weight: 600;
        color: #e0e0e0;
        margin: 0;
    }

    /* Estilo para la CLAVE (Parece un código impreso) */
    .tech-id-badge {
        font-family: 'Courier New', Courier, monospace; /* Fuente técnica */
        font-size: 0.75rem;
        color: #7b8089;
        background-color: rgba(255, 255, 255, 0.03);
        padding: 2px 6px;
        border-radius: 4px;
        margin-top: 4px;
        align-self: flex-start; /* Que no se estire */
        border: 1px solid #2d3035;
        letter-spacing: 0.5px;
    }

    /* Icono pequeño de 'hash' antes de la clave */
    .tech-id-badge i {
        font-size: 0.6rem;
        margin-right: 3px;
        opacity: 0.6;
    }

    /* Botones de Acción (Reutilizando estilo Ghost/Soft) */
    .tech-actions {
        display: flex;
        gap: 0.5rem;
        padding-left: 1rem;
        border-left: 1px solid #2d3035; /* Separador visual */
    }

    .btn-icon-minimal {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        background: transparent;
        color: #5c6068;
        transition: all 0.2s;
        cursor: pointer;
    }

    .btn-icon-minimal:hover {
        background-color: #2d3035;
        color: #e0e0e0;
    }
    
    .btn-icon-minimal.delete:hover {
        background-color: #2c1a1a; /* Rojo oscuro sutil */
        color: #d66d6d;
    }

    /* Responsividad */
    @media (max-width: 576px) {
        .tech-card {
            padding: 0.8rem;
        }
        .tech-actions {
            border-left: none; /* Quitar borde en móvil */
            padding-left: 0.5rem;
        }
    }
</style>

<div class="container pb-5">
    <div class="tech-container">
        
        <div class="d-flex justify-content-between px-2 mb-1">
            <span class="small text-uppercase fw-bold">Personal Registrado</span>
            <span class="small">{{ count($tecnicos) }} Técnicos</span>
        </div>

        @forelse ($tecnicos as $tec)
            <div class="tech-card">
                
                <div class="tech-profile">

                    
                    <div class="tech-info">
                        <h4 class="tech-name">{{ $tec->nombre }}</h4>
                        <span class="tech-id-badge" title="Clave de Empleado">
                            <i class="fa-solid fa-fingerprint"></i>{{ $tec->clave }}
                        </span>
                    </div>
                </div>

                <div class="tech-actions">
                    <a href="/edTecnico/{{$tec->id_tec}}" class="btn-icon-minimal" title="Editar">
                        <i class="fa-solid fa-pencil"></i>
                    </a>

                    <form action="/delTec/{{$tec->id_tec}}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-icon-minimal delete" 
                                onclick="return confirm('¿Estás seguro de eliminar a {{ $tec->nombre }}?')">
                            <i class="fa-regular fa-trash-can"></i>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="text-center py-5 text-muted">
                <i class="fa-solid fa-users-slash fa-3x mb-3 opacity-25"></i>
                <p>No hay técnicos registrados en el sistema.</p>
            </div>
        @endforelse

    </div>
</div>

@endsection