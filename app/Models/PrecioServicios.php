<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrecioServicios extends Model
{
    protected $table = 'precioServicios'; 
    protected $primaryKey = 'idprecioservicio'; 
    protected $fillable = ['idservicio', 'rangouno','rangodos','valor','estado']; 
    public $timestamps = true; 

    // Relación con Servicio
    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'idservicio');
    }
}
