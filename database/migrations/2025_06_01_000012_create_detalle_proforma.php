<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detalleProforma', function (Blueprint $table) {
            $table->bigIncrements('iddetalle');
            $table->integer('idproforma');
            $table->integer('idservicio');
            $table->string('descripcion');
            $table->decimal('cantidad');
            $table->decimal('precio');
            $table->boolean('urgente');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalleProforma');
    }
};
