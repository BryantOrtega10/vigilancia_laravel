@extends('adminlte::page')

@section('title', 'Ver detalles del riesgo')

@section('content_header')
    <h1>Ver detalles del riesgo</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('riesgos.tabla') }}">Riesgos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Ver detalles</li>
        </ol>
    </nav>
@stop

@section('content')
    <div class="card">
        <form action="{{ route('riesgos.actualizar', ['id' => $riesgo->id]) }}" method="post">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label for="probabilidad">Probabilidad (*):</label>
                            <select id="probabilidad" name="probabilidad"
                                class="form-control @error('probabilidad') is-invalid @enderror">
                                @foreach (range(1, 10) as $probabilidad)
                                    <option value="{{ $probabilidad }}" @if (old('probabilidad', $riesgo->probabilidad) == $probabilidad) selected @endif>
                                        {{ $probabilidad }}</option>
                                @endforeach
                            </select>
                            @error('probabilidad')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label for="impacto">Impacto (*):</label>
                            <select id="impacto" name="impacto"
                                class="form-control @error('impacto') is-invalid @enderror">
                                @foreach (['No configurado', 'Bajo', 'Medio', 'Alto'] as $row => $impacto)
                                    <option value="{{ $row }}" @if (old('impacto', $riesgo->impacto) == $row) selected @endif>
                                        {{ $impacto }} </option>
                                @endforeach
                            </select>
                            @error('impacto')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label for="estado">Estado (*):</label>
                            <select id="estado" name="estado"
                                class="form-control @error('estado') is-invalid @enderror">
                                @foreach (['Inactivo', 'Activo'] as $row => $estado)
                                    <option value="{{ $row }}" @if (old('estado', $riesgo->estado) == $row) selected @endif>
                                        {{ $estado }}</option>
                                @endforeach
                            </select>
                            @error('estado')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-12">
                        <div class="form-group">
                            <label for="descripcion">Nueva observación:</label>
                            <textarea id="descripcion" name="descripcion" class="form-control @error('descripcion') is-invalid @enderror"
                                rows="6">{{ $riesgo->descripcion }}</textarea>
                            @error('descripcion')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="text-right card-footer">
                    <input type="submit" class="btn btn-flat btn-lg btn-primary" value="Actualizar" />
                </div>
            </div>
        </form>
    </div>

    <h5>Últimas actualizaciones</h5>


    @foreach ($logs as $log)
        <div class="card">
            <div class="card-body">
                <div class="log-item">
                    <div class="row">
                        <div class="col-md-3 col-12">
                            <b>Probabilidad: </b> <br>
                            <span>{{ $log->probabilidad }}</span>
                        </div>
                        <div class="col-md-3 col-12">
                            <b>Impacto: </b> <br>
                            <span>{{ $log->txtImpacto }}</span>
                        </div>
                        <div class="col-md-3 col-12">
                            <b>Estado: </b> <br>
                            <span>{{ $log->txtEstado }}</span>
                        </div>
                        <div class="col-md-3 col-12">
                            <b>Usuario: </b> <br>
                            <span>{{ $log->user->name }}</span>
                        </div>
                        <div class="col-md-3 col-12">
                            <b>Fecha Actualización: </b> <br>
                            <span>{{ date("Y-m-d H:i", strtotime($log->created_at)) }}</span>
                        </div>
                    </div>
                    @if ($log->descripcion != '')
                        <div class="row">
                            <div class="col-md-12 col-12">
                                <b>Descripción: </b> <br>
                                <span>{{ $log->descripcion }}</span>
                            </div>
                        </div>
                    @endif
                    @if (sizeof($log->fotos) > 0)
                        <div class="row">
                            @foreach ($log->fotos as $foto)
                                <div class="col-md-3 col-12">
                                    <figure class="img-riesgo" data-src="{{ Storage::url('riesgos/max_' . $foto->ruta) }}">
                                        <img src="{{ Storage::url('riesgos/min_' . $foto->ruta) }}" class="w-100" />
                                    </figure>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endforeach

    <div class="modal fade" id="verFotoGrande" tabindex="-1" aria-labelledby="verFotoGrande" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Foto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img src="" id="foto-max" class="w-100"/>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $("body").on("click", ".img-riesgo", function(e) {
                
                $("#foto-max").prop("src", $(this).data("src"));
                $("#verFotoGrande").modal("show");
            });
        })
    </script>
@stop
