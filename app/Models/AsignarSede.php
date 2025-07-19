<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsignarSede extends Model
{
    use HasFactory;

    protected $table = 'asignarSedes'; // Nombre exacto de la tabla

    protected $primaryKey = 'idasignarsede';

    protected $fillable = [
        'idusuario',
        'idsede',
        'estado',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'idusuario');
    }

    public function sede()
    {
        return $this->belongsTo(Sede::class, 'idsede');
    }
}
