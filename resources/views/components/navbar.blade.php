<div class="d-flex justify-content-center flex-column">
  <nav class="navbar bg-light">
    <div class="container-fluid">
      
      <!-- Formulario de búsqueda -->
      <form class="row w-100 justify-content-center" role="search">
        <div class="col-6">
          <input class="form-control form-control-sm" type="search" placeholder="Empresa" aria-label="Search">
        </div>
        <div class="col-1">
          <button class="btn btn-outline-primary btn-sm w-100" type="submit">
            <i class="fa-solid fa-magnifying-glass"></i>
          </button>
        </div>

        <div class="col-1">
          @if ($empresa && $slot == 'Meses' && $empresa->id_empresa)
            <a href="{{ url('ag_Meses/' .$empresa->id_empresa) }}" class="btn btn-outline-secondary btn-sm w-100">
                <i class="fa-solid fa-plus"></i>
            </a>
        @else
            <a href="{{ url('ag_' . $slot) }}" class="btn btn-outline-secondary btn-sm w-100">
                <i class="fa-solid fa-plus"></i>
            </a>
        @endif





        </div>
      </form>
    </div>
  </nav>

  <!-- Enlaces centrados -->
  <div class="row">
    <div class="d-flex justify-content-center gap-3">
      <a href="{{ url('tecnicos') }}"
         class="text-decoration-none small {{ $slot == 'Tecnicos' ? 'text-primary' : 'text-secondary' }}">
        Técnicos
      </a>

      <a href="{{ url('/') }}"
         class="text-decoration-none small {{ $slot == 'Empresas' ? 'text-primary' : 'text-secondary' }}">
        Empresas
      </a>

      <a href="{{ url('productos') }}"
         class="text-decoration-none small {{ $slot == 'Productos' ? 'text-primary' : 'text-secondary' }}">
        Productos
      </a>
    </div>
  </div>

  <hr style="width: 90%;" class="mx-auto w-50">
</div>
