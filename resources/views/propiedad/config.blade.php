@extends('adminlte::page')
@section('plugins.Sweetalert2', true)
@section('title', 'Administrar Propiedades')

@section('content_header')
<div class="row">
    <div class="col-md-9">
        <h1>Administrar Propiedades de {{$sede->nombre}}</h1>
    </div>
    <div class="text-right col-md-3">
        <a href="{{ route('propiedad.grupo.agregar',['id' => $sede->id]) }}" class="btn btn-outline-primary btn-flat"><i class="fas fa-plus"></i> Crear Grupo de Propiedades</a>
    </div>
</div>
    
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('propiedad.tabla') }}">Propiedades</a></li>
            <li class="breadcrumb-item active" aria-current="page">Administrar Propiedades de {{$sede->nombre}}</li>
        </ol>
    </nav>
@stop

@section('content')
    @if (session('mensaje'))
        <div class="alert alert-success">
            {{ session('mensaje') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    @foreach ($grupos as $grupo)
    <div class="card">
        <div class="card-header">
            <div class="row">
                
                <div class="col-6">@isset($grupo->fk_tipo_gr_propiedad) {{$grupo->tipo_gr_propiedad->nombre}}: @endisset{{$grupo->nombre}}</div>
                <div class="col-6 text-right">
                    <a href="{{route('propiedad.grupo.item.agregar',['id' => $grupo->id])}}" class="btn btn-outline-secondary" type="button"><i class="fas fa-plus"></i> Nueva propiedad</a>
                    <a href="{{route('propiedad.grupo.modificar',['id' => $grupo->id])}}" class="btn btn-outline-secondary"><i class="fas fa-pen"></i></a>
                    <a href="{{route('propiedad.grupo.eliminar',['id' => $grupo->id])}}" class="btn btn-outline-danger preguntar" data-mensaje="Eliminar el grupo de propiedades"><i class="fas fa-trash"></i></a>
                </div>
            </div>
        </div>    
        <div class="card-body">
            <div class="row">
            @foreach ($grupo->propiedades as $propiedad)
                <div class="col-xl-2 col-lg-3 col-md-3 col-4">
                    <div class="sub-item"> 
                        <span>{{$propiedad->nombre}}</span>
                        <a href="{{route('propiedad.grupo.item.modificar', ['id' => $propiedad->id])}}" class="btn btn-secondary"><i class="fas fa-pen"></i></a>
                        <a href="{{route('propiedad.grupo.item.eliminar', ['id' => $propiedad->id])}}" class="btn btn-danger preguntar" data-mensaje="Eliminar la propiedad"><i class="fas fa-trash"></i></a>
                    </div>
                </div>
            @endforeach
            </div>
        </div>
    </div>
    @endforeach
   
@stop
