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
        Schema::table('users', function (Blueprint $table) {
            $table->string('rol');
        });

        Schema::create('users_sede', function (Blueprint $table) {
            $table->id();

            $table->bigInteger("fk_user")->unsigned();
            $table->foreign('fk_user')->references('id')->on('users')->onDelete('cascade');
            $table->index('fk_user');

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

        Schema::table("users_sede", function(Blueprint $table){
            $table->dropForeign("users_sede_fk_user_foreign");
            $table->dropIndex("users_sede_fk_user_index");

            $table->dropForeign("users_sede_fk_sede_foreign");
            $table->dropIndex("users_sede_fk_sede_index");
        });

        Schema::dropIfExists('users_sede');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('rol');
        });
    }
};
