@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)

@section('title', 'Usuarios')

@section('content_header')
    <div class="row">
        <div class="col-md-9">
            <h1>Usuarios</h1>
        </div>
        <div class="text-right col-md-3">
            <a href="{{ route('usuarios.agregar') }}" class="btn btn-outline-primary btn-flat"><i class="fas fa-plus"></i> Crear Usuario</a>
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
                        <th>Propiedades</th>
                        <th>Email</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->name }}</td>
                            <td>{{ $usuario->sedes_txt() }}</td>
                            <td>{{ $usuario->email }}</td>
                            <td class="text-right">
                                <a href="{{ route('usuarios.modificar',['id' => $usuario->id])}}" class="btn btn-secondary"><i class="fas fa-pen"></i> Modificar</a>
                                <a href="{{ route('usuarios.eliminar',['id' => $usuario->id])}}" class="btn btn-danger preguntar" data-mensaje="Eliminar el usuario"><i class="fas fa-trash"></i> Eliminar</a>
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
