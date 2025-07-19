<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parametro extends Model
{
    protected $table = 'parametros';
    protected $primaryKey = 'idparametro';
    public $timestamps = false;
    protected $fillable = ['clave', 'valor', 'descripcion'];

    /**
     * Obtener el valor de un parámetro por su clave.
     */
    public static function obtener(string $clave, $default = null): ?string
    {
        return static::where('clave', $clave)->value('valor') ?? $default;
    }
}
