@extends('adminlte::page')

@section('title', 'Validar código')

@section('content_header')
    <h1>Validar código de entrega</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('paquetes.tabla') }}">Buzón</a></li>
            <li class="breadcrumb-item active" aria-current="page">Validar código de entrega</li>
        </ol>
    </nav>
@stop

@section('content')
    <div class="card">
        <form action="{{ route('paquetes.validar',['id' => $paquete->id]) }}" method="post">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label for="fecha_entrega">Fecha de entrega (*):</label>
                            <input type="date" class="form-control @error('fecha_entrega') is-invalid @enderror" id="fecha_entrega" name="fecha_entrega" value="{{ old('fecha_entrega') }}">
                            @error('fecha_entrega')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label for="hora_entrega">Hora de entrega (*):</label>
                            <input type="time" class="form-control @error('hora_entrega') is-invalid @enderror" id="hora_entrega" name="hora_entrega" value="{{ old('hora_entrega') }}">
                            @error('hora_entrega')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label for="codigo">Código de entrega (*):</label>
                            <input type="text" class="form-control @error('codigo') is-invalid @enderror" id="codigo" name="codigo" value="{{ old('codigo') }}">
                            @error('codigo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-right card-footer">
                <input type="submit" class="btn btn-flat btn-lg btn-primary" value="Validar entrega" />
            </div>
        </form>
    </div>
@stop
