@extends('layouts.plantilla')

@section('tittle', 'Tecnicos')
@section('titular')
<x-navbar>
        Tecnicos
</x-navbar>
@endSection

@section('contenido')
  <div class="row justify-content-center">
  <div class="col-md-5">
    <table class="table table-hover">
      <thead class="table-dark">
        <tr>
          <th class="text-center">Clave</th>
          <th class="text-center">Nombre</th>          
          <th class="text-center">Acciones</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($tecnicos as $tec)
        <tr>
          <td class="text-center">{{ $tec->id_tec }}</td>
          <td class="text-center">{{ $tec->nombre }}</td>          
          <td class="d-flex justify-content-center gap-2">
            <!-- Aquí puedes agregar botones para editar o eliminar -->
            <a href="edTecnicos/{{$tec->id_tec}}" class="btn btn-sm btn-primary">Editar</a>
            <a href="#" class="btn btn-sm btn-danger">Eliminar</a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
    
@endsection