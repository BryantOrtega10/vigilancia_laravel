<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Entradas y salidas - {{ $visita->id }}</title>
</head>

<body>
    <style>
        * {
            font-family: sans-serif;
        }

        @page {
            margin: 0;
            padding: 0;
        }

        .row {
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }

        .col-md-3 {
            width: 24%;
            display: inline-block;
            vertical-align: top;
        }
        .col-6 {
            width: 45%;
            display: inline-block;
            vertical-align: top;
        }


        .imagen-cont {
            width: 90%;
        }

        .w-100 {
            width: 100%;
        }

        .centrar {
            padding: 40px 40px;
        }
    </style>
    <div class="centrar">
        <h3>Entradas y Salidas</h3>
        <div class="row">
            <div class="col-md-3 col-12">
                <b>Sede</b><br>
                <span>{{ $visita->propiedad->gr_propiedad->sede->nombre }}</span>
            </div>
            <div class="col-md-3 col-12">
                <b>Propiedad</b><br>
                <span>{{ $visita->propiedad->nombre }}</span>
            </div>
            <div class="col-md-3 col-12">
                <b>Responsable del ingreso</b><br>
                <span>{{ $visita->responsable }}</span>
            </div>
            <div class="col-md-3 col-12">
                <b>Vigilante entrada</b><br>
                <span>{{ $visita->user_entrada->name }}</span>
            </div>
            <div class="col-md-3 col-12">
                <b>Fecha de entrada</b><br>
                <span>{{ date('Y/m/d', strtotime($visita->fecha_entrada)) }}</span>
            </div>
            <div class="col-md-3 col-12">
                <b>Hora de entrada</b><br>
                <span>{{ date('H:i', strtotime($visita->fecha_entrada)) }}</span>
            </div>
        </div>
        <br>
        <h5>Datos del visitante</h5>
        <div class="row">
            <div class="col-md-3 col-12">
                <b>Nombre</b><br>
                <span>{{ $visita->nombre }}</span>
            </div>
            <div class="col-md-3 col-12">
                <b>Documento</b><br>
                <span>{{ $visita->documento }}</span>
            </div>
        </div>
        @if ($visita->placa != null)
            <br>
            <h5>Datos del vehiculo</h5>
            <div class="row">
                <div class="col-md-3 col-12">
                    <b>Tipo Vehículo</b><br>
                    <span>{{ $visita->tipo_vehiculo->nombre }}</span>
                </div>
                <div class="col-md-3 col-12">
                    <b>Placa</b><br>
                    <span>{{ $visita->placa }}</span>
                </div>
            </div>
        @endif
        <br>
        @if (sizeof($visita->fotos) > 0)
            <b>Imagenes</b><br>
            <div class="row">
                @foreach ($visita->fotos as $foto)
                    <figure class="imagen-cont">
                            <img src="data:image/png;base64,{{$foto->img_base64}}" style="max-width: 100%; max-height: 100%;"  />
                        </figure>
                @endforeach
            </div>
        @endif
        <div class="row">
            <div class="col-6">
                <b>Observaciones Entrada</b><br>
                <span>{{ $visita->observacion }}</span>
            </div>
            <div class="col-6">
                <b>Observaciones Salida</b><br>
                <span>{{ $visita->observacion_salida }}</span>
            </div>
            <div class="col-12">
                <b>¿Autorizo el tratamiento de datos?</b><br>
                <span>{{ $visita->manejo_datos ? 'SI' : 'NO' }}</span>
            </div>
        </div>
    </div>
</body>

</html>
