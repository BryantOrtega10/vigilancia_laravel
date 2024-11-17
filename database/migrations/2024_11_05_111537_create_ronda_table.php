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
        Schema::create('ronda', function (Blueprint $table) {
            $table->id();
            $table->string("nombre");
            $table->string("codigo_qr");

            $table->bigInteger("fk_sede")->unsigned();
            $table->foreign('fk_sede')->references('id')->on('sede')->onDelete('cascade');
            $table->index('fk_sede');

            $table->timestamps();
        });


        Schema::create('recorrido', function (Blueprint $table) {
            $table->id();
            
            $table->timestamp("fecha_hora")->useCurrent();

            $table->bigInteger("fk_user")->unsigned();
            $table->foreign('fk_user')->references('id')->on('users')->onDelete('cascade');
            $table->index('fk_user');

            $table->bigInteger("fk_ronda")->unsigned();
            $table->foreign('fk_ronda')->references('id')->on('ronda')->onDelete('cascade');
            $table->index('fk_ronda');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("ronda", function(Blueprint $table){
            $table->dropForeign("ronda_fk_sede_foreign");
            $table->dropIndex("ronda_fk_sede_index");
        });

        Schema::table("recorrido", function(Blueprint $table){
            $table->dropForeign("recorrido_fk_user_foreign");
            $table->dropIndex("recorrido_fk_user_index");

            $table->dropForeign("recorrido_fk_ronda_foreign");
            $table->dropIndex("recorrido_fk_ronda_index");
        });

        Schema::dropIfExists('recorrido');
        Schema::dropIfExists('ronda');
    }
};
