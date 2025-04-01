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
        Schema::create('residente', function (Blueprint $table) {
            $table->id();
            $table->string("nombre");
            $table->string("celular")->nullable();

            $table->bigInteger("fk_propiedad")->unsigned();
            $table->foreign('fk_propiedad')->references('id')->on('propiedad')->onDelete('cascade');
            $table->index('fk_propiedad');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("residente", function(Blueprint $table){
            $table->dropForeign("residente_fk_propiedad_foreign");
            $table->dropIndex("residente_fk_propiedad_index");
        });
        
        Schema::dropIfExists('residente');
    }
};
