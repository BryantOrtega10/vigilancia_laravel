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
        Schema::table('propiedad', function (Blueprint $table) {
            $table->bigInteger("fk_propietario")->unsigned()->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('propiedad', function (Blueprint $table) {
            $table->bigInteger("fk_propietario")->unsigned()->nullable(false)->change();
        });
    }
};
