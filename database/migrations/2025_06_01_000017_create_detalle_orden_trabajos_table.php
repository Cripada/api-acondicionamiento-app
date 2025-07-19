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
        Schema::create('detalleOrdenTrabajo', function (Blueprint $table) {
            
            $table->id('iddetalle');
            $table->unsignedBigInteger('idorden');
            $table->unsignedBigInteger('idservicio');
            $table->string('produccionHora', 255)->nullable();
            $table->text('observacion')->nullable(); // Observaciones adicionales al servicio
            $table->decimal('avance', 5, 2)->default(0); // Porcentaje de avance específico de este detalle
            $table->enum('estado', ['Pendiente', 'En progreso', 'Finalizada'])->default('Pendiente');

            $table->timestamps();
            $table->softDeletes(); // Para auditoría y recuperación

            // Foreign keys
            $table->foreign('idorden')->references('idorden')->on('ordenesTrabajo')->onDelete('cascade');
            $table->foreign('idservicio')->references('idservicio')->on('servicios')->onDelete('no action');

            // Índices útiles
            $table->index(['idorden', 'idservicio', 'estado']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalleOrdenTrabajo');
    }
};
