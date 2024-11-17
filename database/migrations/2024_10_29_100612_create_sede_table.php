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

        Schema::create('tipo_sede', function (Blueprint $table) {
            $table->id();
            $table->string("nombre");
            $table->timestamps();
        });


        Schema::create('sede', function (Blueprint $table) {
            $table->id();
            $table->string("nombre");
            $table->string("direccion")->nullable();
            $table->string("telefono")->nullable();
            $table->string("contacto")->nullable();
            $table->string("correo")->nullable();

            $table->bigInteger("fk_tipo_sede")->unsigned();
            $table->foreign('fk_tipo_sede')->references('id')->on('tipo_sede')->onDelete('cascade');
            $table->index('fk_tipo_sede');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::table("sede", function(Blueprint $table){
            $table->dropForeign("sede_fk_tipo_sede_foreign");
            $table->dropIndex("sede_fk_tipo_sede_index");
        });

        Schema::dropIfExists('tipo_sede');
        Schema::dropIfExists('sede');
    }
};
