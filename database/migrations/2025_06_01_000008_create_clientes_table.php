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
        Schema::create('clientes', function (Blueprint $table) {
            
            $table->bigIncrements('idcliente'); // Mejor usar bigIncrements para IDs primarios
            $table->string('ruc_cedula', 13)->unique(); // 10 (cédula) o 13 (RUC), depende del formato
            $table->string('nombre_comercial', 150); // 150 suele ser suficiente para nombres comerciales
            $table->string('direccion', 200); // 200 caracteres es suficiente para la mayoría de direcciones
            $table->string('telefono', 75); // Para incluir guiones, paréntesis o código país
            $table->string('email', 150); // 150 suficiente para la mayoría de emails
            $table->boolean('estado')->default(true); // Puede tener un valor por defecto
            $table->timestamps(); // created_at y updated_at

            $table->index('nombre_comercial');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
