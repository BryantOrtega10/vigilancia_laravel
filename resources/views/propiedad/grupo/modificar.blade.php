@extends('adminlte::page')

@section('title', 'Modificar Grupo')

@section('content_header')
    <h1>Modificar Grupo</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('propiedad.tabla') }}">Propiedades</a></li>
            <li class="breadcrumb-item"><a href="{{ route('propiedad.tabla') }}">Administrar Propiedades de {{$sede->nombre}}</a></li>
            <li class="breadcrumb-item active" aria-current="page">Modificar Grupo</li>
        </ol>
    </nav>
@stop

@section('content')
    <div class="card">
        <form action="{{ route('propiedad.grupo.modificar',['id' => $grupo->id]) }}" method="post">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label for="tipo_grupo">Tipo de grupo (*):</label>
                            <select id="tipo_grupo" name="tipo_grupo" class="form-control @error('tipo_grupo') is-invalid @enderror">
                                <option value="">Selecciona una</option>
                                @foreach ($tipos_grupo as $tipo_grupo)
                                    <option value="{{ $tipo_grupo->id }}" @if (old('tipo_grupo',$grupo->fk_tipo_gr_propiedad) == $tipo_grupo->id) selected @endif>{{ $tipo_grupo->nombre }}</option>
                                @endforeach
                            </select>
                            @error('tipo_grupo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label for="nombre">Nombre del grupo (*):</label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" placeholder="Nombre:" value="{{ old('nombre',$grupo->nombre) }}">
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
                <input type="submit" class="btn btn-flat btn-lg btn-primary" value="Modificar" />
            </div>
        </form>
    </div>
@stop
