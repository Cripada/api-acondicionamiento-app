<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('proformas', function (Blueprint $table) {
            $table->bigIncrements('idproforma');
            $table->string('num_proforma', 15)->nullable()->default('-');
            $table->string('num_ot', 15)->nullable()->default('-');
            $table->string('num_actualizacion', 15)->nullable()->default('-');
            $table->unsignedBigInteger('idsede');
            $table->unsignedBigInteger('idcliente');
            $table->unsignedBigInteger('idusuario');
            $table->date('fechaEmision');
            $table->date('fechaEstimadaInicio');
            $table->date('fechaEstimadaFinalizacion');
            $table->string('horasEstimadas');
            $table->integer('idTipoFacturacion');
            $table->string('correo');
            $table->string('comentario');
            $table->string('solicitante');
            $table->timestamps();
            $table->enum('status', ['Pendiente', 'Autorizada','Aprobada', 'Reemplazada', 'Terminada', 'Facturada'])->default('Pendiente');

            // Relaciones
            $table->foreign('idcliente')->references('idcliente')->on('clientes')->onDelete('cascade');

            $table->foreign('idsede')->references('idsede')->on('sedes')->onDelete('cascade');

            $table->foreign('idusuario')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proformas');
    }
};
