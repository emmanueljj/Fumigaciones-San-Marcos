@extends('layouts.plantilla')

@section('tittle')
    Meses {{ $empresa->nombre }}
@endsection

@section('titular')
<x-navbar :empresa="$empresa">
    Meses
</x-navbar>

@endsection

@section('contenido')
<div class="row">
    <ul class="list-group col-md-6 d-flex justify-content-center mx-auto my-4">
    @foreach ($meses as $mes)
                <a href="#" class="list-group-item list-group-item-action d-flex justify-content-center mx-auto">{{ $mes->fecha_I.' - '.$mes->fecha_f}}</a>    
    @endforeach
</ul>
</div>
@endsection




