@extends('adminlte::page')

@section('title', 'Modificar Propiedad')

@section('content_header')
    <h1>Modificar Propiedad</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('propiedad.tabla') }}">Propiedades</a></li>
            <li class="breadcrumb-item"><a href="{{ route('propiedad.tabla') }}">Administrar Propiedades de
                    {{ $sede->nombre }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">Modificar Propiedad</li>
        </ol>
    </nav>
@stop

@section('content')
    <div class="card">
        <form action="{{ route('propiedad.grupo.item.modificar', ['id' => $propiedad->id]) }}" method="post">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label for="nombre">Nombre Propiedad (*):</label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre"
                                name="nombre" placeholder="Nombre:" value="{{ old('nombre', $propiedad->nombre) }}">
                            @error('nombre')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <h5>Datos del propietario</h5>
                <div class="row">
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label for="nombres">Nombres:</label>
                            <input type="text" class="form-control @error('nombres') is-invalid @enderror" id="nombres"
                                name="nombres" placeholder="Nombre:"
                                value="{{ old('nombres', isset($propietario) ? $propietario->nombres : '') }}">
                            @error('nombres')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label for="apellidos">Apellidos:</label>
                            <input type="text" class="form-control @error('apellidos') is-invalid @enderror"
                                id="apellidos" name="apellidos" placeholder="Apellidos:"
                                value="{{ old('apellidos', isset($propietario) ? $propietario->apellidos : '') }}">
                            @error('apellidos')
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
                            <label for="celular_p">Celular Principal:</label>
                            <input type="number" class="form-control @error('celular_p') is-invalid @enderror"
                                id="celular_p" name="celular_p" placeholder="Celular principal:"
                                value="{{ old('celular_p', isset($propietario) ? $propietario->celular_p : '') }}">
                            @error('celular_p')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label for="celular_s">Celular secundario:</label>
                            <input type="number" class="form-control @error('celular_s') is-invalid @enderror"
                                id="celular_s" name="celular_s" placeholder="Celular secundario:"
                                value="{{ old('celular_s', isset($propietario) ? $propietario->celular_s : '') }}">
                            @error('celular_s')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" placeholder="Email:"
                                value="{{ old('email', isset($propietario) ? $propietario->email : '') }}">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2 col-8">
                        <h5>Vehiculos</h5>
                    </div>
                    <div class="col-md-10 col-4">
                        <button class="btn btn-secondary agregar-vehiculo" type="button"><i
                                class="fas fa-plus"></i></button>
                    </div>
                </div>
                <div class="vehiculos-cont">
                    @foreach ($vehiculos as $i => $vehiculo)
                        <div class="row align-items-center vehiculo-unidad">
                            <div class="col-md-3 col-5">
                                <div class="form-group">
                                    <label for="tipo_vehiculo_{{ $i }}">Tipo vehículo:</label>
                                    <select class="form-control" id="tipo_vehiculo_{{ $i }}"
                                        name="tipo_vehiculo[]">
                                        <option value="1" @if (old('tipo_vehiculo.' . $i,$vehiculo->fk_tipo_vehiculo) == '1') selected @endif>Carro
                                        </option>
                                        <option value="2" @if (old('tipo_vehiculo.' . $i,$vehiculo->fk_tipo_vehiculo) == '2') selected @endif>Moto
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="form-group">
                                    <label for="vehiculo_{{ $i }}">Vehículo:</label>
                                    <input type="text" class="form-control" id="vehiculo_{{ $i }}"
                                        name="vehiculo[]" placeholder="Vehículo:" value="{{ old('vehiculo.' . $i,$vehiculo->placa) }}">
                                </div>
                            </div>
                            <div class="col-1">
                                <span class="quitar-vehiculo"><i class="fas fa-trash"></i></span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="text-right card-footer">
                <input type="submit" class="btn btn-flat btn-lg btn-primary" value="Modificar" />
            </div>
        </form>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function(e) {
            $("body").on("click", ".agregar-vehiculo", (e) => {
                $(".vehiculos-cont").append(`
                    <div class="row align-items-center vehiculo-unidad">
                        <div class="col-md-3 col-5">
                            <div class="form-group">
                                <label for="tipo_vehiculo_${$(".vehiculo-unidad").length}">Tipo vehículo:</label>
                                <select class="form-control" id="tipo_vehiculo_${$(".vehiculo-unidad").length}" name="tipo_vehiculo[]">
                                    <option value="1">Carro</option>
                                    <option value="2">Moto</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="form-group">
                                <label for="vehiculo_${$(".vehiculo-unidad").length}">Vehículo:</label>
                                <input type="text" class="form-control" id="vehiculo_${$(".vehiculo-unidad").length}" name="vehiculo[]" placeholder="Vehículo:" >
                            </div>
                        </div>
                        <div class="col-1">
                            <span class="quitar-vehiculo"><i class="fas fa-trash"></i></span>
                        </div>
                    </div>
                `);
            })

            $("body").on("click", ".quitar-vehiculo", function(e) {
                $(e.target).closest(".vehiculo-unidad").remove();
            });
        })
    </script>
@stop
