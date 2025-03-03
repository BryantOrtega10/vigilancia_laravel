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
        Schema::table('novedad_veh', function (Blueprint $table) {
            $table->string("placa")->nullable();            
            $table->bigInteger("fk_tipo_vehiculo")->unsigned()->nullable();
            $table->foreign('fk_tipo_vehiculo')->references('id')->on('tipo_vehiculo')->onDelete('cascade');
            $table->index('fk_tipo_vehiculo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("novedad_veh", function(Blueprint $table){
            $table->dropForeign("novedad_veh_fk_tipo_vehiculo_foreign");
            $table->dropIndex("novedad_veh_fk_tipo_vehiculo_index");
        });

        Schema::table("novedad_veh", function(Blueprint $table){
            $table->dropColumn("placa");
            $table->dropColumn("fk_tipo_vehiculo");
        });
    }
};
