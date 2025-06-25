<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
        'responsable'
    ];

    // Define any relationships here if needed
}