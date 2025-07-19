<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sede extends Model
{
    protected $table = 'sedes'; 
    protected $primaryKey = 'idsede'; 
    protected $fillable = ['nombre', 'ubicacion','num_sucursal','num_actual_ot','num_actual_proforma','estado']; 
    public $timestamps = true; 
}
