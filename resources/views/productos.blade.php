@extends('layouts.plantilla')

@section('tittle','Productos')
@section('titular')
    <x-navbar>
            Productos
    </x-navbar>
@endSection

@section('contenido')
 <div class="row justify-content-center">
  <div class="col-md-7">
    <table class="table  table-hover">
      <thead class="table-dark">
        <tr>
            <th class="text-center">Nombre</th>          
            <th class="text-center">Concentracion</th>
            <th class="text-center">Metodo</th>
            <th class="text-center">Plaga</th>
            <th class="text-center">Acciones</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($productos as $producto)
        <tr>
          <td class="text-center">{{ $producto->nombre}}</td>
          <td class="text-center">{{ $producto->concentracion}}</td>
          <td class="text-center">{{ $producto->metodo}}</td>
          <td class="text-center">{{ $producto->plaga}}</td>
          <td class="d-flex justify-content-center gap-2">
            <!-- Aquí puedes agregar botones para editar o eliminar -->
            <a href="#" class="btn btn-sm btn-primary">Editar</a>
            <a href="#" class="btn btn-sm btn-danger">Eliminar</a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@endsection