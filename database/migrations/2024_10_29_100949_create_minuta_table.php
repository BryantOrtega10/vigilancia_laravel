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
        Schema::create('minuta', function (Blueprint $table) {
            $table->id();
            $table->timestamp("fecha_reporte");
            $table->text("observacion");
                        
            $table->bigInteger("fk_sede")->unsigned();
            $table->foreign('fk_sede')->references('id')->on('sede')->onDelete('cascade');
            $table->index('fk_sede');

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
        Schema::table("minuta", function(Blueprint $table){
            $table->dropForeign("minuta_fk_sede_foreign");
            $table->dropIndex("minuta_fk_sede_index");

            $table->dropForeign("minuta_fk_user_foreign");
            $table->dropIndex("minuta_fk_user_index");
        });

        Schema::dropIfExists('minuta');
    }
};
