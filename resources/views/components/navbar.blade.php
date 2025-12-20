<div class="d-flex justify-content-center flex-column py-4">
  <nav class="navbar w-100 p-0 mb-3">
    <div class="container-fluid justify-content-center">
      
      <form class="row w-100 justify-content-center gx-2" role="search">
        
        <div class="col-12 col-md-6 mb-2 mb-md-0">
          <input class="form-control input-dark-minimal" type="search" placeholder="Empresa" aria-label="Search">
        </div>
        
        <div class="col-6 col-md-1">
          <button class="btn btn-dark-minimal w-100" type="submit">
            <i class="fa-solid fa-magnifying-glass"></i>
          </button>
        </div>

        <div class="col-6 col-md-1">
            @if (isset($empresa) && $slot == 'Meses' && $empresa->id_empresa)
                <a href="{{ url('ag_Meses/' . $empresa->id_empresa) }}" class="btn btn-dark-minimal w-100">
                    <i class="fa-solid fa-plus"></i>
                </a>  
            @elseif (isset($id_mes) && $slot == 'Servicios')
                <a href="{{ url('ag_Servicios/' . $id_mes) }}" class="btn btn-dark-minimal w-100">
                    <i class="fa-solid fa-plus"></i>
                </a>
            @else
                <a href="{{ url('ag_' . $slot) }}" class="btn btn-dark-minimal w-100">
                    <i class="fa-solid fa-plus"></i>
                </a>
            @endif
        </div>
      </form>
    </div>
  </nav>

  <div class="row">
    <div class="d-flex justify-content-center gap-4 align-items-center">
      
      <a href="{{ url('tecnicos') }}"
         class="nav-link-minimal {{ $slot == 'Tecnicos' ? 'nav-link-active' : 'nav-link-muted' }}">
        Técnicos
      </a>

      <a href="{{ url('/') }}"
         class="nav-link-minimal {{ $slot == 'Empresas' ? 'nav-link-active' : 'nav-link-muted' }}">
        Empresas
      </a>

      <a href="{{ url('productos') }}"
         class="nav-link-minimal {{ $slot == 'Productos' ? 'nav-link-active' : 'nav-link-muted' }}">
        Productos
      </a>

    </div>
  </div>

  <hr style="border-color: #2d3035; width: 90%; opacity: 0.5;" class="mx-auto mt-4">
</div>