<?php

namespace App\Traits;

use App\Models\HistorialCambio;

trait RegistraCambios
{
    // Hook para cuando el modelo es creado
    protected static function booted()
    {
        parent::booted();

        // Cuando se crea un modelo
        static::created(function ($modelo) {
            HistorialCambio::create([
                'modelo_tipo' => get_class($modelo),
                'modelo_id' => $modelo->id,
                'accion' => 'crear',
                'valor_nuevo' => json_encode($modelo->toArray()),
                'usuario_id' => auth()->id()
            ]);
        });

        // Cuando se actualiza un modelo
        static::updated(function ($modelo) {
            $cambios = $modelo->getDirty();
            $original = $modelo->getOriginal();
            
            foreach ($cambios as $campo => $nuevoValor) {
                if (in_array($campo, ['created_at', 'updated_at'])) continue;
                
                HistorialCambio::create([
                    'modelo_tipo' => get_class($modelo),
                    'modelo_id' => $modelo->id,
                    'accion' => 'actualizar',
                    'campo' => $campo,
                    'valor_anterior' => isset($original[$campo]) ? $original[$campo] : null,
                    'valor_nuevo' => $nuevoValor,
                    'usuario_id' => auth()->id()
                ]);
            }
        });

        // Cuando se elimina un modelo
        static::deleted(function ($modelo) {
            HistorialCambio::create([
                'modelo_tipo' => get_class($modelo),
                'modelo_id' => $modelo->id,
                'accion' => 'eliminar',
                'valor_anterior' => json_encode($modelo->toArray()),
                'usuario_id' => auth()->id()
            ]);
        });
    }
}