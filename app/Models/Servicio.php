<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $table = 'servicios'; 
    protected $primaryKey = 'idservicio'; 
    protected $fillable = ['nombre', 'descripcion','produccionHora','estado']; 
    public $timestamps = true; 

    // Relación con Detalle PrecioServicios
    public function precioservicios()
    {
        return $this->hasMany(PrecioServicios::class, 'idservicio');
    }
}
