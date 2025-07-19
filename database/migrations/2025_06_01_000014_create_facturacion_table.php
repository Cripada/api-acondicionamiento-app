<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('facturacion', function (Blueprint $table) {
            $table->bigIncrements('idfacturacion');
            $table->unsignedBigInteger('idproforma');
            $table->unsignedBigInteger('idusuario');
            $table->date('fechaFactura');
            $table->string('numeroFactura');
            $table->string('comentario');

            // Relaciones
            $table->foreign('idproforma')
                ->references('idproforma')->on('proformas')
                ->onDelete('cascade');

            $table->foreign('idusuario')
                  ->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facturacion');
    }
};
