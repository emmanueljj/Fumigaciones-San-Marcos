@extends('layouts.plantilla')

@section('tittle', 'Gestionar Actividades')

@section('titular')
{{-- Reutilizamos tu navbar, asumiendo que quieres el botón de regresar integrado --}}
<x-navbar :id_mes="$id_mes" :empresa="$empresa">
    Actividades del Servicio
</x-navbar>
@endSection

@section('contenido')
<style>
    /* --- Estilos Específicos para Lista de Actividades --- */
    
    /* Contenedor principal oscuro pero con profundidad */
    .activity-container {
        background-color: #1a1c20;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.5);
    }

    /* El item individual (la barra) */
    .activity-item {
        background-color: #25282c; /* Un gris un poco más claro que el fondo */
        border: 1px solid #363a40;
        border-radius: 12px;
        padding: 1rem 1.2rem;
        transition: all 0.3s ease;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }

    /* Efecto al pasar el mouse */
    .activity-item:hover {
        background-color: #2d3238;
        transform: translateY(-2px);
        border-color: #6dacd6; /* Azul sutil al hacer hover */
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    }

    .activity-text {
        color: #e0e0e0;
        font-size: 1.05rem;
        font-weight: 500;
        /* Truncar texto si es muy largo para que no rompa el diseño */
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 70%; 
    }

    /* Botones de acción circulares */
    .action-btn {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        transition: transform 0.2s;
        cursor: pointer;
        text-decoration: none;
    }
    
    .action-btn:hover { transform: scale(1.1); }

    .btn-edit-custom {
        background-color: #0d6efd; /* Azul Bootstrap */
        color: white;
        box-shadow: 0 0 10px rgba(13, 110, 253, 0.4);
    }

    .btn-delete-custom {
        background-color: #dc3545; /* Rojo Bootstrap */
        color: white;
        box-shadow: 0 0 10px rgba(220, 53, 69, 0.4);
    }

    /* Botón Agregar Grande */
    .btn-add-block {
        background-color: #e0e0e0; /* Gris claro como en tu imagen */
        color: #1a1c20;
        font-weight: bold;
        border: none;
        border-radius: 12px;
        padding: 12px;
        width: 100%;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: background-color 0.3s;
    }

    .btn-add-block:hover {
        background-color: #ffffff;
        box-shadow: 0 0 15px rgba(255, 255, 255, 0.2);
    }

    /* Estilo para cuando no hay datos */
    .empty-state {
        border: 2px dashed #363a40;
        border-radius: 12px;
        padding: 3rem;
        text-align: center;
        color: #6c757d;
    }
</style>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">

            {{-- Encabezado con botón de regreso manual (si no usas el navbar para esto) --}}
            {{-- <div class="d-flex align-items-center mb-4">
                <a href="/servicios/{{ $id_mes }}" class="text-decoration-none text-secondary me-3">
                    <i class="fa-solid fa-arrow-left fa-2x hover-light"></i>
                </a>
                <h3 class="text-light m-0 fw-light">Actividades:</h3>
            </div> --}}

            <div class="activity-container">
                
                {{-- LISTA DE ACTIVIDADES --}}
                <div class="activity-list mb-4">
                    
                    @forelse ($actividades as $actividad)
                        <div class="activity-item">
                            
                            {{-- Texto de la actividad --}}
                            <div class="activity-text" title="{{ $actividad->descripcion }}">
                                {{ $actividad->descripcion }}
                            </div>

                            {{-- Acciones (Editar y Eliminar) --}}
                            <div class="d-flex gap-2">
                                {{-- Botón Editar --}}
                                <a href="{{ route('actividades.edit', $actividad->id) }}" class="action-btn btn-edit-custom" title="Editar">
                                    <i class="fa-solid fa-pen"></i>
                                </a>

                                {{-- Botón Eliminar (Con formulario para seguridad) --}}
                                <form action="{{ route('actividades.destroy', $actividad->id) }}" method="POST" class="d-inline form-delete">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn btn-delete-custom" title="Eliminar">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>

                        </div>
                    @empty
                        {{-- Estado Vacío: Se muestra si no hay registros --}}
                        <div class="empty-state">
                            <i class="fa-regular fa-clipboard fa-3x mb-3 opacity-50"></i>
                            <p class="mb-0">No hay actividades registradas aún.</p>
                            <small>Presiona "Agregar" para comenzar.</small>
                        </div>
                    @endforelse

                </div>

                {{-- BOTÓN AGREGAR (Footer) --}}
                <div>
                    {{-- Asume una ruta para crear, o puede abrir un modal --}}
                    <a href="{{ route('actividades.create', ['id_servicio' => $servicio->id]) }}" class="btn btn-add-block">
                        <i class="fa-solid fa-plus me-2"></i> Agregar
                    </a>
                </div>

            </div>

            {{-- Mensajes de feedback --}}
            @if(session('success'))
                <div class="alert alert-success bg-opacity-10 border-success text-success mt-3 rounded-3">
                    <i class="fa-solid fa-check-circle me-2"></i> {{ session('success') }}
                </div>
            @endif

        </div>
    </div>
</div>

<script>
    // Pequeño script para confirmar eliminación (UX Safety)
    document.querySelectorAll('.form-delete').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            if (confirm('¿Estás seguro de eliminar esta actividad?')) {
                this.submit();
            }
        });
    });
</script>

@endSection