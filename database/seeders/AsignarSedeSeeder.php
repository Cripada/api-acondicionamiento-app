<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\AsignarSede;

class AsignarSedeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $asignarSedes = [
            [
                'idusuario' => 1,
                'idsede' => 1,
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idusuario' => 1,
                'idsede' => 2,
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idusuario' => 2,
                'idsede' => 1,
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idusuario' => 2,
                'idsede' => 2,
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($asignarSedes as $asignarSede) {
            AsignarSede::updateOrCreate($asignarSede);
        }
    }
}
