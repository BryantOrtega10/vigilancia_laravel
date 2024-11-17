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
        Schema::create('novedad_veh', function (Blueprint $table) {
            $table->id();
            $table->timestamp("fecha_hora");
            $table->text("observacion");
            
            $table->bigInteger("fk_vehiculo")->unsigned()->nullable();
            $table->foreign('fk_vehiculo')->references('id')->on('vehiculo')->onDelete('cascade');
            $table->index('fk_vehiculo');

            $table->bigInteger("fk_visita")->unsigned()->nullable();
            $table->foreign('fk_visita')->references('id')->on('visita')->onDelete('cascade');
            $table->index('fk_visita');

            $table->bigInteger("fk_user")->unsigned();
            $table->foreign('fk_user')->references('id')->on('users')->onDelete('cascade');
            $table->index('fk_user');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("novedad_veh", function(Blueprint $table){
            $table->dropForeign("novedad_veh_fk_vehiculo_foreign");
            $table->dropIndex("novedad_veh_fk_vehiculo_index");

            $table->dropForeign("novedad_veh_fk_visita_foreign");
            $table->dropIndex("novedad_veh_fk_visita_index");

            $table->dropForeign("novedad_veh_fk_user_foreign");
            $table->dropIndex("novedad_veh_fk_user_index");
        });

        Schema::dropIfExists('novedad_veh');
    }
};
