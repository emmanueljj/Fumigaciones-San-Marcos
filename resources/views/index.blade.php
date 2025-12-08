@extends('layouts.plantilla')

@section('tittle', 'Inicio')

@section('titular')
<x-navbar>
    Empresas
</x-navbar>
@endSection

@section('contenido')

<div class="empresas">
    @foreach ($empresas as $empresa)
    <div class="card empresa-carta" style="width: 18rem;">
                <a href="/meses/{{$empresa->id_empresa}}">
            <img src="{{ asset('storage/' . $empresa->foto) }}" class="card-img-top">
            <div class="card-body">
                <h5 class="card-tittle">{{$empresa->nombre}}</h5>
                <p class="card-text">{{$empresa->encargado}}</p>
            </div>
        </a>
    </div>
    @endforeach

@endSection
