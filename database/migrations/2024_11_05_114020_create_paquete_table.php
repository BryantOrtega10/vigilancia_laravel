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
        Schema::create('paquete', function (Blueprint $table) {
            $table->id();
            
            $table->text("observacion");
            $table->string("codigo");
            $table->boolean("entregado");

            $table->bigInteger("fk_propiedad")->unsigned();
            $table->foreign('fk_propiedad')->references('id')->on('propiedad')->onDelete('cascade');
            $table->index('fk_propiedad');

            $table->bigInteger("fk_user_recibe")->unsigned();
            $table->foreign('fk_user_recibe')->references('id')->on('users')->onDelete('cascade');
            $table->index('fk_user_recibe');

            $table->bigInteger("fk_user_entrega")->unsigned()->nullable();
            $table->foreign('fk_user_entrega')->references('id')->on('users')->onDelete('cascade');
            $table->index('fk_user_entrega');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("paquete", function(Blueprint $table){
            $table->dropForeign("paquete_fk_propiedad_foreign");
            $table->dropIndex("paquete_fk_propiedad_index");

            $table->dropForeign("paquete_fk_user_recibe_foreign");
            $table->dropIndex("paquete_fk_user_recibe_index");

            $table->dropForeign("paquete_fk_user_entrega_foreign");
            $table->dropIndex("paquete_fk_user_entrega_index");
            
        });

        Schema::dropIfExists('paquete');
    }
};
