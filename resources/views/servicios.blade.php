@extends('layouts.plantilla')

@endphp
@section('tittle', 'Servicios')

@section('titular')
<x-navbar :id_mes="$id_mes" :empresa="$empresa">
    Servicios 
</x-navbar>
@endSection

@section('contenido')

<style>
    /* 1. Header de Información */
    .info-header {
        background-color: #1a1c20;
        border: 1px solid #2d3035;
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 4px 20px rgba(0,0,0,0.2);
    }

    .info-title {
        color: #e0e0e0;
        font-weight: 600;
        margin-bottom: 0.2rem;
    }

    .info-date {
        color: #6dacd6; /* Azul suave */
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* Botón Nuevo (Estilo sólido pero desaturado) */
    .btn-new-service {
        background-color: #1c2a35;
        color: #6dacd6;
        border: 1px solid #243b4a;
        padding: 0.6rem 1.2rem;
        border-radius: 10px;
        font-weight: 500;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-new-service:hover {
        background-color: #243b4a;
        color: #fff;
        transform: translateY(-1px);
    }

    /* 2. Lista de Servicios */
    .services-list {
        display: flex;
        flex-direction: column;
        gap: 0.8rem;
    }

    /* Fila Individual */
    .service-row {
        background-color: #1a1c20;
        border: 1px solid #2d3035;
        border-radius: 12px;
        padding: 1rem 1.2rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: all 0.2s ease;
    }

    .service-row:hover {
        background-color: #202329;
        border-color: #3f444d;
        transform: translateX(4px);
    }

    /* Columna Izquierda: Fecha e Info */
    .service-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    /* Icono de Calendario (Box decorativo) */
    .date-icon-box {
        width: 45px;
        height: 45px;
        background-color: #1c222b;
        border: 1px solid #2d3035;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #e0e0e0;
        flex-shrink: 0;
    }

    .service-date-text {
        font-size: 1.05rem;
        font-weight: 600;
        color: #e0e0e0;
        margin: 0;
    }

    .service-meta {
        font-size: 0.85rem;
        color: #7b8089;
        margin-top: 2px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    /* Columna Derecha: Acciones */
    .service-actions {
        display: flex;
        gap: 0.5rem;
        padding-left: 1rem;
        border-left: 1px solid #2d3035;
    }

    /* Botones de acción sutiles */
    .btn-action-soft {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: transparent;
        border: none;
        color: #5c6068;
        transition: all 0.2s;
        cursor: pointer;
        text-decoration: none;
    }

    .btn-action-soft:hover { background-color: #2d3035; color: #fff; }
    .btn-action-soft.delete:hover { background-color: #2c1a1a; color: #d66d6d; }

    /* Estado Vacío */
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: #5c6068;
        border: 1px dashed #2d3035;
        border-radius: 16px;
        background-color: rgba(26, 28, 32, 0.5);
    }

    @media (max-width: 576px) {
        .info-header { flex-direction: column; gap: 1rem; text-align: center; }
        .service-row { padding: 0.8rem; }
        .service-actions { border-left: none; }
    }
</style>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">
            
            <div class="info-header">
                <div>
                    <h4 class="info-title">{{ $empresa->nombre }}</h4>
                    <p class="info-date">
                        <i class="fa-solid fa-calendar-week"></i> 
                        {{ $mes->fecha_I }} <span class="text-muted mx-1">/</span> {{ $mes->fecha_f }}
                    </p>
                </div>
                <a href="/ag_Servicios/{{ $id_mes }}" class="btn-new-service">
                    <i class="fa-solid fa-plus"></i> Nuevo Servicio
                </a>
            </div>

            <div class="services-list">
                @if($servicios->isEmpty())
                    <div class="empty-state">
                        <i class="fa-regular fa-calendar-xmark fa-3x mb-3 opacity-50"></i>
                        <p class="mb-0">No hay servicios registrados para este periodo.</p>
                    </div>
                @else
                    @foreach ($servicios as $servicio)
                        @php
                            $datos= [
                                'id_mes'=> $id_mes,
                                'id_servicio'=> $servicio->id_servicio
                        ];
                        @endphp

                        <a href="/actividades/{{$servicio->id_servicio}}">
                    <div class="service-row">
                        
                        <div class="service-info">
                            <div class="date-icon-box">
                                <i class="fa-solid fa-file-contract"></i>
                            </div>
                            <div>
                                <h5 class="service-date-text">
                                    {{ \Carbon\Carbon::parse($servicio->fecha)->format('d/m/Y') }}
                                </h5>
                                @if($servicio->vb_nombre)
                                    <p class="service-meta">
                                        <i class="fa-solid fa-signature fa-xs"></i> 
                                        VB: {{ $servicio->vb_nombre }}
                                    </p>
                                @else
                                    <p class="service-meta text-warning opacity-75">
                                        <i class="fa-solid fa-triangle-exclamation fa-xs"></i> 
                                        Sin Visto Bueno
                                    </p>
                                @endif
                            </div>
                        </div>

                        <div class="service-actions">
                            <a href="{{route('servicio.editar',$datos)}}" class="btn-action-soft" title="Editar">
                                <i class="fa-solid fa-pencil"></i>
                            </a>
                            
                            <form action="/delSer/{{ $servicio->id_servicio }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action-soft delete" 
                                        title="Eliminar"
                                        onclick="return confirm('¿Eliminar servicio del {{ \Carbon\Carbon::parse($servicio->fecha)->format('d/m/Y') }}?')">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    </a>
                    @endforeach
                @endif
            </div>

        </div>
    </div>
</div>

@endsection