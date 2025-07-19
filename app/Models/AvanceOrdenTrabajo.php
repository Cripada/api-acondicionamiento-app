<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvanceOrdenTrabajo extends Model
{
    use HasFactory;

    protected $table = 'avances_orden_trabajo';
    protected $primaryKey = 'idavance';
    protected $fillable = [
        'iddetalle',
        'idusuario',
        'tiempo',
        'fecha',
    ];

    // Relación con DetalleOrdenTrabajo
    public function detalle()
    {
        return $this->belongsTo(DetalleOrdenTrabajo::class, 'iddetalle');
    }

    // Relación con Usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'idusuario');
    }
}
