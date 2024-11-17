<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('visita', function (Blueprint $table) {
            $table->id();

            $table->timestamp("fecha_entrada")->useCurrent();
            $table->timestamp("fecha_salida")->nullable();

            $table->string("documento");
            $table->string("nombre");
            $table->text("observacion");
            $table->string("responsable");
            $table->boolean("manejo_datos");

            $table->string("placa")->nullable();            
            $table->bigInteger("fk_tipo_vehiculo")->unsigned()->nullable();
            $table->foreign('fk_tipo_vehiculo')->references('id')->on('tipo_vehiculo')->onDelete('cascade');
            $table->index('fk_tipo_vehiculo');

            $table->bigInteger("fk_propiedad")->unsigned();
            $table->foreign('fk_propiedad')->references('id')->on('propiedad')->onDelete('cascade');
            $table->index('fk_propiedad');


            $table->bigInteger("fk_user_entrada")->unsigned();
            $table->foreign('fk_user_entrada')->references('id')->on('users')->onDelete('cascade');
            $table->index('fk_user_entrada');

            $table->bigInteger("fk_user_salida")->unsigned()->nullable();
            $table->foreign('fk_user_salida')->references('id')->on('users')->onDelete('cascade');
            $table->index('fk_user_salida');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("visita", function(Blueprint $table){
            $table->dropForeign("visita_fk_propiedad_foreign");
            $table->dropIndex("visita_fk_propiedad_index");

            $table->dropForeign("visita_fk_tipo_vehiculo_foreign");
            $table->dropIndex("visita_fk_tipo_vehiculo_index");

            $table->dropForeign("visita_fk_user_entrada_foreign");
            $table->dropIndex("visita_fk_user_entrada_index");

            $table->dropForeign("visita_fk_user_salida_foreign");
            $table->dropIndex("visita_fk_user_salida_index");
        });

        Schema::dropIfExists('visita');
    }
};
