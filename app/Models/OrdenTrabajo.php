<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenTrabajo extends Model
{
    use HasFactory;

    protected $table = 'ordenesTrabajo';
    protected $primaryKey = 'idorden';
    protected $fillable = [
        'idproforma',
        'num_ot',
        'fecha_inicio',
        'fecha_fin',
        'idusuario_responsable',
        'estado',
        'prioridad',
        'comentario',
        'avance_general',
        'aprobada',
        'fecha_aprobacion',
        'idusuario_aprueba',
    ];


    // Relación con Responsables(Usuarios)
    public function responsables()
    {
        return $this->belongsToMany(User::class, 'ordenTrabajoUsuario', 'idorden', 'idusuario')->withPivot('tiempo_asignado', 'observaciones')->withTimestamps();
    }

    // Relación con Proforma
    public function proforma()
    {
        return $this->belongsTo(Proforma::class, 'idproforma');
    }

    // Relación con Detalles de Orden
    public function detalles()
    {
        return $this->hasMany(DetalleOrdenTrabajo::class, 'idorden');
    }

    // Avances generales por la orden
    public function avances()
    {
        return $this->hasManyThrough(AvanceOrdenTrabajo::class, DetalleOrdenTrabajo::class, 'idorden', 'iddetalle', 'idorden', 'iddetalle');
    }

    /**
     * Relación con Usuario que aprueba
     */
    public function usuarioAprueba()
    {
        return $this->belongsTo(User::class, 'idusuario_aprueba');
    }
}
