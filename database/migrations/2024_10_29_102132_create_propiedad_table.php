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
        Schema::create('propiedad', function (Blueprint $table) {
            $table->id();
            $table->string("nombre");

            $table->bigInteger("fk_propietario")->unsigned();
            $table->foreign('fk_propietario')->references('id')->on('propietario')->onDelete('cascade');
            $table->index('fk_propietario');

            $table->bigInteger("fk_gr_propiedad")->unsigned();
            $table->foreign('fk_gr_propiedad')->references('id')->on('gr_propiedad')->onDelete('cascade');
            $table->index('fk_gr_propiedad');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("propiedad", function(Blueprint $table){
            $table->dropForeign("propiedad_fk_gr_propiedad_foreign");
            $table->dropIndex("propiedad_fk_gr_propiedad_index");
            
            $table->dropForeign("propiedad_fk_propietario_foreign");
            $table->dropIndex("propiedad_fk_propietario_index");
        });

        Schema::dropIfExists('propiedad');
    }
};
