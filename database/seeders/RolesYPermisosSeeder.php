<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Rol;
use App\Models\Permiso;

class RolesYPermisosSeeder extends Seeder
{
    public function run(): void
    {
        // Limpiar tablas
        DB::table('permiso_rol')->truncate();
        DB::statement('DELETE FROM permisos');
        DB::statement('DELETE FROM roles');

        // Crear roles
        $roles = [
            'Super Usuario' => Rol::create(['nombre' => 'Super Usuario', 'descripcion' => 'Acceso total al sistema']),
            'Administrador' => Rol::create(['nombre' => 'Administrador', 'descripcion' => 'Administra usuarios y configuraciones']),
            'Servicio Al Cliente' => Rol::create(['nombre' => 'Servicio Al Cliente', 'descripcion' => 'Atiende al cliente']),
            'Personal Externo' => Rol::create(['nombre' => 'Personal Externo', 'descripcion' => 'Acceso restringido externo']),
            'Bodeguero' => Rol::create(['nombre' => 'Bodeguero', 'descripcion' => 'Gestiona bodega']),
            'Jefe De Operaciones' => Rol::create(['nombre' => 'Jefe De Operaciones', 'descripcion' => 'Coordina las operaciones']),
            'Supervisor' => Rol::create(['nombre' => 'Supervisor', 'descripcion' => 'Supervisor de las operaciones']),
        ];

        // Tablas y acciones base
        $tablas = [
            'clientes' => 'Clientes',
            'facturacion' => 'Facturación',
            'tipoFacturacion' => 'Tipo de Facturación',
            'servicios' => 'Servicios',
            'serviciosCategorias' => 'Servicios Categorias',
            'sedes' => 'Sedes',
            'users' => 'Usuarios',
            'roles' => 'Roles',
            'asignarSedes' => 'Asignar Sedes',
        ];

        $accionesGenerales = ['Ver listado', 'Crear', 'Editar'];

        // Array para guardar permisos creados
        $permisos = [];

        // Crear permisos generales
        foreach ($tablas as $clave => $nombreTabla) {
            foreach ($accionesGenerales as $accion) {
                $permiso = Permiso::create([
                    'nombre_tabla' => $clave,
                    'accion' => $accion,
                    'descripcion' => $nombreTabla,
                ]);
                $permisos["{$clave}_{$accion}"] = $permiso;
            }
        }

        // Configuración específica por módulo
        $modulosExtras = [
            'proformas' => [
                'descripcion' => 'Proformas',
                'acciones' => ['Ver listado', 'Crear', 'Actualizar', 'Ver PDF', 'Descargar PDF'],
            ],
            'parametros' => [
                'descripcion' => 'Parámetros',
                'acciones' => ['Ver listado', 'Editar'],
            ],
            'permisos' => [
                'descripcion' => 'Permisos',
                'acciones' => ['Ver listado', 'Editar'],
            ],
            'precioServicios' => [
                'descripcion' => 'Precios de Servicios',
                'acciones' => ['Ver listado', 'Crear','Editar','Eliminar'],
            ],
        ];

        // Crear permisos para módulos extra
        foreach ($modulosExtras as $clave => $config) {
            foreach ($config['acciones'] as $accion) {
                $permiso = Permiso::create([
                    'nombre_tabla' => $clave,
                    'accion' => $accion,
                    'descripcion' => $config['descripcion'],
                ]);
                $permisos["{$clave}_{$accion}"] = $permiso;
            }
        }

        // Asignar todos los permisos al rol superUsuario
        $roles['Super Usuario']->permisos()->attach(collect($permisos)->pluck('idpermiso')->toArray());

        // Asignar permisos específicos a otros roles
        $verPermisos = collect($permisos)->filter(fn($p, $k) => str_ends_with($k, '_ver'))->pluck('idpermiso')->toArray();
        $crearPermisos = collect($permisos)->filter(fn($p, $k) => str_ends_with($k, '_crear'))->pluck('idpermiso')->toArray();
        $editarPermisos = collect($permisos)->filter(fn($p, $k) => str_ends_with($k, '_editar'))->pluck('idpermiso')->toArray();

        $roles['Administrador']->permisos()->attach(array_merge($verPermisos, $crearPermisos, $editarPermisos));
        $roles['Servicio Al Cliente']->permisos()->attach(array_merge($verPermisos, $crearPermisos, $editarPermisos));
        $roles['Personal Externo']->permisos()->attach(array_merge($verPermisos, $crearPermisos));

        // Permisos específicos para bodeguero, supervisor y jefe de operaciones
        $roles['Supervisor']->permisos()->attach($verPermisos);
        $roles['Bodeguero']->permisos()->attach(array_merge($verPermisos, $crearPermisos));
        $roles['Jefe De Operaciones']->permisos()->attach(array_merge($verPermisos, $crearPermisos, $editarPermisos));
    }
}
