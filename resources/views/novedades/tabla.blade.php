@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)

@section('title', 'Novedades Parqueadero')

@section('content_header')
    <div class="row">
        <div class="col-md-12">
            <h1>Novedades Parqueadero</h1>
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
                        <th>Tipo Vehiculo</th>
                        <th>Placa</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($novedades as $novedad)
                        <tr>
                            <td>{{ $novedad->sede_txt() }}</td>
                            <td>{{ $novedad->tipo_veh_txt() }}</td>
                            <td>{{ $novedad->placa_txt() }}</td>
                            <td>{{ date("Y/m/d", strtotime($novedad->fecha_hora)) }}</td>
                            <td>{{ date("H:i", strtotime($novedad->fecha_hora)) }}</td>
                            <td class="text-right">
                                <a href="{{ route('novedad.verDetalles',['id' => $novedad->id])}}" class="btn btn-outline-success ver_novedad"><i class="fas fa-eye"></i> Ver</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="verNovedadModal" tabindex="-1" aria-labelledby="verNovedadModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Resumen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="resumen_novedad"></div>
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
            $("body").on("click",".ver_novedad",function(e){
                e.preventDefault()
                $.ajax({
                    type: 'GET',
                    url: $(this).attr("href"),
                    success: function(data) {
                        if(data.success){
                            $("#verNovedadModal").modal("show");
                            $(".resumen_novedad").html(data.html);
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
