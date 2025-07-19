<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleProforma extends Model
{
    protected $table = 'detalleProforma';
    protected $primaryKey = 'iddetalle';
    protected $fillable = [
        'idproforma',
        'idservicio',
        'descripcion',
        'cantidad',
        'precio',
        'urgente',
    ];
    public $timestamps = false;

    // Relación con Proforma
    public function proforma()
    {
        return $this->belongsTo(Proforma::class, 'idproforma');
    }
    // Relación con Servicio
    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'idservicio');
    }
}
