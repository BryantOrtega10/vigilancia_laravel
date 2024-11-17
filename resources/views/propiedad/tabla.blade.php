@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)

@section('title', 'Propiedades')

@section('content_header')
    <div class="row">
        <div class="col-md-9">
            <h1>Propiedades</h1>
        </div>
        <div class="text-right col-md-3">
            <a href="{{ route('propiedad.agregar') }}" class="btn btn-outline-primary btn-flat"><i class="fas fa-plus"></i> Crear Propiedad</a>
        </div>
    </div>
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
    <div class="card">
        <div class="card-body">
            <table class="table table-striped datatable">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Tipo Propiedad</th>
                        <th>Contacto</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sedes as $sede)
                        <tr>
                            <td>{{ $sede->nombre }}</td>
                            <td>{{ $sede->tipo_sede->nombre }}</td>
                            <td>{{ $sede->contacto }}</td>
                            <td class="text-right">
                                <a href="{{ route('propiedad.config',['id' => $sede->id])}}" class="btn btn-outline-secondary"><i class="fas fa-cogs"></i> Config</a>
                                <a href="{{ route('propiedad.modificar',['id' => $sede->id])}}" class="btn btn-secondary"><i class="fas fa-pen"></i> Modificar</a>
                                <a href="{{ route('propiedad.eliminar',['id' => $sede->id])}}" class="btn btn-danger preguntar" data-mensaje="Eliminar la sede"><i class="fas fa-trash"></i> Eliminar</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('js')

@stop
