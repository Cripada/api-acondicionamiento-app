<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoFacturacionSeeder extends Seeder
{
    public function run()
    {
        DB::table('tipoFacturacion')->insert([
            [
                'nombre' => 'A FINAL DEL MES',
                'descripcion' => 'Facturación que se emite al finalizar el mes, agrupando todos los servicios realizados.',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'AL FINALIZAR EL TRABAJO',
                'descripcion' => 'Facturación que se genera inmediatamente después de completado el trabajo.',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'ANTICIPADA AL TRABAJO',
                'descripcion' => 'Facturación que se emite antes de iniciar el trabajo, normalmente para anticipos.',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
