<div class="d-flex justify-content-center flex-column py-4" style="position: relative;">
  <nav class="navbar w-100 p-0 mb-3">
    <div class="container-fluid justify-content-center">
      <form class="row w-100 justify-content-center gx-2" role="search" onsubmit="return false;">
        <div class="col-12 col-md-6 mb-2 mb-md-0" style="position: relative;">
          {{-- Input con ID y data-tipo --}}
          <input id="inputBusquedaReal" 
                 class="form-control input-dark-minimal" 
                 type="search" 
                 placeholder="Buscar en {{ $slot }}..." 
                 data-tipo="{{ $slot }}" {{-- Esto nos dice si buscar en Empresas, Tecnicos, etc --}}
                 autocomplete="off">
          
          {{-- CONTENEDOR DE RESULTADOS (El div que pediste) --}}
          <div id="resultadosBusqueda" class="results-container shadow-lg d-none">
            {{-- Aquí se inyectarán las opciones dinámicamente --}}
          </div>
        </div>

        <div class="col-6 col-md-1">
            {{-- Tu lógica de botones + se mantiene igual --}}
            @if (isset($empresa) && $slot == 'Meses' && $empresa->id_empresa)
                <a href="{{ url('ag_Meses/' . $empresa->id_empresa) }}" class="btn btn-dark-minimal w-100"><i class="fa-solid fa-plus"></i></a>  
            @else
                <a href="{{ url('ag_' . $slot) }}" class="btn btn-dark-minimal w-100"><i class="fa-solid fa-plus"></i></a>
            @endif
        </div>
      </form>
    </div>
  </nav>

  {{-- Links de navegación --}}
  <div class="row">
    <div class="d-flex justify-content-center gap-4 align-items-center">
      <a href="{{ url('tecnicos') }}" class="nav-link-minimal {{ $slot == 'Tecnicos' ? 'nav-link-active' : 'nav-link-muted' }}">Técnicos</a>
      <a href="{{ url('/') }}" class="nav-link-minimal {{ $slot == 'Empresas' ? 'nav-link-active' : 'nav-link-muted' }}">Empresas</a>
      <a href="{{ url('productos') }}" class="nav-link-minimal {{ $slot == 'Productos' ? 'nav-link-active' : 'nav-link-muted' }}">Productos</a>
    </div>
  </div>
  <hr style="border-color: #2d3035; width: 90%; opacity: 0.5;" class="mx-auto mt-4">
</div>

<style>
    /* Estilo para el div de opciones (Efecto Cristal Dark) */
    .results-container {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        z-index: 1000;
        background: rgba(26, 28, 32, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid #2d3035;
        border-radius: 8px;
        max-height: 300px;
        overflow-y: auto;
        margin-top: 5px;
    }
    .result-item {
        padding: 12px 15px;
        color: #e0e0e0;
        cursor: pointer;
        border-bottom: 1px solid #2d3035;
        transition: background 0.2s;
        text-decoration: none;
        display: block;
    }
    .result-item:hover { background: rgba(109, 172, 214, 0.2); color: #6dacd6; }
    .result-item:last-child { border-bottom: none; }
</style>