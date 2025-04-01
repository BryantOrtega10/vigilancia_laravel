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
        Schema::create('riesgo', function (Blueprint $table) {
            $table->id();
            
            $table->integer("probabilidad");
            $table->text("descripcion")->nullable();
            
            $table->integer("impacto")->nullable();

            $table->tinyInteger("estado")->nullable()->default(1)->comment("0 - Inactivo, 1 - Activo");

            $table->bigInteger("fk_sede")->unsigned();
            $table->foreign('fk_sede')->references('id')->on('sede')->onDelete('cascade');
            $table->index('fk_sede');
            
            $table->timestamps();
        });

        Schema::create('riesgo_log', function (Blueprint $table) {            
            $table->id();

            $table->text("descripcion")->nullable();
            $table->integer("probabilidad");
            $table->integer("impacto")->nullable();

            $table->bigInteger("fk_riesgo")->unsigned();
            $table->foreign('fk_riesgo')->references('id')->on('riesgo')->onDelete('cascade');
            $table->index('fk_riesgo');

            $table->bigInteger("fk_user")->unsigned()->nullable();
            $table->foreign('fk_user')->references('id')->on('users')->onDelete('cascade');
            $table->index('fk_user');
            
            $table->timestamps();
        });

        Schema::table('foto', function (Blueprint $table) {
            $table->bigInteger("fk_riesgo_log")->unsigned()->nullable();
            $table->foreign('fk_riesgo_log')->references('id')->on('riesgo_log')->onDelete('cascade');
            $table->index('fk_riesgo_log');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("foto", function(Blueprint $table){
            $table->dropForeign("foto_fk_riesgo_log_foreign");
            $table->dropIndex("foto_fk_riesgo_log_index");
            
        });

        Schema::table("riesgo_log", function(Blueprint $table){
            $table->dropForeign("riesgo_log_fk_riesgo_foreign");
            $table->dropIndex("riesgo_log_fk_riesgo_index");

            $table->dropForeign("riesgo_log_fk_user_foreign");
            $table->dropIndex("riesgo_log_fk_user_index");
        });

        Schema::table("riesgo", function(Blueprint $table){
            $table->dropForeign("riesgo_fk_sede_foreign");
            $table->dropIndex("riesgo_fk_sede_index");
        });
     
        Schema::table("foto", function(Blueprint $table){
            $table->dropColumn("fk_riesgo_log");
        });

        Schema::dropIfExists('riesgo');
        Schema::dropIfExists('riesgo_log');
        
        
    }
};
