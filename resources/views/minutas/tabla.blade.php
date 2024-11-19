@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)

@section('title', 'Minutas')

@section('content_header')
    <div class="row">
        <div class="col-md-12">
            <h1>Minutas</h1>
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
                        <th>Usuario</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($minutas as $minuta)
                        <tr>
                            <td>{{ $minuta->sede->nombre }}</td>
                            <td>{{ date("Y/m/d", strtotime($minuta->fecha_reporte)) }}</td>
                            <td>{{ date("H:i", strtotime($minuta->fecha_reporte)) }}</td>
                            <td>{{ $minuta->user->name }}</td>
                            <td class="text-right">
                                <a href="{{ route('minuta.verDetalles',['id' => $minuta->id])}}" class="btn btn-outline-success ver_minuta"><i class="fas fa-eye"></i> Ver</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="verMinutaModal" tabindex="-1" aria-labelledby="verMinutaModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Resumen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="resumen_minuta"></div>
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
            $("body").on("click",".ver_minuta",function(e){
                e.preventDefault()
                $.ajax({
                    type: 'GET',
                    url: $(this).attr("href"),
                    success: function(data) {
                        if(data.success){
                            $("#verMinutaModal").modal("show");
                            $(".resumen_minuta").html(data.html);
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
