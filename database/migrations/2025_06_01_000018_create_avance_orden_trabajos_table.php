<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('avanceOrdenTrabajos', function (Blueprint $table) {
            $table->id('idavance');

            $table->unsignedBigInteger('iddetalle');
            $table->unsignedBigInteger('idusuario');
            $table->decimal('cantidad', 10, 2)->default(1);
            $table->time('tiempo')->nullable(); // HH:MM:SS, puede ser null si no siempre se usa
            $table->date('fecha');

            $table->string('descripcion', 500)->nullable(); // descripción del avance
            $table->enum('estado', ['pendiente', 'en_progreso', 'completado', 'pausado'])->default('pendiente'); // estado del avance
            $table->boolean('aprobado')->default(false); // si el avance fue revisado o aprobado por un supervisor
            $table->text('observaciones')->nullable(); // observaciones adicionales
            $table->string('archivo_adjunto')->nullable(); // en caso de evidencias, fotos, documentos, etc.
            $table->decimal('porcentaje_avance', 5, 2)->default(0); // avance en porcentaje, ej. 45.25 %

            $table->timestamps();
            $table->softDeletes(); // para poder "eliminar" sin borrar físicamente

            // Foreign keys
            $table->foreign('iddetalle')->references('iddetalle')->on('detalleOrdenTrabajo')->onDelete('cascade');

            $table->foreign('idusuario')->references('id')->on('users');

            // Index para búsqueda rápida
            $table->index(['iddetalle', 'idusuario']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avanceOrdenTrabajos');
    }
};
