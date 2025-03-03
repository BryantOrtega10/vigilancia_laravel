<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $ruta
 * @property int|null $fk_minuta
 * @property int|null $fk_paquete
 * @property int|null $fk_novedad_veh
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $minuta
 * @property-read \App\Models\User|null $novedad_veh
 * @property-read \App\Models\User|null $paquete
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FotoModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FotoModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FotoModel query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FotoModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FotoModel whereFkMinuta($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FotoModel whereFkNovedadVeh($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FotoModel whereFkPaquete($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FotoModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FotoModel whereRuta($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FotoModel whereUpdatedAt($value)
 */
	class FotoModel extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $nombre
 * @property int $fk_tipo_gr_propiedad
 * @property int $fk_sede
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PropiedadModel> $propiedades
 * @property-read int|null $propiedades_count
 * @property-read \App\Models\SedeModel $sede
 * @property-read \App\Models\TipoGrPropiedadModel $tipo_gr_propiedad
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GrPropiedadModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GrPropiedadModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GrPropiedadModel query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GrPropiedadModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GrPropiedadModel whereFkSede($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GrPropiedadModel whereFkTipoGrPropiedad($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GrPropiedadModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GrPropiedadModel whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GrPropiedadModel whereUpdatedAt($value)
 */
	class GrPropiedadModel extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $fecha_reporte
 * @property string $observacion
 * @property int $fk_sede
 * @property int $fk_user
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\SedeModel $sede
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MinutaModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MinutaModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MinutaModel query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MinutaModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MinutaModel whereFechaReporte($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MinutaModel whereFkSede($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MinutaModel whereFkUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MinutaModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MinutaModel whereObservacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MinutaModel whereUpdatedAt($value)
 */
	class MinutaModel extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $fecha_hora
 * @property string $observacion
 * @property int|null $fk_vehiculo
 * @property int|null $fk_visita
 * @property int $fk_user
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @property-read \App\Models\VehiculoModel|null $vehiculo
 * @property-read \App\Models\VisitaModel|null $visita
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NovedadVehModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NovedadVehModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NovedadVehModel query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NovedadVehModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NovedadVehModel whereFechaHora($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NovedadVehModel whereFkUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NovedadVehModel whereFkVehiculo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NovedadVehModel whereFkVisita($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NovedadVehModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NovedadVehModel whereObservacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NovedadVehModel whereUpdatedAt($value)
 */
	class NovedadVehModel extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $observacion
 * @property string $codigo
 * @property int $entregado
 * @property int $fk_propiedad
 * @property int $fk_user_recibe
 * @property int|null $fk_user_entrega
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $fecha_recepcion
 * @property string|null $fecha_entrega
 * @property-read \App\Models\PropiedadModel $propiedad
 * @property-read \App\Models\User|null $user_entrega
 * @property-read \App\Models\User $user_recibe
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaqueteModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaqueteModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaqueteModel query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaqueteModel whereCodigo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaqueteModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaqueteModel whereEntregado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaqueteModel whereFechaEntrega($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaqueteModel whereFechaRecepcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaqueteModel whereFkPropiedad($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaqueteModel whereFkUserEntrega($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaqueteModel whereFkUserRecibe($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaqueteModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaqueteModel whereObservacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaqueteModel whereUpdatedAt($value)
 */
	class PaqueteModel extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $nombre
 * @property int|null $fk_propietario
 * @property int $fk_gr_propiedad
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\GrPropiedadModel $gr_propiedad
 * @property-read \App\Models\PropietarioModel|null $propietario
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PropiedadModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PropiedadModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PropiedadModel query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PropiedadModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PropiedadModel whereFkGrPropiedad($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PropiedadModel whereFkPropietario($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PropiedadModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PropiedadModel whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PropiedadModel whereUpdatedAt($value)
 */
	class PropiedadModel extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $nombres
 * @property string $apellidos
 * @property string $celular_p
 * @property string $celular_s
 * @property string|null $email
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PropietarioModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PropietarioModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PropietarioModel query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PropietarioModel whereApellidos($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PropietarioModel whereCelularP($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PropietarioModel whereCelularS($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PropietarioModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PropietarioModel whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PropietarioModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PropietarioModel whereNombres($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PropietarioModel whereUpdatedAt($value)
 */
	class PropietarioModel extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $fecha_hora
 * @property int $fk_user
 * @property int $fk_ronda
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\RondaModel $ronda
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecorridoModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecorridoModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecorridoModel query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecorridoModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecorridoModel whereFechaHora($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecorridoModel whereFkRonda($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecorridoModel whereFkUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecorridoModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecorridoModel whereUpdatedAt($value)
 */
	class RecorridoModel extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $nombre
 * @property string $codigo_qr
 * @property int $fk_sede
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\SedeModel $sede
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RondaModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RondaModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RondaModel query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RondaModel whereCodigoQr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RondaModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RondaModel whereFkSede($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RondaModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RondaModel whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RondaModel whereUpdatedAt($value)
 */
	class RondaModel extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $nombre
 * @property string|null $direccion
 * @property string|null $telefono
 * @property string|null $contacto
 * @property string|null $correo
 * @property int $fk_tipo_sede
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\TipoSedeModel $tipo_sede
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SedeModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SedeModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SedeModel query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SedeModel whereContacto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SedeModel whereCorreo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SedeModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SedeModel whereDireccion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SedeModel whereFkTipoSede($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SedeModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SedeModel whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SedeModel whereTelefono($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SedeModel whereUpdatedAt($value)
 */
	class SedeModel extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $nombre
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoGrPropiedadModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoGrPropiedadModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoGrPropiedadModel query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoGrPropiedadModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoGrPropiedadModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoGrPropiedadModel whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoGrPropiedadModel whereUpdatedAt($value)
 */
	class TipoGrPropiedadModel extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $nombre
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoSedeModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoSedeModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoSedeModel query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoSedeModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoSedeModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoSedeModel whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoSedeModel whereUpdatedAt($value)
 */
	class TipoSedeModel extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $nombre
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoVehiculoModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoVehiculoModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoVehiculoModel query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoVehiculoModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoVehiculoModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoVehiculoModel whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoVehiculoModel whereUpdatedAt($value)
 */
	class TipoVehiculoModel extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $rol
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserSedeModel> $user_sede
 * @property-read int|null $user_sede_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRol($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $fk_user
 * @property int $fk_sede
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\SedeModel $sede
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSedeModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSedeModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSedeModel query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSedeModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSedeModel whereFkSede($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSedeModel whereFkUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSedeModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSedeModel whereUpdatedAt($value)
 */
	class UserSedeModel extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $placa
 * @property int $fk_propiedad
 * @property int $fk_tipo_vehiculo
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\PropiedadModel $propiedad
 * @property-read \App\Models\TipoVehiculoModel $tipo_vehiculo
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehiculoModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehiculoModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehiculoModel query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehiculoModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehiculoModel whereFkPropiedad($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehiculoModel whereFkTipoVehiculo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehiculoModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehiculoModel wherePlaca($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehiculoModel whereUpdatedAt($value)
 */
	class VehiculoModel extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $fecha_entrada
 * @property string|null $fecha_salida
 * @property string $documento
 * @property string $nombre
 * @property string|null $observacion
 * @property string $responsable
 * @property int $manejo_datos
 * @property string|null $placa
 * @property int|null $fk_tipo_vehiculo
 * @property int $fk_propiedad
 * @property int $fk_user_entrada
 * @property int|null $fk_user_salida
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\PropiedadModel $propiedad
 * @property-read \App\Models\TipoVehiculoModel|null $tipo_vehiculo
 * @property-read \App\Models\User $user_entrada
 * @property-read \App\Models\User|null $user_salida
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisitaModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisitaModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisitaModel query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisitaModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisitaModel whereDocumento($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisitaModel whereFechaEntrada($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisitaModel whereFechaSalida($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisitaModel whereFkPropiedad($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisitaModel whereFkTipoVehiculo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisitaModel whereFkUserEntrada($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisitaModel whereFkUserSalida($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisitaModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisitaModel whereManejoDatos($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisitaModel whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisitaModel whereObservacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisitaModel wherePlaca($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisitaModel whereResponsable($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisitaModel whereUpdatedAt($value)
 */
	class VisitaModel extends \Eloquent {}
}

