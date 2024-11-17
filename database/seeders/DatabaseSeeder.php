<?php

namespace Database\Seeders;

use App\Models\FotoModel;
use App\Models\GrPropiedadModel;
use App\Models\MinutaModel;
use App\Models\NovedadVehModel;
use App\Models\PaqueteModel;
use App\Models\PropiedadModel;
use App\Models\PropietarioModel;
use App\Models\RecorridoModel;
use App\Models\RondaModel;
use App\Models\SedeModel;
use App\Models\TipoGrPropiedadModel;
use App\Models\TipoSedeModel;
use App\Models\TipoVehiculoModel;
use App\Models\User;
use App\Models\UserSedeModel;
use App\Models\VehiculoModel;
use App\Models\VisitaModel;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name'=>'Bryant Administrador',
            'email'=>'bryant@mdccolombia.com',
            'password'=> bcrypt('1900'),
            'rol'=> 'admin',
        ]);

        User::create([
            'name'=>'Bryant Vigilante',
            'email'=>'bryant.ortega1010@gmail.com',
            'password'=> bcrypt('1900'),
            'rol'=> 'vigilante',
        ]);

        User::create([
            'name'=>'David Vigilante',
            'email'=>'test@test.com',
            'password'=> bcrypt('1900'),
            'rol'=> 'vigilante',
        ]);

        TipoSedeModel::create(["nombre" => "CENTRO COMERCIAL"]);
        TipoSedeModel::create(["nombre" => "EDIFICIO"]);
        TipoSedeModel::create(["nombre" => "CONJUNTO"]);
        TipoSedeModel::create(["nombre" => "PARQUE"]);
        TipoSedeModel::create(["nombre" => "CENTRO EDUCATIVO"]);

        SedeModel::create([
            "nombre" => "SEDE PRINCIPAL",
            "direccion" => "Calle Falsa 123",
            "telefono" => "000 000 00 00",
            "contacto" => "DIEGO PINEDA",
            "correo" => "webmaster@mdccolombia.com",
            "fk_tipo_sede" => 3,
        ]);

        TipoGrPropiedadModel::create(["nombre" => "BLOQUE"]);
        TipoGrPropiedadModel::create(["nombre" => "TORRE"]);
        TipoGrPropiedadModel::create(["nombre" => "MANZANA"]);
        TipoGrPropiedadModel::create(["nombre" => "PISO"]);
        TipoGrPropiedadModel::create(["nombre" => "SECCION"]);

        GrPropiedadModel::create([
            "nombre" => "SEDE PRINCIPAL",
            "fk_tipo_gr_propiedad" => 1,
            "fk_sede" => 1
        ]);

        PropietarioModel::create([
            "nombres" => "BRYANT",
            "apellidos" => "ORTEGA",
            "celular_p" => "3154861174",
            "celular_s" => "3204386777",
            "email" => "bryant@mdccolombia.com",
        ]);

        PropiedadModel::create([
            "nombre" => "201",
            "fk_propietario" => 1,
            "fk_gr_propiedad" => 1
        ]);

        TipoVehiculoModel::create(["nombre" => "CARRO"]);
        TipoVehiculoModel::create(["nombre" => "MOTO"]);

        VehiculoModel::create([
            "placa" => "UTM422",
            "fk_propiedad" => 1,
            "fk_tipo_vehiculo" => 1
        ]);

        VisitaModel::create([
            "fecha_entrada" => '2024-11-05 17:00:00',
            "fecha_salida" => '2024-11-06 9:00:00',
            "documento" => '1030672',
            "nombre" => 'Vivian Ortega',
            "observacion" => 'Vino a visitar al hermano',
            "responsable" => 'Pepito Perez',
            "manejo_datos" => 1,
            "placa" => 'UTM423',
            "fk_tipo_vehiculo" => 1,
            "fk_propiedad" => 1,
            "fk_user_entrada" => 2,
            "fk_user_salida" => 3,
        ]);

        VisitaModel::create([
            "fecha_entrada" => '2024-11-05 17:00:00',
            "fecha_salida" => null,
            "documento" => '520077',
            "nombre" => 'Flor Veloza',
            "observacion" => 'Vino a visitar al hijo',
            "responsable" => 'Pepito Perez',
            "manejo_datos" => 1,
            "placa" => null,
            "fk_tipo_vehiculo" => null,
            "fk_propiedad" => 1,
            "fk_user_entrada" => 2,
            "fk_user_salida" => null,
        ]);

        VisitaModel::create([
            "fecha_entrada" => '2024-11-09 12:00:00',
            "fecha_salida" => null,
            "documento" => '123456',
            "nombre" => 'Marco López',
            "observacion" => 'Vino a visitar al amigo',
            "responsable" => 'Pepito Perez',
            "manejo_datos" => 1,
            "placa" => "NOS123",
            "fk_tipo_vehiculo" => 2,
            "fk_propiedad" => 1,
            "fk_user_entrada" => 2,
            "fk_user_salida" => null,
        ]);

        RondaModel::create([
            "nombre" => "Puerta 1",
            "codigo_qr" => "123456",
            "fk_sede" => 1,
        ]);

        RecorridoModel::create([
            "fecha_hora" => "2024-11-05 10:00:00",
            "fk_user" => 2,
            "fk_ronda" => 1,
        ]);

        RecorridoModel::create([
            "fecha_hora" => "2024-11-05 11:00:00",
            "fk_user" => 2,
            "fk_ronda" => 1,
        ]);

        NovedadVehModel::create([
            "fecha_hora" => '2024-11-09 13:00:00',
            "observacion" => 'Le falta un espejo',
            "fk_vehiculo" => null,
            "fk_visita" => 3,
            "fk_user" => 3,
        ]);

        NovedadVehModel::create([
            "fecha_hora" => '2024-11-05 13:00:00',
            "observacion" => 'Dejó las luces prendidas',
            "fk_vehiculo" => 1,
            "fk_visita" => null,
            "fk_user" => 2,
        ]);
     
        MinutaModel::create([
            "fecha_reporte" => "2024-11-05 13:15:00",
            "observacion" => "Todo esta bien",
            "fk_sede" => 1,
            "fk_user" => 2,
        ]);

        PaqueteModel::create([
            "observacion" => 'Paquete de mercadolibre',
            "codigo" => 'a1b2c3',
            "entregado" => '0',
            "fk_propiedad" => 1,
            "fk_user_recibe" => 3,
            "fk_user_entrega" => null,
        ]);

        FotoModel::create([
            "ruta" => 'minuta.png',
            "fk_minuta" => '1',
            "fk_paquete" => null,
            "fk_novedad_veh" => null,
        ]);

        FotoModel::create([
            "ruta" => 'paquete1.jpg',
            "fk_minuta" => null,
            "fk_paquete" => '1',
            "fk_novedad_veh" => null,
        ]);
        
        FotoModel::create([
            "ruta" => 'rayado.jpg',
            "fk_minuta" => null,
            "fk_novedad_veh" => null,
            "fk_paquete" => '1',
        ]);

        UserSedeModel::create([
            "fk_user" => 2,
            "fk_sede" => 1,
        ]);
        
        UserSedeModel::create([
            "fk_user" => 3,
            "fk_sede" => 1,
        ]);

        


    }
}
