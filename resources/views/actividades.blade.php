@extends('layouts.plantilla')

{{-- Corregido: title con una sola 't' --}}
@section('title', 'Gestionar Actividades')

@section('titular')
<x-navbar :id_mes="$id_mes" :empresa="$empresa">
    Actividades del Servicio
</x-navbar>
@endsection

@section('contenido')
<style>
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
    
    /* Estilos base para la lista de actividades */
    .actividades-container {
        display: flex;
        flex-direction: column;
        gap: 0.6rem;
    }

    .actividad-row {
        background-color: #1a1c20;
        border: 1px solid #2d3035;
        border-radius: 10px;
        padding: 0.7rem 1.2rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }

    .actividad-row:hover {
        background-color: #202329;
        border-color: #4a4f58;
        transform: translateX(6px);
        box-shadow: -4px 0 0 #6dacd6;
    }

    .actividad-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .time-badge {
        background-color: #1c2a35;
        color: #6dacd6;
        padding: 0.2rem 0.6rem;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 600;
        border: 1px solid #243b4a;
    }

    .actividad-nombre {
        color: #e0e0e0;
        margin: 0;
        font-size: 0.95rem;
        font-weight: 500;
    }

    /* Botones de acción Slim */
    .actividad-actions {
        display: flex;
        gap: 0.5rem;
        z-index: 10;
    }

    .btn-action-slim {
        width: 30px;
        height: 30px;
        border-radius: 7px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #25282e;
        border: 1px solid #2d3035;
        color: #7b8089;
        font-size: 0.8rem;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .btn-action-slim.edit:hover {
        background-color: #1c2a35;
        color: #6dacd6;
        border-color: #6dacd6;
        transform: scale(1.1);
    }

    .btn-action-slim.delete:hover {
        background-color: #2c1a1a;
        color: #ff6b6b;
        border-color: #ff6b6b;
        transform: scale(1.1);
    }

    /* Estado vacío */
    .empty-actividades {
        text-align: center;
        padding: 4rem 2rem;
        border: 1px dashed #2d3035;
        border-radius: 16px;
        color: #5c6068;
        background-color: rgba(26, 28, 32, 0.3);
    }

    .empty-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.3;
        color: #6dacd6;
    }
</style>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">

            {{-- Botón rápido para agregar actividad --}}
            <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('actividades.crear', ['id_servicio' => $id_servicio, 'id_mes' => $id_mes, 'id_empresa' => $empresa->id_empresa]) }}" class="btn-new-service">
                Nueva Actividad
            </a>
            </div>

            <div class="actividades-container">
                @forelse ($actividades as $actividad)
                    <div class="actividad-row">
                        <div class="actividad-info">
                            <div class="time-badge">
                                <i class="fa-regular fa-clock me-1"></i>
                                {{ \Carbon\Carbon::parse($actividad->hora)->format('H:i') }}
                            </div>
                            <h5 class="actividad-nombre">{{ $actividad->nombre }}</h5>
                        </div>

                        <div class="actividad-actions">
                            {{-- Botón Editar --}}
                            <a href="{{route('actividad.editar',['id' =>$actividad->id , 'id_empresa'=>$empresa->id_empresa, 'id_mes' => $id_mes, 'id_servicio' => $id_servicio])}}" class="btn-action-slim edit" title="Editar actividad">
                                <i class="fa-solid fa-pencil"></i>
                            </a>

                            {{-- Formulario de Borrado --}}
                            <form action="/delAct/{{$actividad->id}}" method="POST" class="m-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action-slim delete" 
                                        onclick="return confirm('¿Eliminar esta actividad?')" 
                                        title="Eliminar actividad">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="empty-actividades">
                        <div class="empty-icon">
                            <i class="fa-solid fa-clipboard-list"></i>
                        </div>
                        <h5>Sin actividades</h5>
                        <p class="small mb-0">No hay registros para este servicio.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</div>
@endsection