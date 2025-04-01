@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)

@section('title', 'Riesgos')

@section('content_header')
    <div class="row">
        <div class="col-md-8">
            <h1>Riesgos</h1>
        </div>
        <div class="col-md-4 text-right">
            <a href="{{ route('riesgos.matriz') }}" class="btn btn-outline-primary btn-flat"><i class="fas fa-download"></i>Exportar Matriz</a>
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
                        <th>ID</th>
                        <th>Sede</th>
                        <th>Ultima actualización</th>
                        <th>Probabilidad</th>
                        <th>Impacto</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($riesgos as $riesgo)
                        <tr>
                            <td>{{ $riesgo->id }}</td>
                            <td>{{ $riesgo->sede->nombre }}</td>
                            <td>{{ date("Y/m/d H:i", strtotime($riesgo->updated_at)) }}</td>
                            <td>{{ $riesgo->probabilidad }}</td>
                            <td>{{ $riesgo->txtImpacto }}</td>
                            <td>{{ $riesgo->txtEstado }}</td>
                            <td class="text-right">
                                <a href="{{ route('riesgos.verDetalles',['id' => $riesgo->id])}}" class="btn btn-outline-success"><i class="fas fa-eye"></i> Ver</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@stop

