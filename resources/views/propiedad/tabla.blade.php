@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)

@section('title', 'Propiedades')

@section('content_header')
    <div class="row">
        <div class="col-md-7">
            <h1>Propiedades</h1>
        </div>
        <div class="text-right col-md-5">
            @can('propiedad.subirCSV')
                <button type="button" class="btn btn-outline-success btn-flat" data-toggle="modal" data-target="#modal-upload">
                    <img src="{{ asset('imgs/excel.png') }}" /> Subir propiedades
                </button>
            @endcan
            @can('propiedad.agregar')
                <a href="{{ route('propiedad.agregar') }}" class="btn btn-outline-primary btn-flat"><i class="fas fa-plus"></i>
                    Crear Propiedad</a>
            @endcan
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
                        <th>Nombre</th>
                        <th>Tipo Propiedad</th>
                        <th>Contacto</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sedes as $sede)
                        <tr>
                            <td>{{ $sede->nombre }}</td>
                            <td>{{ $sede->tipo_sede->nombre }}</td>
                            <td>{{ $sede->contacto }}</td>
                            <td class="text-right">
                                @can('propiedad.config')
                                    <a href="{{ route('propiedad.config', ['id' => $sede->id]) }}"
                                        class="btn btn-outline-secondary"><i class="fas fa-cogs"></i> Config</a>
                                @endcan
                                @can('propiedad.agregar')
                                    <a href="{{ route('propiedad.modificar', ['id' => $sede->id]) }}"
                                        class="btn btn-secondary"><i class="fas fa-pen"></i> Modificar</a>
                                @endcan
                                @can('propiedad.eliminar')
                                <a href="{{ route('propiedad.eliminar', ['id' => $sede->id]) }}"
                                    class="btn btn-danger preguntar" data-mensaje="Eliminar la sede"><i
                                        class="fas fa-trash"></i> Eliminar</a>
                                @endcan  
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade modal-upload" tabindex="-1" id="modal-upload" role="dialog" aria-labelledby="modal-upload"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="my-0">Upload files</h5>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('propiedad.subirCSV') }}" id="form-upload">
                        @csrf
                        <div class="progress-content">
                            <div class="upload-progress">
                                <img src="{{ asset('imgs/excel_big_color.png') }}" />
                            </div>
                            Cargando archivo
                        </div>
                        <div class="response-content"></div>
                        <input type="hidden" name="file64" id="file64" />
                        <div class="upload-box" id="box">
                            <img src="{{ asset('imgs/excel_big.png') }}" /><br>
                            Arrastre los archivos<br>
                            o haga click en el botón<br>
                            <button type="button" class="upload-btn" data-input="files">
                                <img src="{{ asset('imgs/upload.png') }}" /> Subir archivos
                            </button>
                            <input autocomplete="off" type="file" name="files" id="files" accept=".csv" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("body").on("change", "#files", function(e) {
                e.preventDefault();
                const file = $(this)[0].files[0];
                uploadFile(file);
            });

            $("body").on("click", ".upload-btn", function(e) {
                e.preventDefault();
                let input = $(this).attr("data-input");
                $("#" + input).trigger("click");
            });

            $("body").on("dragover", ".upload-box", function(ev) {
                $(ev.target).attr("drop-active", true);
                ev.preventDefault();
            });

            $("body").on("dragleave", ".upload-box", function(ev) {
                $(ev.target).removeAttr("drop-active");
                ev.preventDefault();
            });

            if (document.getElementsByClassName("upload-box").length > 0) {
                document
                    .getElementsByClassName("upload-box")[0]
                    .addEventListener("drop", handleDrop, false);
            }

            function handleDrop(ev) {
                ev.preventDefault();
                if (ev.dataTransfer.items) {
                    for (let i = 0; i < ev.dataTransfer.items.length; i++) {
                        // Si los elementos arrastrados no son ficheros, rechazarlos
                        if (ev.dataTransfer.items[i].kind === "file") {
                            const file = ev.dataTransfer.items[i].getAsFile();
                            uploadFile(file);
                        }
                    }
                } else {
                    for (let i = 0; i < ev.dataTransfer.files.length; i++) {
                        const file = ev.dataTransfer.files[i];
                        uploadFile(file);
                    }
                }

                if (ev.dataTransfer.items) {
                    ev.dataTransfer.items.clear();
                } else {
                    ev.dataTransfer.clearData();
                }
                $(ev.target).removeAttr("drop-active");
            }

            const uploadFile = function(file) {
                let reader = new FileReader();
                reader.onloadend = function() {
                    $("#file64").val(reader.result);
                    $("#form-upload").submit();
                };
                if (file) {
                    reader.readAsDataURL(file);
                }
            };

            $("body").on("click", ".close-response", function(e) {
                $(this).parent().remove();
            });

            $("body").on("submit", "#form-upload", function(e) {
                e.preventDefault();

                $(".progress-content").addClass("active");
                var formdata = new FormData(this);
                $.ajax({
                    type: "POST",
                    url: $(this).attr("action"),
                    cache: false,
                    processData: false,
                    contentType: false,
                    data: formdata,
                    success: function(data) {
                        $(".progress-content").removeClass("active");
                        if (data.success) {
                            $(".response-content").append(
                                "<div class='response-success'>" +
                                data.message +
                                "<button class='close-response'></button></div>"
                            );
                        } else {
                            $(".response-content").append(
                                "<div class='response-error'>" +
                                data.message +
                                "<button class='close-response'></button></div>"
                            );
                        }
                    },
                    error: function(data) {
                        $(".response-content").append(
                            "<div class='response-error'>Error server</div>"
                        );
                    },
                });
            });
        })
    </script>
@stop
