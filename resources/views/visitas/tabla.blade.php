@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)

@section('title', 'Entradas y Sálidas')

@section('content_header')
    <div class="row">
        <div class="col-md-12">
            <h1>Entradas y Sálidas</h1>
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
                        <th>Responsable</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($visitas as $visita)
                        <tr>
                            <td>{{ $visita->propiedad->gr_propiedad->sede->nombre }}</td>
                            <td>{{ date("Y/m/d", strtotime($visita->fecha_entrada)) }}</td>
                            <td>{{ date("H:i", strtotime($visita->fecha_entrada)) }}</td>
                            <td>{{ $visita->responsable }}</td>
                            <td class="text-right">
                                <a href="{{ route('visitas.verDetalles',['id' => $visita->id])}}" class="btn btn-outline-success ver_visita"><i class="fas fa-eye"></i> Ver</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="verVisitaModal" tabindex="-1" aria-labelledby="verVisitaModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Resumen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="resumen_visita"></div>
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
            $("body").on("click",".ver_visita",function(e){
                e.preventDefault()
                $.ajax({
                    type: 'GET',
                    url: $(this).attr("href"),
                    success: function(data) {
                        if(data.success){
                            $("#verVisitaModal").modal("show");
                            $(".resumen_visita").html(data.html);
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
