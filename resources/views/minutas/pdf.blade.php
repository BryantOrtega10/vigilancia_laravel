<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Minuta - {{$minuta->id}}</title>
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
        <div class="row">
            <div class="col-md-3">
                <b>Fecha</b><br>
                <span>{{ date("Y/m/d", strtotime($minuta->fecha_reporte)) }}</span>
            </div>
            <div class="col-md-3">
                <b>Hora</b><br>
                <span>{{ date("H:i", strtotime($minuta->fecha_reporte)) }}</span>
            </div>
            <div class="col-md-3">
                <b>Propiedad</b><br>
                <span>{{ $minuta->sede->nombre }}</span>
            </div>
            <div class="col-md-3">
                <b>Responsable</b><br>
                <span>{{ $minuta->user->name }}</span>
            </div>
            <div class="col-12">
                <b>Observacion</b><br>
                <span>{{ $minuta->observacion }}</span>
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

