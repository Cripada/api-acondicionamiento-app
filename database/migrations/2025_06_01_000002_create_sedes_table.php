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
        Schema::create('sedes', function (Blueprint $table) {
            $table->bigIncrements('idsede');
            $table->string('nombre', 150);
            $table->string('ubicacion', 255);
            $table->string('num_sucursal', 255);
            $table->integer('num_actual_ot');
            $table->integer('num_actual_proforma');
            $table->boolean('estado')->default(true); // Por defecto activo
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sedes');
    }
};
