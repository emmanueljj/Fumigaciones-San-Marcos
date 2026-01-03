@extends('layouts.plantilla')

@section('title', 'Servicios')

@section('titular')
<x-navbar :id_mes="$id_mes" :empresa="$empresa">
    Servicios 
</x-navbar>
@endsection

@section('contenido')

<style>
    /* --- 1. Header de Información (Más compacto) --- */
    .info-header {
        background-color: #1a1c20;
        border: 1px solid #2d3035;
        border-radius: 12px;
        padding: 1rem 1.5rem; /* Reducido */
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .info-title {
        color: #e0e0e0;
        font-weight: 600;
        font-size: 1.1rem; /* Más pequeño */
        margin-bottom: 0.1rem;
    }

    .info-date {
        color: #6dacd6;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* --- 2. Botón Nuevo (Más delgado) --- */
    .btn-new-service {
        background-color: #1c2a35;
        color: #6dacd6;
        border: 1px solid #243b4a;
        padding: 0.4rem 1rem; /* Más delgado */
        border-radius: 8px;
        font-size: 0.9rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }

    .btn-new-service:hover {
        background-color: #6dacd6;
        color: #1a1c20;
        transform: translateY(-2px);
    }

    /* --- 3. Filas de Servicio (Versión Slim) --- */
    .service-row {
        background-color: #1a1c20;
        border: 1px solid #2d3035;
        border-radius: 10px;
        padding: 0.6rem 1rem; /* Reducción drástica de altura */
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        margin-bottom: 0.6rem;
        position: relative;
    }

    .service-row:hover {
        background-color: #202329;
        border-color: #4a4f58;
        transform: translateX(6px);
        box-shadow: -4px 0 0 #6dacd6;
    }

    /* --- 4. Iconos e Info (Más pequeños) --- */
    .date-icon-box {
        width: 36px; /* De 45px a 36px */
        height: 36px;
        background-color: #25282e;
        border: 1px solid #2d3035;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6dacd6;
        font-size: 0.9rem;
        transition: transform 0.3s ease;
    }

    .service-row:hover .date-icon-box {
        transform: scale(1.05) rotate(-5deg);
    }

    .service-date-text {
        font-size: 0.95rem; /* Texto más fino */
        font-weight: 600;
        color: #e0e0e0;
        margin: 0;
    }

    .service-meta {
        font-size: 0.78rem;
        color: #7b8089;
        margin-top: 1px;
    }

    /* --- 5. Acciones (Botones Mini) --- */
    .service-actions {
        display: flex;
        gap: 0.5rem;
        padding-left: 0.8rem;
        border-left: 1px solid #2d3035;
        z-index: 10;
    }

    .btn-action-soft {
        width: 32px; /* De 38px a 32px */
        height: 32px;
        border-radius: 7px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #25282e;
        border: 1px solid #2d3035;
        color: #7b8089;
        font-size: 0.85rem;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .btn-action-soft.edit:hover {
        background-color: #1c2a35;
        color: #6dacd6;
        border-color: #6dacd6;
        transform: scale(1.15) rotate(15deg);
    }

    .btn-action-soft.delete:hover {
        background-color: #2c1a1a;
        color: #ff6b6b;
        border-color: #ff6b6b;
        transform: scale(1.15);
        animation: shake 0.4s ease-in-out infinite alternate;
    }

    @keyframes shake {
        0% { transform: rotate(4deg) scale(1.15); }
        100% { transform: rotate(-4deg) scale(1.15); }
    }

    /* Stretched link corregido */
    .stretched-link::after { z-index: 1; }
    .service-info { display: flex; align-items: center; gap: 0.8rem; z-index: 5; }

    @media (max-width: 576px) {
        .service-row { padding: 0.5rem; }
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
                    <i class="fa-solid fa-plus"></i> Nuevo
                </a>
            </div>

            <div class="services-list">
                @forelse ($servicios as $servicio)
                    @php
                        $datos = ['id_mes' => $id_mes, 'id_servicio' => $servicio->id_servicio];
                    @endphp

                    <div class="service-row position-relative">
                        <a href="/actividades/{{$servicio->id_servicio}}" class="stretched-link"></a>

                        <div class="service-info">
                            <div class="date-icon-box">
                                <i class="fa-solid fa-file-contract"></i>
                            </div>
                            <div>
                                <h5 class="service-date-text">
                                    {{ \Carbon\Carbon::parse($servicio->fecha)->format('d/m/Y') }}
                                </h5>
                                    <p class="service-meta m-0">
                                        <i class="fa-solid fa-signature fa-xs"></i> {{ $servicio->vb_nombre }}
                                    </p>
                            </div>
                        </div>

                        <div class="service-actions">
                            <a href="{{route('servicio.editar', $datos)}}" class="btn-action-soft edit" title="Editar">
                                <i class="fa-solid fa-pencil"></i>
                            </a>
                            
                            <form action="/delSer/{{ $servicio->id_servicio }}" method="POST" class="d-inline m-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action-soft delete" title="Eliminar" onclick="return confirm('¿Eliminar?')">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="text-center p-4 border border-secondary border-dashed rounded opacity-50">
                        No hay registros.
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</div>

@endsection