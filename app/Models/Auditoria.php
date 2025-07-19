<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Auditoria extends Model
{
    protected $table = 'auditorias'; 
    protected $primaryKey = 'idauditoria'; 
    protected $fillable = [
        'tablaafectada', 
        'operacion', 
        'idregistro',
        'tablaafectada', 
        'datosprevios', 
        'datosnuevos',
        'usuario', 
        'direccionip'
    ]; 
    public $timestamps = true; 
}
