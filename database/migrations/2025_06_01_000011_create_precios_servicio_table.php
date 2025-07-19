<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('precioServicios', function (Blueprint $table) {
            $table->bigIncrements('idprecioservicio');
            $table->unsignedBigInteger('idservicio');
            $table->decimal('rangouno', 8, 2);
            $table->decimal('rangodos', 8, 2);
            $table->decimal('valor', 8, 4);
            $table->boolean('estado');
            $table->timestamps();

            // Relaciones
            $table->foreign('idservicio')->references('idservicio')->on('servicios')->onDelete('cascade');
        });
    }

    // Reverse the migrations.
    public function down(): void
    {
        Schema::dropIfExists('precioServicios');
    }
};
