<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class serviciosCategoria extends Model
{
    protected $table = 'serviciosCategorias';
    protected $primaryKey = 'idcategoria';
    protected $fillable = ['nombre', 'descripcion', 'estado'];
    public $timestamps = true;

    // Relación con Servicios
    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'idservicio');
    }
}
