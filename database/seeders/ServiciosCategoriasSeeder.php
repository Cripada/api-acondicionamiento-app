<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ServiciosCategoria;

class ServiciosCategoriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $serviciosCategorias = [
            [
                'nombre' => 'Acondicionamiento',
                'descripcion' => 'Preparación, acondicionamiento y embalaje de productos para su transporte o almacenamiento.',
                'estado' => '1',
            ],
            [
                'nombre' => 'Personal',
                'descripcion' => 'Personal que asiste en tareas logísticas como carga, descarga, entrega y control de mercancías durante el transporte.',
                'estado' => '1',
            ],
            [
                'nombre' => 'Horas Extras',
                'descripcion' => 'Tiempo trabajado fuera de la jornada laboral regular, sujeto a compensación adicional.',
                'estado' => '1',
            ],
            [
                'nombre' => 'Estibaje',
                'descripcion' => 'Proceso de carga, descarga y organización de mercancías en vehículos o almacenes.',
                'estado' => '1',
            ],
            [
                'nombre' => 'Bienes',
                'descripcion' => 'Recursos físicos o materiales vendidos sin modificación.',
                'estado' => '1',
            ],
        ];

        foreach ($serviciosCategorias as $serviciosCategoria) {
            ServiciosCategoria::updateOrCreate($serviciosCategoria);
        }
    }
}
