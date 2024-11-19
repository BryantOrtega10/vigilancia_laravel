@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)

@section('title', 'Rondas')

@section('content_header')
    <div class="row">
        <div class="col-md-9">
            <h1>Rondas</h1>
        </div>
        <div class="text-right col-md-3">
            <a href="{{ route('rondas.agregar') }}" class="btn btn-outline-primary btn-flat"><i class="fas fa-plus"></i> Crear Ronda</a>
        </div>
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('rondas.tablaRecorridos') }}">Recorridos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Rondas</li>
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
    <div class="card">
        <div class="card-body">
            <table class="table table-striped datatable">
                <thead>
                    <tr>
                        <th>Sede</th>
                        <th>Nombre</th>
                        <th>Código Qr</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rondas as $ronda)
                        <tr>
                            <td>{{ $ronda->sede->nombre }}</td>
                            <td>{{ $ronda->nombre }}</td>
                            <td><img src="data:image/png;base64,{{ $ronda->img_qr }}" alt="QR Code" class="codigoQR_Preview"></td>
                            <td class="text-right">
                                <a href="{{ route('rondas.descargar',['idRonda' => $ronda->id])}}" class="btn btn-outline-success"><i class="fas fa-download"></i> Descargar</a>
                                <a href="{{ route('rondas.modificar',['idRonda' => $ronda->id])}}" class="btn btn-secondary"><i class="fas fa-pen"></i> Modificar</a>
                                <a href="{{ route('rondas.eliminar',['idRonda' => $ronda->id])}}" class="btn btn-danger preguntar" data-mensaje="Eliminar la ronda"><i class="fas fa-trash"></i> Eliminar</a>                                
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
