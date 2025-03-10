<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table = 'empleados';
    protected $fillable = [
        'nombre',
        'apellidos',
        'sucursal_id',
        'puesto',
        'fecha_contratacion',
        'salario',
        'telefono',
        'email'
    ];

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'sucursal_id');
    }
}