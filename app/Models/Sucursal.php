<?php

namespace App\Models;

use App\Traits\RegistraCambios;
use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    use RegistraCambios;

    protected $table = 'sucursales';
    protected $fillable = [
        'nombre',
        'direccion',
        'telefono',
        'encargado',
        'horario_apertura',
        'horario_cierre'
    ];

    public function empleados()
    {
        return $this->hasMany(Empleado::class, 'sucursal_id');
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'sucursal_id');
    }

    // En app/Models/Sucursal.php
    public function finanzas()
    {
        return $this->hasMany(FinanzaSucursal::class, 'sucursal_id');
    }















}