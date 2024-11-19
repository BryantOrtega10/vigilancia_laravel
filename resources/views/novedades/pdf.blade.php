<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Novedad vehiculo - {{$novedad->id}}</title>
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
        .col-12{
            width: 100%;
        }
        .w-100{
            max-width: 100%;
        }
        .centrar{
            padding: 40px 40px;
        }
    </style>
    <div class="centrar">
        <div class="row">
            <div class="col-md-3">
                <b>Fecha</b><br>
                <span>{{ date("Y/m/d", strtotime($novedad->fecha_hora)) }}</span>
            </div>
            <div class="col-md-3">
                <b>Hora</b><br>
                <span>{{ date("H:i", strtotime($novedad->fecha_hora)) }}</span>
            </div>
            <div class="col-md-3">
                <b>Propiedad</b><br>
                <span>{{ $novedad->sede_txt() }}</span>
            </div>
            <div class="col-md-3">
                <b>Responsable</b><br>
                <span>{{ $novedad->user->name }}</span>
            </div>
            <div class="col-12">
                <b>Observacion</b><br>
                <span>{{ $novedad->observacion }}</span>
            </div>
            <div class="col-12">
                <b>Imagenes</b><br>
                <div class="row">
                    @foreach ($fotos as $foto)
                        <figure class="col-md-4 col-12">
                            <img src="data:image/png;base64,{{$foto->img_base64}}" class="w-100" />
                        </figure>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</body>
</html>

