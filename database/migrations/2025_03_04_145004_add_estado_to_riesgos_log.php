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
        Schema::table('riesgo_log', function (Blueprint $table) {
            $table->tinyInteger("estado")->nullable()->default(1)->comment("0 - Inactivo, 1 - Activo");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('riesgo_log', function (Blueprint $table) {
            $table->dropColumn("estado");
        });
    }
};
