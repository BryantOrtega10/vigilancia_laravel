@extends('adminlte::page')

@section('title', 'Agregar Usuario')

@section('content_header')
    <h1>Agregar Usuario</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('usuarios.tabla') }}">Usuarios</a></li>
            <li class="breadcrumb-item active" aria-current="page">Agregar</li>
        </ol>
    </nav>
@stop

@section('content')
    <div class="card">
        <form action="{{ route('usuarios.agregar') }}" method="post">
            @csrf
            <div class="card-body">
                <div class="row">
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
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label for="email">Email (*):</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email:" value="{{ old('email') }}">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label for="password">Contraseña (*):</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Contraseña:" value="{{ old('password') }}">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label for="repetir_password">Repetir contraseña (*):</label>
                            <input type="password" class="form-control @error('repetir_password') is-invalid @enderror" id="repetir_password" name="repetir_password" placeholder="Repetir contraseña:" value="{{ old('repetir_password') }}">
                            @error('repetir_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-8"> 
                        <h5>Asignar Propiedades</h5>
                    </div>
                    <div class="col-md-9 col-4"> 
                        <button class="btn btn-secondary agregar-propiedad" type="button"><i class="fas fa-plus"></i></button>
                    </div>                    
                </div>
                <div class="propiedad-cont">
                    @for ($i = 0; $i < sizeof(old('propiedad',[])); $i++)
                        <div class="row align-items-center propiedad-unidad">
                            <div class="col-md-3 col-11">
                                <div class="form-group">
                                    <label for="propiedad_{{$i}}">Propiedad:</label>
                                    <select class="form-control" id="propiedad_{{$i}}" name="propiedad[]">
                                        <option value=""></option>
                                        @foreach ($sedes as $sede)
                                            <option value="{{$sede->id}}" @if (old('propiedad.'.$i) == $sede->id) selected @endif>{{$sede->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-1">
                                <span class="quitar-propiedad"><i class="fas fa-trash"></i></span>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
            <div class="text-right card-footer">
                <input type="submit" class="btn btn-flat btn-lg btn-primary" value="Agregar" />
            </div>
            <input type="hidden" value='@foreach ($sedes as $sede) <option value="{{$sede->id}}">{{$sede->nombre}}</option>@endforeach' id="opciones_txt" />
        </form>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function(e){
            $("body").on("click",".agregar-propiedad", (e) => {
                

                $(".propiedad-cont").append(`
                    <div class="row align-items-center propiedad-unidad">
                        <div class="col-md-3 col-11">
                            <div class="form-group">
                                <label for="propiedad_${$(".propiedad-unidad").length}">Propiedad:</label>
                                <select class="form-control" id="propiedad${$(".propiedad-unidad").length}" name="propiedad[]">
                                    <option value=""></option>
                                    ${$("#opciones_txt").val()}
                                </select>
                            </div>
                        </div>
                        <div class="col-1">
                            <span class="quitar-propiedad"><i class="fas fa-trash"></i></span>
                        </div>
                    </div>
                `);
            })

            $("body").on("click",".quitar-propiedad", function(e) {
                $(e.target).closest(".propiedad-unidad").remove();
            });
        })
    </script>
@stop