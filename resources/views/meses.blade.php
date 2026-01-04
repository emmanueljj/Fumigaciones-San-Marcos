@extends('layouts.plantilla')

@section('tittle')
    Meses {{ $empresa->nombre }}
@endsection

@section('titular')
<x-navbar-2 :empresa="$empresa">
    Meses
</x-navbar-2>
@endsection

@section('contenido')

<style>
    /* RESET VISUAL: Rompemos la caja */
    .void-container {
        position: relative;
        max-width: 600px;
        height: 60vh; /* Ocupa buena parte de la pantalla */
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        justify-content: center;
        perspective: 1000px; /* Para efecto 3D sutil */
    }

    /* HEADER FLOTANTE */
    .void-header {
        text-align: center;
        margin-bottom: 2rem;
        opacity: 0.5;
        transition: opacity 0.3s;
    }
    .void-header:hover { opacity: 1; }
    .void-header h2 {
        font-weight: 300;
        letter-spacing: 2px;
        text-transform: uppercase;
        font-size: 0.9rem;
        color: #6dacd6;
    }

    /* EL NÚCLEO (Scroll) */
    .stream-wrapper {
        position: relative;
        height: 400px;
        overflow-y: scroll;
        scroll-behavior: smooth;
        scroll-snap-type: y mandatory;
        
        /* MAGIA: Desvanecer bordes con máscara alpha */
        mask-image: linear-gradient(to bottom, transparent 0%, black 20%, black 80%, transparent 100%);
        -webkit-mask-image: linear-gradient(to bottom, transparent 0%, black 20%, black 80%, transparent 100%);
    }

    /* Ocultar scrollbar completamente */
    .stream-wrapper::-webkit-scrollbar { display: none; }
    .stream-wrapper { -ms-overflow-style: none; scrollbar-width: none; }

    /* Padding para centrar el primer y último elemento */
    .stream-padding { height: 150px; }

    /* ITEM FLOTANTE */
    .stream-item {
        height: 100px; /* Altura generosa */
        scroll-snap-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        
        /* Estado inactivo por defecto */
        opacity: 0.15;
        transform: scale(0.8);
        filter: blur(2px);
    }

    /* ESTADO ACTIVO (El elegido) */
    .stream-item.active {
        opacity: 1;
        transform: scale(1.1);
        filter: blur(0);
        z-index: 10;
        text-shadow: 0 0 20px rgba(109, 172, 214, 0.3); /* Glow sutil */
    }

    /* Contenido del Item */
    .item-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
    }

    /* Enlace Principal (La Fecha) */
    .date-display {
        text-decoration: none;
        font-family: 'Segoe UI', system-ui, sans-serif; /* Fuente limpia */
        font-size: 2rem;
        font-weight: 200; /* Muy fino */
        color: #e0e0e0;
        letter-spacing: -1px;
        transition: color 0.3s;
        white-space: nowrap;
    }
    
    .stream-item.active .date-display { color: #fff; font-weight: 400; }
    
    /* Separador visual entre fechas */
    .date-separator { color: #6dacd6; font-size: 1.5rem; margin: 0 10px; opacity: 0.5; }

    /* ACCIONES (Botones flotantes) */
    .action-orbit {
        display: flex;
        gap: 1.5rem;
        margin-top: 0.5rem;
        opacity: 0;
        transform: translateY(10px);
        transition: all 0.3s ease 0.1s; /* Delay para aparecer después */
        pointer-events: none;
    }

    .stream-item.active .action-orbit {
        opacity: 1;
        transform: translateY(0);
        pointer-events: auto;
    }



    .btn-void:hover {
        background: #6dacd6;
        border-color: #6dacd6;
        color: #fff;
        box-shadow: 0 0 15px rgba(109, 172, 214, 0.4);
    }
    
    .btn-void.delete:hover {
        background: #d66d6d;
        border-color: #d66d6d;
        box-shadow: 0 0 15px rgba(214, 109, 109, 0.4);
    }

    /* LÍNEA GUÍA CENTRAL (Opcional, para referencia) */
    .center-guide {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 300px;
        height: 1px;
        background: linear-gradient(90deg, transparent, #6dacd6, transparent);
        opacity: 0.2;
        pointer-events: none;
        z-index: 0;
    }

        .btn-void-pdf,.btn-void, .btn-void-delete {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        color: #888;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
        cursor: pointer;
        backdrop-filter: blur(5px);
    }

    .btn-void-pdf:hover {
        background: #76d66d;
        border-color: #89d66d;
        color: #fff;
        box-shadow: 0 0 15px rgba(109, 172, 214, 0.4);
    }
    
    /* ESTADO VACÍO (Void State) */
    .void-state {
        text-align: center;
        color: #333;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1rem;
        padding-top: 2rem;
    }
    .void-icon { font-size: 4rem; opacity: 0.2; animation: float 3s ease-in-out infinite; }
    
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
</style>

<div class="void-container">
    
    @if($meses->isEmpty())
        <div class="void-state">
                <i class="fa-brands fa-space-awesome void-icon" style="color: #ffffff; opacity: 1;"></i>                <h3 style="color: #eeeeee; font-weight: 300;">Espacio Vacío</h3>
                <p style="color: #bebebe; font-size: 0.9rem;">No se han detectado periodos temporales.</p>
            </div>
        </div>
    @else
        <div class="void-header">
            <h2>Seleccionar Periodo</h2>
        </div>

        <div class="center-guide"></div>

        <div class="stream-wrapper" id="voidStream">
            <div class="stream-padding"></div>
            
            @foreach ($meses as $mes)
            <div class="stream-item">
                <div class="item-content">
                    
                    <a href="/servicios/{{$mes->id_mes}}" class="date-display">
                        {{ \Carbon\Carbon::parse($mes->fecha_I)->format('M d') }}
                        <span class="date-separator">/</span>
                        {{ \Carbon\Carbon::parse($mes->fecha_f)->format('M d') }}
                        <div style="font-size: 0.7rem; color: #555; letter-spacing: 2px; text-align: center; margin-top: -5px; text-transform: uppercase;">
                            {{ \Carbon\Carbon::parse($mes->fecha_I)->format('Y') }}
                        </div>
                    </a>

                    <div class="action-orbit">
                        <a href="/edMes/{{$mes->id_mes}}" class="btn-void" title="Editar">
                            <i class="fa-solid fa-pen"></i>
                        </a>

                        <a href="/mesPDF/{{$mes->id_mes}}" class="btn-void-pdf" title="pdf">
                            <i class="fa-regular fa-file-pdf"></i>
                        </a>
                        
                        <form action="/delMes/{{$mes->id_mes}}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-void delete" 
                                    onclick="return confirm('¿Eliminar periodo?')">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </div>

                </div>
            </div>
            @endforeach
            
            <div class="stream-padding"></div>
        </div>
    @endif
</div>

@if(!$meses->isEmpty())
<script>
document.addEventListener('DOMContentLoaded', function() {
    const stream = document.getElementById('voidStream');
    if (!stream) return;

    const items = document.querySelectorAll('.stream-item');
    const itemHeight = 100; // Coincide con CSS .stream-item height
    let isScrolling;

    function updateFocus() {
        const centerPoint = stream.scrollTop + (stream.clientHeight / 2);
        
        items.forEach(item => {
            const itemCenter = item.offsetTop + (item.offsetHeight / 2);
            const distance = Math.abs(centerPoint - itemCenter);
            
            // Lógica de Activación basada en distancia
            if (distance < itemHeight / 2) {
                item.classList.add('active');
            } else {
                item.classList.remove('active');
            }
        });
    }

    // Scroll Handler
    stream.addEventListener('scroll', function() {
        window.requestAnimationFrame(updateFocus);
        
        // Snap Logic (Magnetismo)
        clearTimeout(isScrolling);
        isScrolling = setTimeout(function() {
            const scrollTop = stream.scrollTop;
            const nearestIndex = Math.round(scrollTop / itemHeight);
            
            stream.scrollTo({
                top: nearestIndex * itemHeight,
                behavior: 'smooth'
            });
        }, 80);
    });

    // Iniciar centrado (al final o principio)
    stream.scrollTop = stream.scrollHeight; 
    setTimeout(updateFocus, 100); // Pequeño delay para asegurar renderizado
});
</script>
@endif

@endsection