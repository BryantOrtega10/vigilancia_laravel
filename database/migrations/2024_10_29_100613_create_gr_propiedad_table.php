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

        Schema::create('tipo_gr_propiedad', function (Blueprint $table) {
            $table->id();
            $table->string("nombre");
            $table->timestamps();
        });


        Schema::create('gr_propiedad', function (Blueprint $table) {
            $table->id();
            $table->string("nombre");

            $table->bigInteger("fk_tipo_gr_propiedad")->unsigned();
            $table->foreign('fk_tipo_gr_propiedad')->references('id')->on('tipo_gr_propiedad')->onDelete('cascade');
            $table->index('fk_tipo_gr_propiedad');

            $table->bigInteger("fk_sede")->unsigned();
            $table->foreign('fk_sede')->references('id')->on('sede')->onDelete('cascade');
            $table->index('fk_sede');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::table("gr_propiedad", function(Blueprint $table){
            $table->dropForeign("gr_propiedad_fk_tipo_gr_propiedad_foreign");
            $table->dropIndex("gr_propiedad_fk_tipo_gr_propiedad_index");

            $table->dropForeign("gr_propiedad_fk_sede_foreign");
            $table->dropIndex("gr_propiedad_fk_sede_index");
        });

        Schema::dropIfExists('tipo_gr_propiedad');
        Schema::dropIfExists('gr_propiedad');
    }
};
