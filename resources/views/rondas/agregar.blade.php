@extends('adminlte::page')

@section('title', 'Crear Ronda')

@section('content_header')
    <h1>Crear Ronda</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('rondas.tablaRecorridos') }}">Recorridos</a></li>
            <li class="breadcrumb-item"><a href="{{ route('rondas.vistaQRs') }}">Rondas</a></li>
            <li class="breadcrumb-item active" aria-current="page">Crear Ronda</li>
        </ol>
    </nav>
@stop

@section('content')
    <div class="card">
        <form action="{{ route('rondas.agregar') }}" method="post">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label for="sede">Sede (*):</label>
                            <select id="sede" name="sede" class="form-control @error('sede') is-invalid @enderror">
                                <option value="">Selecciona una</option>
                                @foreach ($sedes as $sede)
                                    <option value="{{ $sede->id }}" @if (old('sede') == $sede->id) selected @endif>{{ $sede->nombre }}</option>
                                @endforeach
                            </select>
                            @error('sede')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label for="nombre">Nombre (*):</label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" placeholder="Nombre:" value="{{ old('nombre') }}">
                            @error('nombre')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-right card-footer">
                <input type="submit" class="btn btn-flat btn-lg btn-primary" value="Agregar" />
            </div>
        </form>
    </div>
@stop
