<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vacante;

class VacantesSeeder extends Seeder
{
    public function run()
    {
        $vacantes = [
            [
                'nombre' => 'Gerente de Restaurante',
                'area_laboral' => 'Administración',
                'descripcion' => 'Encargado de la operación diaria del restaurante y gestión del personal.',
                'estado' => 'Disponible',
                'fecha_limite' => '2025-06-30'
            ],
            [
                'nombre' => 'Chef Ejecutivo',
                'area_laboral' => 'Cocina',
                'descripcion' => 'Responsable de crear menús y supervisar la preparación de alimentos.',
                'estado' => 'Disponible',
                'fecha_limite' => '2025-07-15'
            ],
            [
                'nombre' => 'Mesero',
                'area_laboral' => 'Servicio',
                'descripcion' => 'Atención al cliente y servicio de alimentos en el restaurante.',
                'estado' => 'Disponible',
                'fecha_limite' => '2025-06-15'
            ]
        ];

        foreach ($vacantes as $vacante) {
            Vacante::create($vacante);
        }
    }
}