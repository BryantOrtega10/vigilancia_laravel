<h5>Datos recepción</h5>
<div class="row">
    <div class="col-md-3 col-12">
        <b>Fecha</b><br>
        <span>{{ date("Y/m/d", strtotime($paquete->fecha_recepcion)) }}</span>
    </div>
    <div class="col-md-3 col-12">
        <b>Hora</b><br>
        <span>{{ date("H:i", strtotime($paquete->fecha_recepcion)) }}</span>
    </div>
    <div class="col-md-3 col-12">
        <b>Propiedad</b><br>
        <span>{{ $paquete->propiedad->nombre }}</span>
    </div>
    <div class="col-md-3 col-12">
        <b>Recibe</b><br>
        <span>{{ $paquete->user_recibe->name }}</span>
    </div>
</div>
<h5>Datos entrega</h5>
<div class="row">
    @if (!isset($paquete->fecha_entrega) || $paquete->fecha_entrega == null)
        <div class="col-md-12 col-12">
            <b>Aun no se ha entregado</b><br>
        </div>
    @else
        <div class="col-md-3 col-12">
            <b>Fecha</b><br>
            <span>{{ date("Y/m/d", strtotime($paquete->fecha_recepcion)) }}</span>
        </div>
        <div class="col-md-3 col-12">
            <b>Hora</b><br>
            <span>{{ date("H:i", strtotime($paquete->fecha_recepcion)) }}</span>
        </div>
        <div class="col-md-3 col-12">
            <b>Propietario</b><br>
            <span>{{ $paquete->propiedad->propietario->nombres }} {{ $paquete->propiedad->propietario->apellidos }}</span>
        </div>
        <div class="col-md-3 col-12">
            <b>Entrega</b><br>
            <span>{{ $paquete->user_entrega->name }}</span>
        </div>
    @endif
    <div class="col-12">
        <b>Observacion</b><br>
        <span>{{ $paquete->observacion }}</span>
    </div>
    <div class="col-12">
        <b>Imagenes</b><br>
        <div class="row">
            @foreach ($fotos as $foto)
                <figure class="col-md-4 col-12">
                    <img src="{{Storage::url('paquetes/min_'.$foto->ruta)}}" class="w-100" />
                </figure>
            @endforeach
        </div>
    </div>
    <div class="col-12 text-center">
        <a href="{{route('paquetes.pdf',['id' => $paquete->id])}}" class="btn btn-outline-danger"><i class="fas fa-file-pdf"></i> Descargar PDF</a>
    </div>
</div>


