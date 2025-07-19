<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Parametro;

class ParametrosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
 public function run(): void
    {
        $parametros = [
            [
                'clave' => 'IVA',
                'valor' => '0.15',
                'descripcion' => 'Porcentaje de IVA aplicado a las proformas',
            ],
            [
                'clave' => 'Porcentaje de Urgencia',
                'valor' => '0.16',
                'descripcion' => 'Porcentaje adicional por urgencias',
            ],
            [
                'clave' => 'Horas Laborales',
                'valor' => '8',
                'descripcion' => 'Cantidad de horas laborables por día',
            ]
        ];

        foreach ($parametros as $parametro) {
            Parametro::updateOrCreate(['clave' => $parametro['clave']], $parametro);
        }
    }
}
