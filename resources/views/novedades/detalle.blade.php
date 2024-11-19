<div class="row">
    <div class="col-md-3 col-12">
        <b>Fecha</b><br>
        <span>{{ date("Y/m/d", strtotime($novedad->fecha_hora)) }}</span>
    </div>
    <div class="col-md-3 col-12">
        <b>Hora</b><br>
        <span>{{ date("H:i", strtotime($novedad->fecha_hora)) }}</span>
    </div>
    <div class="col-md-3 col-12">
        <b>Propiedad</b><br>
        <span>{{ $novedad->sede_txt() }}</span>
    </div>
    <div class="col-md-3 col-12">
        <b>Responsable</b><br>
        <span>{{ $novedad->user->name }}</span>
    </div>
    <div class="col-12">
        <b>Observacion</b><br>
        <span>{{ $novedad->observacion }}</span>
    </div>
    <div class="col-12">
        <b>Imagenes</b><br>
        <div class="row">
            @foreach ($fotos as $foto)
                <figure class="col-md-4 col-12">
                    <img src="{{Storage::url('novedades/min_'.$foto->ruta)}}" class="w-100" />
                </figure>
            @endforeach
        </div>
    </div>
    <div class="col-12 text-center">
        <a href="{{route('novedad.pdf',['id' => $novedad->id])}}" class="btn btn-outline-danger"><i class="fas fa-file-pdf"></i> Descargar PDF</a>
    </div>
</div>


