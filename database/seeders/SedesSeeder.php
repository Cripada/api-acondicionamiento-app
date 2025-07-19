<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sede;

class SedesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
 public function run(): void
    {
        $sedes = [
            [
                'nombre' => 'Quito',
                'ubicacion' => 'Panamericana Norte km 12.5 y el Arenal',
                'num_sucursal'=>'001',
                'num_actual_ot'=>0,
                'num_actual_proforma'=>0,
                'estado' => '1',
            ],
            [
                'nombre' => 'Guayaquil',
                'ubicacion' => 'Via Daule Kilometro 14 1/2',
                'num_sucursal'=>'002',
                'num_actual_ot'=>0,
                'num_actual_proforma'=>0,
                'estado' => '1',
            ]
        ];

        foreach ($sedes as $sede) {
            Sede::updateOrCreate($sede);
        }
    }
}
