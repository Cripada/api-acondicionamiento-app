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
        Schema::create('ordenesTrabajo', function (Blueprint $table) {
            
            $table->id('idorden');
            $table->unsignedBigInteger('idproforma');
            $table->string('num_ot', 15)->nullable()->default('-');
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->unsignedBigInteger('idusuario_responsable')->nullable(); // quién es el responsable principal
            $table->enum('estado', ['Pendiente','Autorizada', 'En progreso', 'Finalizada', 'Reemplazada', 'Anulada'])->default('Pendiente');
            $table->enum('prioridad', ['Alta','Media', 'Baja', 'Normal'])->default('Normal'); // puede ser Alta, Media, Baja, etc.
            $table->text('comentario')->nullable();
            $table->decimal('avance_general', 5, 2)->default(0); // porcentaje global de avance
            
            $table->boolean('aprobada')->default(false); // indica si la orden fue aprobada
            $table->date('fecha_aprobacion')->nullable(); // cuándo se aprobó
            $table->unsignedBigInteger('idusuario_aprueba')->nullable(); // quién la aprueba

            $table->timestamps();
            $table->softDeletes(); // para "eliminar" sin borrar realmente

            // Foreign keys
            $table->foreign('idproforma')
                ->references('idproforma')
                ->on('proformas')
                ->onDelete('cascade');

            $table->foreign('idusuario_aprueba')
                ->references('id')
                ->on('users');
                
                $table->foreign('idusuario_responsable')
                ->references('id')
                ->on('users');
            // Index para búsquedas rápidas
            $table->index(['idproforma', 'estado', 'idusuario_responsable']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordenesTrabajo');
    }
};
