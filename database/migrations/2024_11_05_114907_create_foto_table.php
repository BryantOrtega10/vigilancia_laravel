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
        Schema::create('foto', function (Blueprint $table) {
            $table->id();
            $table->string("ruta");

            $table->bigInteger("fk_minuta")->unsigned()->nullable();
            $table->foreign('fk_minuta')->references('id')->on('minuta')->onDelete('cascade');
            $table->index('fk_minuta');

            $table->bigInteger("fk_paquete")->unsigned()->nullable();
            $table->foreign('fk_paquete')->references('id')->on('paquete')->onDelete('cascade');
            $table->index('fk_paquete');

            $table->bigInteger("fk_novedad_veh")->unsigned()->nullable();
            $table->foreign('fk_novedad_veh')->references('id')->on('novedad_veh')->onDelete('cascade');
            $table->index('fk_novedad_veh');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("foto", function(Blueprint $table){
            $table->dropForeign("foto_fk_minuta_foreign");
            $table->dropIndex("foto_fk_minuta_index");

            $table->dropForeign("foto_fk_paquete_foreign");
            $table->dropIndex("foto_fk_paquete_index");

            $table->dropForeign("foto_fk_novedad_veh_foreign");
            $table->dropIndex("foto_fk_novedad_veh_index");            
        });


        Schema::dropIfExists('foto');
    }
};
