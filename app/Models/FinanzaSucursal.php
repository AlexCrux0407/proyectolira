<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinanzaSucursal extends Model
{
    protected $table = 'finanzas_sucursales';
    
    protected $fillable = [
        'sucursal_id',
        'ingresos',
        'gastos',
        'ganancias',
        'fecha',
        'notas'
    ];

    protected $casts = [
        'fecha' => 'date',
        'ingresos' => 'decimal:2',
        'gastos' => 'decimal:2',
        'ganancias' => 'decimal:2'
    ];

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }


    public function map($finanza): array
{
    return [
        $finanza->sucursal_id,
        $finanza->sucursal ? $finanza->sucursal->nombre : 'Sucursal no encontrada',
        $finanza->fecha->format('d/m/Y'),
        number_format($finanza->ingresos, 2),
        $finanza->notas,
    ];
}
}