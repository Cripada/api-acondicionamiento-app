<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes'; 
    protected $primaryKey = 'idcliente'; 
    protected $fillable = ['ruc_cedula', 'nombre_comercial', 'direccion', 'telefono', 'email',  'estado']; 
    public $timestamps = true; 

    public function proformas()
    {
        return $this->hasMany(Proforma::class, 'idcliente');
    }
}
