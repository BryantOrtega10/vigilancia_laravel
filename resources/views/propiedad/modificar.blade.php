@extends('adminlte::page')

@section('title', 'Modificar Propiedad')

@section('content_header')
    <h1>Modificar Propiedad</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('propiedad.tabla') }}">Propiedades</a></li>
            <li class="breadcrumb-item active" aria-current="page">Modificar</li>
        </ol>
    </nav>
@stop

@section('content')
    <div class="card">
        <form action="{{ route('propiedad.modificar',['id' => $sede->id]) }}" method="post">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label for="tipo_propiedad">Tipo de propiedad (*):</label>
                            <select id="tipo_propiedad" name="tipo_propiedad" class="form-control @error('tipo_propiedad') is-invalid @enderror">
                                <option value="">Selecciona una</option>
                                @foreach ($tipos_propiedad as $tipo_propiedad)
                                    <option value="{{ $tipo_propiedad->id }}" @if (old('tipo_propiedad',$sede->fk_tipo_sede) == $tipo_propiedad->id) selected @endif>{{ $tipo_propiedad->nombre }}</option>
                                @endforeach
                            </select>
                            @error('tipo_propiedad')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label for="nombre">Nombre de la propiedad (*):</label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" placeholder="Nombre:" value="{{ old('nombre',$sede->nombre) }}">
                            @error('nombre')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label for="direccion">Dirección:</label>
                            <input type="text" class="form-control @error('direccion') is-invalid @enderror" id="direccion" name="direccion" placeholder="Dirección:" value="{{ old('direccion',$sede->direccion) }}">
                            @error('direccion')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label for="telefono">Teléfono:</label>
                            <input type="number" class="form-control @error('telefono') is-invalid @enderror" id="telefono" name="telefono" placeholder="Teléfono:" value="{{ old('telefono',$sede->telefono) }}">
                            @error('telefono')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label for="contacto">Contacto:</label>
                            <input type="text" class="form-control @error('contacto') is-invalid @enderror" id="contacto" name="contacto" placeholder="Contacto:" value="{{ old('contacto',$sede->contacto) }}">
                            @error('contacto')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label for="correo">Correo:</label>
                            <input type="email" class="form-control @error('correo') is-invalid @enderror" id="correo" name="correo" placeholder="Correo:" value="{{ old('correo',$sede->correo) }}">
                            @error('correo')
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
