@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)

@section('title', 'Recorridos')

@section('content_header')
    <div class="row">
        <div class="col-md-9">
            <h1>Recorridos</h1>
        </div>
        <div class="text-right col-md-3">
            <a href="{{ route('rondas.vistaQRs') }}" class="btn btn-outline-primary btn-flat"><i class="fas fa-qrcode"></i> Rondas</a>
        </div>
    </div>
@stop

@section('content')
    @if (session('mensaje'))
        <div class="alert alert-success">
            {{ session('mensaje') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            <table class="table table-striped datatable">
                <thead>
                    <tr>
                        <th>Propiedad</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Código Qr</th>
                        <th>Recorredor</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recorridos as $recorrido)
                        <tr>
                            <td>{{ $recorrido->ronda->sede->nombre }}</td>
                            <td>{{ date("Y/m/d", strtotime($recorrido->fecha_hora)) }}</td>
                            <td>{{ date("H:i", strtotime($recorrido->fecha_hora)) }}</td>
                            <td>{{ $recorrido->ronda->nombre }}</td>
                            <td>{{ $recorrido->user->name }}</td>
                            <td class="text-right">
                                <a href="{{ route('rondas.verRecorrido',['idRecorrido' => $recorrido->id])}}" class="btn btn-outline-success ver_recorrido"><i class="fas fa-eye"></i> Ver</a>
                                <a href="{{ route('rondas.eliminarRecorrido',['idRecorrido' => $recorrido->id])}}" class="btn btn-danger preguntar" data-mensaje="Eliminar el recorrido"><i class="fas fa-trash"></i> Eliminar</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="verRecorridoModal" tabindex="-1" aria-labelledby="verRecorridoModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="agregar_contenido_modal_label">Ver QR</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img src="" id="verRecorridoImg" alt="QR Code" class="codigoQR_Normal">
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function(e){
            $("body").on("click",".ver_recorrido",function(e){
                e.preventDefault()
                $.ajax({
                    type: 'GET',
                    url: $(this).attr("href"),
                    success: function(data) {
                        if(data.success){
                            $("#verRecorridoModal").modal("show");
                            $("#verRecorridoImg").prop("src",`data:image/png;base64,${ data.qrBase64 }`);
                        }                        
                    },
                    error: function(data) {
                        console.log("error");
                        console.log(data);
                    }
                });
            })
        })
    </script>
@stop
