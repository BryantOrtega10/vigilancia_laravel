<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Matriz de riesgo - {{ $sede->nombre }}</title>
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
        .border-b{
            border-bottom: 1px solid #CCC;
        }
        .border-table *, .border-table{
            border: 1px solid #000;
            border-collapse: collapse;
        }
        .text-center{
            text-align: center;
        }
    </style>
    <div class="centrar">
        <h3>Matriz de riesgo de {{ $sede->nombre }}</h3>

        <div class="row border-b">
            <div class="col-md-3 col-12">
                <b>Dirección</b><br>
                <span>{{ $sede->direccion }}</span>
            </div>
            <div class="col-md-3 col-12">
                <b>Teléfono</b><br>
                <span>{{ $sede->telefono }}</span>
            </div>
            <div class="col-md-3 col-12">
                <b>Correo</b><br>
                <span>{{ $sede->correo }}</span>
            </div>
        </div>
        <br><br>
        <table class="w-100 border-table">
            <tr>
                <th rowspan="2">Riesgo</th>
                <th colspan="3">Impacto</th>
            </tr>
            <tr>                
                <th>Bajo</th>
                <th>Medio</th>
                <th>Alto</th>
            </tr>
            @foreach ($riesgos as $riesgo)
                <tr>
                    <td width="300">{{$riesgo->descripcion}}</td>
                    <td class="text-center">@if ($riesgo->impacto == 1) {{($riesgo->probabilidad / 10)*100}}%  @endif</td>
                    <td class="text-center">@if ($riesgo->impacto == 2) {{($riesgo->probabilidad / 10)*100}}%  @endif</td>
                    <td class="text-center">@if ($riesgo->impacto == 3) {{($riesgo->probabilidad / 10)*100}}%  @endif</td>
                </tr>
            @endforeach
        </table>
    </div>
</body>

</html>
