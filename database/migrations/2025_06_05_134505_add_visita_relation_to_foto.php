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
        Schema::table('foto', function (Blueprint $table) {
            $table->bigInteger("fk_visita")->unsigned()->nullable();
            $table->foreign('fk_visita')->references('id')->on('visita')->onDelete('cascade');
            $table->index('fk_visita');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table("foto", function(Blueprint $table){
            $table->dropForeign("foto_fk_visita_foreign");
            $table->dropIndex("foto_fk_visita_index");
            $table->dropColumn("fk_visita");
        });

       
    }
};
