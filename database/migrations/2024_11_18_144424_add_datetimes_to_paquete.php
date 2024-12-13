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
        Schema::table('paquete', function (Blueprint $table) {
            $table->dateTime("fecha_recepcion")->useCurrent();
            $table->dateTime("fecha_entrega")->useCurrent()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('paquete', function (Blueprint $table) {
            $table->dropColumn("fecha_recepcion");
            $table->dropColumn("fecha_entrega");
        }); 
    }
};
