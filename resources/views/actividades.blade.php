@extends('layouts.plantilla')

@section('title', 'Gestionar Actividades')

@section('titular')
<x-navbar :id_mes="$id_mes" :empresa="$empresa">
    Actividades del Servicio
</x-navbar>
@endsection

@section('contenido')
<style>
    .btn-new-service {
        background-color: #1c2a35; color: #6dacd6; border: 1px solid #243b4a;
        padding: 0.4rem 1rem; border-radius: 8px; font-size: 0.9rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); text-decoration: none;
        display: inline-flex; align-items: center; gap: 0.4rem;
    }
    .btn-new-service:hover { background-color: #6dacd6; color: #1a1c20; transform: translateY(-2px); }
    
    .actividades-container { display: flex; flex-direction: column; gap: 0.6rem; }

    .actividad-row {
        background-color: #1a1c20; border: 1px solid #2d3035; border-radius: 10px;
        padding: 0.7rem 1.2rem; display: flex; align-items: center;
        justify-content: space-between; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }

    .actividad-row:hover {
        background-color: #202329; border-color: #4a4f58;
        transform: translateX(6px); box-shadow: -4px 0 0 #6dacd6;
    }

    .actividad-info { display: flex; align-items: center; gap: 1rem; }

    .time-badge {
        background-color: #1c2a35; color: #6dacd6; padding: 0.2rem 0.6rem;
        border-radius: 6px; font-size: 0.85rem; font-weight: 600; border: 1px solid #243b4a;
    }

    .actividad-nombre { color: #e0e0e0; margin: 0; font-size: 0.95rem; font-weight: 500; }

    /* CONTENEDORES DE PREVISUALIZACIÓN (POP-UPS) */
    .preview-trigger { position: relative; display: inline-block; }

    .pop-preview {
        position: absolute;
        bottom: 120%; /* Aparece arriba del icono */
        left: 50%;
        transform: translateX(-50%) scale(0.8);
        width: 180px;
        height: auto;
        background: #1a1c20;
        border: 2px solid #6dacd6;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        z-index: 100;
        opacity: 0;
        pointer-events: none;
        transition: all 0.2s ease;
        padding: 5px;
    }

    .pop-preview img {
        width: 100%;
        border-radius: 8px;
        display: block;
    }

    /* Mostrar al hacer hover */
    .preview-trigger:hover .pop-preview {
        opacity: 1;
        transform: translateX(-50%) scale(1);
        pointer-events: auto;
    }

    /* Específico para firma: invertir colores si es necesario */
    .firma-pop img { filter: invert(0.9); background: #fff; }

    .actividad-actions { display: flex; gap: 0.5rem; align-items: center; }

    .btn-action-slim {
        width: 30px; height: 30px; border-radius: 7px;
        display: flex; align-items: center; justify-content: center;
        background: #25282e; border: 1px solid #2d3035;
        color: #7b8089; font-size: 0.8rem; transition: 0.3s; text-decoration: none;
    }

    .btn-action-slim:hover { color: #fff; background: #363a42; }
    .btn-action-slim.edit:hover { background: #1c2a35; color: #6dacd6; border-color: #6dacd6; }
    .btn-action-slim.delete:hover { background: #2c1a1a; color: #ff6b6b; border-color: #ff6b6b; }
</style>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-9 col-lg-8">

            <div class="d-flex justify-content-end mb-3">
                <a href="{{ route('actividades.crear', ['id_servicio' => $id_servicio, 'id_mes' => $id_mes, 'id_empresa' => $empresa->id_empresa]) }}" class="btn-new-service">
                    <i class="fa-solid fa-plus"></i> Nueva Actividad
                </a>
            </div>

            <div class="actividades-container">
                @forelse ($actividades as $actividad)
                    <div class="actividad-row">
                        <div class="actividad-info">
                            <div class="time-badge">
                                {{ \Carbon\Carbon::parse($actividad->hora)->format('H:i') }}
                            </div>
                            <div>
                                <h5 class="actividad-nombre">{{ $actividad->nombre }}</h5>
                                <small style="color: rgba(224,224,224,0.4); font-size: 0.75rem;">{{ $actividad->area }}</small>
                            </div>
                        </div>

                        <div class="actividad-actions">
                            @if($actividad->foto)
                            <div class="preview-trigger">
                                <div class="btn-action-slim"><i class="fa-solid fa-camera"></i></div>
                                <div class="pop-preview">
                                    <img src="{{ url('storage/' . $actividad->foto) }}" alt="Evidencia">
                                </div>
                            </div>
                            @endif

                            @if($actividad->vbFirma)
                            <div class="preview-trigger">
                                <div class="btn-action-slim"><i class="fa-solid fa-signature"></i></div>
                                <div class="pop-preview firma-pop">
                                    <img src="{{ url('storage/' . $actividad->vbFirma) }}" alt="Firma">
                                </div>
                            </div>
                            @endif

                            <div style="width: 1px; height: 20px; background: #2d3035; margin: 0 5px;"></div>

                            <a href="{{route('actividad.editar',['id' =>$actividad->id , 'id_empresa'=>$empresa->id_empresa, 'id_mes' => $id_mes, 'id_servicio' => $id_servicio])}}" class="btn-action-slim edit">
                                <i class="fa-solid fa-pencil"></i>
                            </a>

                            <form action="/delAct/{{$actividad->id}}" method="POST" class="m-0">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-action-slim delete" onclick="return confirm('¿Eliminar?')">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="empty-actividades">
                        <i class="fa-solid fa-clipboard-list empty-icon"></i>
                        <h5>Sin actividades</h5>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</div>
@endsection