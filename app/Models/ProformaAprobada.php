<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProformaAprobada extends Model
{
    protected $table = 'proformasAprobadas';
    protected $primaryKey = 'idaprobada';
    protected $fillable = ['idproforma','idusuario', 'idsede','fechaAutorizacion','comentario'];
    public $timestamps = false;

    // Relación con Sede
    public function sede()
    {
        return $this->belongsTo(Sede::class, 'idsede');
    }
    // Relación con Usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'idusuario');
    }
        // Relación con Sede
    public function proforma()
    {
        return $this->belongsTo(Proforma::class, 'idproforma');
    }
   
}
