@extends('layouts.plantilla')

@section('tittle')
    Agregar mes para {{ $empresa->nombre}}
@endsection

@section('titular')
    <x-navbar-3 :empresa="$empresa">
        Agregar mes
    </x-navbar-3>
@endsection

@section('contenido')
<div class="container py-4">
  <div class="form-card-minimal p-4 mx-auto" style="max-width: 450px; background-color: #1a1c20; border: 1px solid #2d3035; border-radius: 16px;">
    
    <div class="text-center mb-4">
        <h5 class="text-light">Nuevo Periodo</h5>
        <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25">{{ $empresa->nombre }}</span>
    </div>

    <form action="/addMes/{{$empresa->id_empresa}}" method="POST" enctype="multipart/form-data">
    @csrf

      <div class="row g-3 mb-4">
          <div class="col-6">
            <label for="fecha_I" class="form-label-dark small">Desde</label>
            <input type="date" name="fecha_I" id="fechaInicio" class="form-control input-dark" id="fechaInicio"
                   style="background-color: #0f1012; border: 1px solid #2d3035; color: #a0a0a0; color-scheme: dark;">
          </div>

          <div class="col-6">
                <label for="fecha_f" class="form-label-dark small">Hasta</label>
                <input type="date" name="fecha_f" id="fechaCorte" class="form-control input-dark" id="fechaCorte"
                       style="background-color: #0f1012; border: 1px solid #2d3035; color: #a0a0a0; color-scheme: dark;">
          </div>
      </div>

      <button type="submit" class="btn w-100" style="background-color: #1c2a35; color: #6dacd6; border: 1px solid #243b4a;">
          <i class="fa-solid fa-calendar-plus me-2"></i> Crear Periodo
      </button>
    </form>
  </div>
</div>

<script>
  $('#fecha_I').on('change', function() {
      let inicio = new Date($(this).val() + "T00:00:00");
      if (!isNaN(inicio.getTime())) {
          let fin = new Date(inicio);
          
          // Sumamos un mes completo
          fin.setMonth(fin.getMonth() + 1);
          // Restamos un día para que NO se empalme con el inicio del próximo mes
          fin.setDate(fin.getDate() - 1);
          
          let fechaFinStr = fin.toISOString().split('T')[0];
          $('#fecha_f').val(fechaFinStr);
      }
  });
</script>
@endSection