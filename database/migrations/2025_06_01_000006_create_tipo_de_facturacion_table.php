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
        Schema::create('tipoFacturacion', function (Blueprint $table) {
           
            $table->bigIncrements('idTipoFacturacion');
            $table->string('nombre', 150);
            $table->string('descripcion', 255);
            $table->boolean('estado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipoFacturacion');
    }
};
