<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facturacion extends Model
{
    use HasFactory;

    protected $table = 'facturacion';
    protected $primaryKey = 'idfacturacion';

    protected $fillable = [
        'idproforma',
        'idusuario',
        'fechaFactura',
        'numeroFactura',
        'comentario',
    ];

    // Relaciones
    public function proforma()
    {
        return $this->belongsTo(Proforma::class, 'idproforma');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'idusuario');
    }
}
