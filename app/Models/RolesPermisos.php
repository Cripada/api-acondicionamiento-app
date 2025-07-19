<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RolesPermisos extends Model
{
    protected $table = 'roles_permisos'; 
    protected $primaryKey = 'idrolpermiso'; 
    protected $fillable = ['idrol', 'idpermiso']; 
}
