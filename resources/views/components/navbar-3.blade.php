<div class="d-flex justify-content-center flex-column py-4">
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