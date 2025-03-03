<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Minuta - {{$paquete->id}}</title>
</head>
<body>
    <style>
        *{
            font-family: sans-serif;
        }
        @page{
            margin: 0;
            padding: 0;
        }
        .row{
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }
        .col-md-3{
            width: 24%;
            display: inline-block;
        }
        .imagen-cont{
            width: 90%;
        }
        .w-100{
            width: 100%;
        }
        .centrar{
            padding: 40px 40px;
        }
    </style>
    <div class="centrar">
        <h5>Datos recepción</h5>
        <div class="row">
            <div class="col-md-3 col-12">
                <b>Fecha</b><br>
                <span>{{ date("Y/m/d", strtotime($paquete->fecha_recepcion)) }}</span>
            </div>
            <div class="col-md-3 col-12">
                <b>Hora</b><br>
                <span>{{ date("H:i", strtotime($paquete->fecha_recepcion)) }}</span>
            </div>
            <div class="col-md-3 col-12">
                <b>Propiedad</b><br>
                <span>{{ $paquete->propiedad->nombre }}</span>
            </div>
            <div class="col-md-3 col-12">
                <b>Recibe</b><br>
                <span>{{ $paquete->user_recibe->name }}</span>
            </div>
        </div>
        <h5>Datos entrega</h5>
        <div class="row">
            @if (!isset($paquete->fecha_entrega) || $paquete->fecha_entrega == null)
                <div class="col-md-12 col-12">
                    <b>Aun no se ha entregado</b><br>
                </div>
            @else
                <div class="col-md-3 col-12">
                    <b>Fecha</b><br>
                    <span>{{ date("Y/m/d", strtotime($paquete->fecha_recepcion)) }}</span>
                </div>
                <div class="col-md-3 col-12">
                    <b>Hora</b><br>
                    <span>{{ date("H:i", strtotime($paquete->fecha_recepcion)) }}</span>
                </div>
                <div class="col-md-3 col-12">
                    <b>Propietario</b><br>
                    <span>{{ $paquete->propiedad->propietario->nombres }} {{ $paquete->propiedad->propietario->apellidos }}</span>
                </div>
                <div class="col-md-3 col-12">
                    <b>Entrega</b><br>
                    <span>{{ $paquete->user_entrega->name }}</span>
                </div>
            @endif
            <div class="col-12">
                <b>Observacion</b><br>
                <span>{{ $paquete->observacion }}</span>
            </div>
            <div class="col-12">
                <b>Imagenes</b><br>
                    @foreach ($fotos as $foto)
                        <figure class="imagen-cont">
                            <img src="data:image/png;base64,{{$foto->img_base64}}" style="max-width: 100%; max-height: 100%;"  />
                        </figure>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</body>
</html>

