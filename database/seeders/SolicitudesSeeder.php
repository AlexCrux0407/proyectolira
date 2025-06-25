<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Solicitud;

class SolicitudesSeeder extends Seeder
{
    public function run()
    {
        $solicitudes = [
            [
                'nombre_solicitante' => 'Juan Pérez',
                'vacante_id' => 1,
                'fecha_solicitud' => '2025-05-10',
                'estado' => 'En revisión',
                'email' => 'juan.perez@example.com',
                'telefono' => '5551234567'
            ],
            [
                'nombre_solicitante' => 'María González',
                'vacante_id' => 2,
                'fecha_solicitud' => '2025-05-12',
                'estado' => 'En revisión',
                'email' => 'maria.gonzalez@example.com',
                'telefono' => '5557654321'
            ],
            [
                'nombre_solicitante' => 'Carlos López',
                'vacante_id' => 3,
                'fecha_solicitud' => '2025-05-15',
                'estado' => 'En revisión',
                'email' => 'carlos.lopez@example.com',
                'telefono' => '5559876543'
            ]
        ];

        foreach ($solicitudes as $solicitud) {
            Solicitud::create($solicitud);
        }
    }
}