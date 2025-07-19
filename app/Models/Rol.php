<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'idrol';
    protected $fillable = ['nombre', 'descripcion'];
    public $timestamps = true;

public function permisos()
{
    return $this->belongsToMany(Permiso::class, 'permiso_rol', 'idrol', 'idpermiso');
}

    // Relación con Rol (asumiendo que cada usuario tiene un solo rol)
    public function rol()
    {
        return $this->belongsTo(Cliente::class, 'idrol', 'idrol');
    }
}
