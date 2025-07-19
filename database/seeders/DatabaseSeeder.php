<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        /*User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);*/
        $this->call([
            RolesYPermisosSeeder::class,
            UsuariosSeeder::class,
            ServicioSeeder::class,
            TipoFacturacionSeeder::class,
            ClienteSeeder::class,
            ParametrosSeeder::class,
            SedesSeeder::class,
            AsignarSedeSeeder::class,
            ServiciosCategoriasSeeder::class
        ]);
    }
}
