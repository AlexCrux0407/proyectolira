<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistorialCambio extends Model
{
    protected $table = 'historial_cambios';
    
    protected $fillable = [
        'modelo_tipo',
        'modelo_id',
        'accion',
        'campo',
        'valor_anterior',
        'valor_nuevo',
        'usuario_id'
    ];

    // Relación con el modelo relacionado (polimórfica)
    public function modelo()
    {
        return $this->morphTo('modelo', 'modelo_tipo', 'modelo_id');
    }
}