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
        Schema::create('tipo_vehiculo', function (Blueprint $table) {
            $table->id();
            $table->string("nombre");
            $table->timestamps();
        });


        Schema::create('vehiculo', function (Blueprint $table) {
            $table->id();

            $table->string("placa");

            $table->bigInteger("fk_propiedad")->unsigned();
            $table->foreign('fk_propiedad')->references('id')->on('propiedad')->onDelete('cascade');
            $table->index('fk_propiedad');

            $table->bigInteger("fk_tipo_vehiculo")->unsigned();
            $table->foreign('fk_tipo_vehiculo')->references('id')->on('tipo_vehiculo')->onDelete('cascade');
            $table->index('fk_tipo_vehiculo');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("vehiculo", function(Blueprint $table){
            $table->dropForeign("vehiculo_fk_propiedad_foreign");
            $table->dropIndex("vehiculo_fk_propiedad_index");

            $table->dropForeign("vehiculo_fk_tipo_vehiculo_foreign");
            $table->dropIndex("vehiculo_fk_tipo_vehiculo_index");
        });
        Schema::dropIfExists('vehiculo');
        Schema::dropIfExists('tipo_vehiculo');
    }
};
