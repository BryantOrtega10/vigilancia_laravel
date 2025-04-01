@extends('adminlte::page')

@section('title', 'Matriz de riesgos')

@section('content_header')
    <h1>Matriz de riesgos</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('riesgos.tabla') }}">Riesgos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Exportar Matriz</li>
        </ol>
    </nav>
@stop

@section('content')
    <div class="card">
        <form action="{{ route('riesgos.matriz') }}" method="post">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label for="sede">Sede (*):</label>
                            <select id="sede" name="sede" class="form-control @error('sede') is-invalid @enderror">
                                @foreach ($sedes as $sede)
                                    <option value="{{ $sede->id }}" @if (old('sede') == $sede->id) selected @endif>
                                        {{ $sede->nombre }}</option>
                                @endforeach
                            </select>
                            @error('sede')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
               
            </div>
            <div class="text-right card-footer">
                <input type="submit" class="btn btn-flat btn-lg btn-primary" value="Exportar Matriz" />
            </div>
        </form>
        
    </div>
@stop
