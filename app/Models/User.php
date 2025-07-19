<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nombre', 'apellido', 'correo', 'telefono', 'password', 'estado', 'idrol', 'foto'];

    public $timestamps = true;

    //Relación con Responsables Ot
    public function ordenesTrabajo()
    {
        return $this->belongsToMany(OrdenTrabajo::class, 'ordenTrabajoUsuario', 'idusuario', 'idorden')
            ->withPivot('tiempo_asignado', 'observaciones')
            ->withTimestamps();
    }

    // Relación con Rol (asumiendo que cada usuario tiene un solo rol)
    public function rol()
    {
        return $this->belongsTo(Rol::class, 'idrol', 'idrol');
    }

    public function getAuthIdentifierName()
    {
        return 'correo';
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
