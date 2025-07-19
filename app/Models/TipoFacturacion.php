<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoFacturacion extends Model
{
    protected $table = 'tipoFacturacion'; 
    protected $primaryKey = 'idTipoFacturacion'; 
    protected $fillable = ['nombre', 'descripcion', 'estado']; 
    public $timestamps = true; 

    public function proformas()
    {
        return $this->hasMany(Proforma::class, 'idTipoFacturacion');
    }
}
