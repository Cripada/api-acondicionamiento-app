<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ordenTrabajoUsuario', function (Blueprint $table) {
            $table->id(); // PK autoincremental
            $table->unsignedBigInteger('idorden');
            $table->unsignedBigInteger('idusuario');
            $table->time('tiempo_asignado')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();

            $table->foreign('idorden')->references('idorden')->on('ordenesTrabajo')->onDelete('cascade');
            $table->foreign('idusuario')->references('id')->on('users');

            $table->unique(['idorden', 'idusuario']); // Evitar repetidos
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordenTrabajoUsuario');
    }
};
