@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)

@section('title', 'Buzón')

@section('content_header')
    <div class="row">
        <div class="col-md-12">
            <h1>Buzón</h1>
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
                        <th>Residente</th>
                        <th>Estado del código</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($paquetes as $paquete)
                        <tr>
                            <td>{{ $paquete->propiedad->gr_propiedad->sede->nombre }}</td>
                            <td>{{ date("Y/m/d", strtotime($paquete->fecha_recepcion)) }}</td>
                            <td>{{ date("H:i", strtotime($paquete->fecha_recepcion)) }}</td>
                            <td>{{ $paquete->propiedad->propietario->nombres }} {{ $paquete->propiedad->propietario->apellidos }} </td>
                            <td>
                                @if ($paquete->entregado == "1")
                                    Entregado
                                @else
                                    <a href="{{ route('paquetes.validar',['id' => $paquete->id])}}" class="btn btn-outline-primary"><i class="fas fa-check"></i> Validar código</a>
                                @endif
                            </td>
                            <td class="text-right">
                                <a href="{{ route('paquetes.verDetalles',['id' => $paquete->id])}}" class="btn btn-outline-success ver_paquete"><i class="fas fa-eye"></i> Ver</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="verPaqueteModal" tabindex="-1" aria-labelledby="verPaqueteModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Resumen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="resumen_paquete"></div>
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
            $("body").on("click",".ver_paquete",function(e){
                e.preventDefault()
                $.ajax({
                    type: 'GET',
                    url: $(this).attr("href"),
                    success: function(data) {
                        if(data.success){
                            $("#verPaqueteModal").modal("show");
                            $(".resumen_paquete").html(data.html);
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
