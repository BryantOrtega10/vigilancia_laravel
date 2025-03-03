<h3>Entradas y Salidas</h3>
<div class="row">
    <div class="col-md-3 col-12">
        <b>Sede</b><br>
        <span>{{ $visita->propiedad->gr_propiedad->sede->nombre }}</span>
    </div>
    <div class="col-md-3 col-12">
        <b>Propiedad</b><br>
        <span>{{ $visita->propiedad->nombre }}</span>
    </div>
    <div class="col-md-3 col-12">
        <b>Responsable del ingreso</b><br>
        <span>{{ $visita->responsable }}</span>
    </div>
    <div class="col-md-3 col-12">
        <b>Vigilante entrada</b><br>
        <span>{{ $visita->user_entrada->name }}</span>
    </div>
    <div class="col-md-3 col-12">
        <b>Fecha de entrada</b><br>
        <span>{{ date("Y/m/d", strtotime($visita->fecha_entrada)) }}</span>
    </div>
    <div class="col-md-3 col-12">
        <b>Hora de entrada</b><br>
        <span>{{ date("H:i", strtotime($visita->fecha_entrada)) }}</span>
    </div>
</div>
@if ($visita->fecha_salida != null)
<br>
    <h5>Datos de la salida</h5>
    <div class="row">
        <div class="col-md-3 col-12">
            <b>Fecha de salida</b><br>
            <span>{{ date("Y/m/d", strtotime($visita->fecha_salida)) }}</span>
        </div>
        <div class="col-md-3 col-12">
            <b>Hora de salida</b><br>
            <span>{{ date("H:i", strtotime($visita->fecha_salida)) }}</span>
        </div>
        <div class="col-md-3 col-12">
            <b>Vigilante salida</b><br>
            <span>{{ $visita->user_salida->name }}</span>
        </div>
    </div>
@endif
<br>
<h5>Datos del visitante</h5>
<div class="row">
    <div class="col-md-3 col-12">
        <b>Nombre</b><br>
        <span>{{ $visita->nombre }}</span>
    </div>
    <div class="col-md-3 col-12">
        <b>Documento</b><br>
        <span>{{ $visita->documento }}</span>
    </div>
</div>
@if ($visita->placa != null)
<br>
    <h5>Datos del vehiculo</h5>
    <div class="row">
        <div class="col-md-3 col-12">
            <b>Tipo Vehículo</b><br>
            <span>{{ $visita->tipo_vehiculo->nombre }}</span>
        </div>
        <div class="col-md-3 col-12">
            <b>Placa</b><br>
            <span>{{ $visita->placa }}</span>
        </div>
    </div>
@endif
<br>
<div class="row">
    <div class="col-12">
        <b>Observaciones</b><br>
        <span>{{ $visita->observacion }}</span>
    </div>
    <div class="col-12">
        <b>¿Autorizo el tratamiento de datos?</b><br>
        <span>{{ $visita->manejo_datos ? 'SI' : 'NO' }}</span>
    </div>
    <div class="col-12 text-center">
        <a href="{{ route('visitas.pdf', ['id' => $visita->id]) }}" class="btn btn-outline-danger"><i
                class="fas fa-file-pdf"></i> Descargar PDF</a>
    </div>
</div>
