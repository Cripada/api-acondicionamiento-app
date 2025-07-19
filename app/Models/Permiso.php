<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    protected $table = 'permisos';
    protected $primaryKey = 'idpermiso';
    protected $fillable = ['nombre_tabla', 'descripcion', 'accion'];
    public $timestamps = true;

    // Relación muchos a muchos con roles
    public function roles()
    {
        return $this->belongsToMany(Rol::class, 'permiso_rol', 'idpermiso', 'idrol');
    }
}
