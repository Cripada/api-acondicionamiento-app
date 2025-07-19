<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetalleOrdenTrabajo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'detalleOrdenTrabajo';
    protected $primaryKey = 'iddetalle';
    protected $fillable = [
        'idorden',
        'idservicio',
        'descripcion',
        'cantidad',
        'produccionHora',
        'observacion',
        'avance',
        'estado',
    ];

    // Relación con OrdenTrabajo
    public function orden()
    {
        return $this->belongsTo(OrdenTrabajo::class, 'idorden');
    }

    // Relación con Servicio
    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'idservicio');
    }

    // Relación con avances
    public function avances()
    {
        return $this->hasMany(AvanceOrdenTrabajo::class, 'iddetalle');
    }
}
