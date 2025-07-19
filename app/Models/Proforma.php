<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proforma extends Model
{
    protected $table = 'proformas';
    protected $primaryKey = 'idproforma';
    protected $fillable = ['num_proforma','num_ot','num_actualizacion','idusuario', 'idsede','idcliente', 'fechaEmision', 'fechaEstimadaInicio', 'fechaEstimadaFinalizacion', 'horasEstimadas', 'correo', 'comentario', 'solicitante', 'idTipoFacturacion',  'status'];

    public $timestamps = true;

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
    // Relación con Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'idcliente');
    }
    // Relación con Tipo Facturacion
    public function tipoFacturacion()
    {
        return $this->belongsTo(TipoFacturacion::class, 'idTipoFacturacion');
    }
    // Relación con Detalle Proforma
    public function detalles()
    {
        return $this->hasMany(DetalleProforma::class, 'idproforma');
    }
}
