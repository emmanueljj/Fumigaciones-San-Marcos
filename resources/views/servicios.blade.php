@extends('layouts.plantilla')

@section('title', 'Servicios')

@section('titular')
<x-navbar-3 :id_mes="$id_mes" :empresa="$empresa">
    Servicios 
</x-navbar-3>
@endsection

@section('contenido')

<style>
    /* --- 1. Header de Información --- */
    .info-header {
        background-color: #1a1c20;
        border: 1px solid #2d3035;
        border-radius: 12px;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .info-title { color: #e0e0e0; font-weight: 600; font-size: 1.1rem; margin-bottom: 0.1rem; }
    .info-date { color: #6dacd6; font-size: 0.85rem; display: flex; align-items: center; gap: 0.5rem; }

    /* --- 2. Botón Nuevo --- */
    .btn-new-service {
        background-color: #1c2a35; color: #6dacd6; border: 1px solid #243b4a;
        padding: 0.4rem 1rem; border-radius: 8px; font-size: 0.9rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); text-decoration: none;
        display: inline-flex; align-items: center; gap: 0.4rem;
    }
    .btn-new-service:hover { background-color: #6dacd6; color: #1a1c20; transform: translateY(-2px); }

    /* --- 3. Filas de Servicio --- */
    .service-row {
        background-color: #1a1c20; border: 1px solid #2d3035; border-radius: 10px;
        padding: 0.6rem 1rem; display: flex; align-items: center;
        justify-content: space-between; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        margin-bottom: 0.6rem; position: relative;
    }

    .service-row:hover {
        background-color: #202329; border-color: #4a4f58;
        transform: translateX(6px); box-shadow: -4px 0 0 #6dacd6;
    }

    /* --- 4. Iconos e Info --- */
    .date-icon-box {
        width: 36px; height: 36px; background-color: #25282e;
        border: 1px solid #2d3035; border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        color: #6dacd6; font-size: 0.9rem; transition: transform 0.3s ease;
    }

    .service-date-text { font-size: 0.95rem; font-weight: 600; color: #e0e0e0; margin: 0; }
    .service-meta { font-size: 0.78rem; color: rgba(224, 224, 224, 0.4); margin-top: 1px; }

    /* --- 5. Icono PDF Control Perimetral --- */
    .btn-pdf-perimetral {
        position: relative;
        z-index: 10; /* Por encima del stretched-link */
        color: #d66d6d; /* Rojo suave */
        font-size: 1.1rem;
        padding: 5px 10px;
        border-radius: 6px;
        transition: 0.3s;
        text-decoration: none;
    }
    .btn-pdf-perimetral:hover {
        background-color: rgba(214, 109, 109, 0.1);
        color: #ff6b6b;
        transform: scale(1.1);
    }

    /* --- 6. Acciones --- */
    .service-actions {
        display: flex; align-items: center; gap: 0.5rem;
        padding-left: 0.8rem; border-left: 1px solid #2d3035; z-index: 10;
    }

    .btn-action-soft {
        width: 32px; height: 32px; border-radius: 7px;
        display: flex; align-items: center; justify-content: center;
        background: #25282e; border: 1px solid #2d3035;
        color: #7b8089; font-size: 0.85rem; transition: 0.3s;
    }

    .btn-action-soft.edit:hover { background-color: #1c2a35; color: #6dacd6; border-color: #6dacd6; }
    .btn-action-soft.delete:hover { background-color: #2c1a1a; color: #ff6b6b; border-color: #ff6b6b; }

    .stretched-link::after { z-index: 1; }
    .service-info { display: flex; align-items: center; gap: 0.8rem; z-index: 5; flex-grow: 1; }
</style>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-9 col-lg-8">
            
            <div class="info-header">
                <div>
                    <h4 class="info-title">{{ $empresa->nombre }}</h4>
                    <p class="info-date">
                        <i class="fa-solid fa-calendar-week"></i> 
                        {{ $mes->fecha_I }} <span style="opacity: 0.3; margin: 0 5px;">/</span> {{ $mes->fecha_f }}
                    </p>
                </div>
                <a href="/ag_Servicios/{{ $id_mes }}" class="btn-new-service">
                    <i class="fa-solid fa-plus"></i> Nuevo Servicio
                </a>
            </div>

            <div class="services-list">
                @forelse ($servicios as $servicio)
                    @php
                        $datos = ['id_mes' => $id_mes, 'id_servicio' => $servicio->id_servicio];
                    @endphp

                    <div class="service-row">
                        {{-- Link principal a actividades --}}
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
                                    <i class="fa-solid fa-clock fa-xs me-1"></i> Registrado el {{ $servicio->created_at->format('H:i') }}
                                </p>
                            </div>
                        </div>

                        {{-- ICONO PDF CONTROL PERIMETRAL --}}
                        @if($servicio->controlPerimetral)
                            <a href="{{ asset('storage/' . $servicio->controlPerimetral) }}" 
                               target="_blank" 
                               class="btn-pdf-perimetral" 
                               title="Ver Control Perimetral">
                                <i class="fa-solid fa-file-pdf"></i>
                                <span style="font-size: 0.65rem; font-weight: bold; display: block; margin-top: -3px;">PDF</span>
                            </a>
                        @endif

                        <div class="service-actions">
                            <a href="{{route('servicio.editar', $datos)}}" class="btn-action-soft edit" title="Editar">
                                <i class="fa-solid fa-pencil"></i>
                            </a>
                            
                            <form action="/delSer/{{ $servicio->id_servicio }}" method="POST" class="d-inline m-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action-soft delete" title="Eliminar" onclick="return confirm('¿Eliminar servicio?')">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="text-center p-5 border border-secondary border-dashed rounded" style="opacity: 0.3; border-style: dashed !important;">
                        <i class="fa-solid fa-folder-open fa-2x mb-2"></i>
                        <p>No hay servicios registrados en este periodo.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</div>

@endsection