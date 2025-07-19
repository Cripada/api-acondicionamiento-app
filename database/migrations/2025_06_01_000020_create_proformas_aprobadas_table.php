<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('proformasAprobadas', function (Blueprint $table) {
          
            $table->bigIncrements('idaprobada');
            $table->unsignedBigInteger('idproforma');
            $table->unsignedBigInteger('idsede');
            $table->unsignedBigInteger('idusuario');
            $table->date('fechaAutorizacion');
            $table->string('comentario');

            // Relaciones
            $table->foreign('idsede')->references('idsede')->on('sedes')->onDelete('cascade');
            $table->foreign('idusuario')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proformasAprobadas');
    }
};
