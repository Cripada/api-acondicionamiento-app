<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asignarSedes', function (Blueprint $table) {
            $table->bigIncrements('idasignarsede');
            $table->unsignedBigInteger('idusuario');
            $table->unsignedBigInteger('idsede');
            $table->boolean('estado');
            $table->timestamps();

            $table->unique(['idusuario', 'idsede']);

            // Relaciones
            $table->foreign('idusuario')
                  ->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asignarSedes');
    }
};
