<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('servicios', function (Blueprint $table) {
            $table->bigIncrements('idservicio');
            $table->unsignedBigInteger('idcategoria');
            $table->string('nombre');
            $table->string('descripcion');
            $table->decimal('produccionHora', 8, 2);
            $table->boolean('estado');
            $table->timestamps();

            $table->index('nombre');
            $table->index('descripcion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicios');
    }
};
