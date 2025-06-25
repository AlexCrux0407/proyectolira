<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class HumanResourcesSeeder extends Seeder
{
    public function run()
    {
        // Vacantes (Job Vacancies)
        DB::table('human_resources')->insert([
            [
                'task_name' => 'Desarrollador Backend',
                'description' => 'Buscamos un desarrollador backend con experiencia en Laravel y APIs REST.',
                'assigned_to' => null,
                'status' => 'Abierta',
                'due_date' => Carbon::now()->addDays(30),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'task_name' => 'Diseñador Gráfico',
                'description' => 'Se requiere diseñador gráfico para crear material publicitario y digital.',
                'assigned_to' => null,
                'status' => 'Abierta',
                'due_date' => Carbon::now()->addDays(45),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        // Solicitudes (Applications) - assuming stored in the same table with status 'Solicitud'
        DB::table('human_resources')->insert([
            [
                'task_name' => 'Solicitud para Desarrollador Backend',
                'description' => 'Juan Pérez ha enviado su solicitud para la vacante de Desarrollador Backend.',
                'assigned_to' => 'Juan Pérez',
                'status' => 'En revisión',
                'due_date' => null,
                'created_at' => Carbon::now()->subDays(5),
                'updated_at' => Carbon::now()->subDays(2),
            ],
            [
                'task_name' => 'Solicitud para Diseñador Gráfico',
                'description' => 'María López ha enviado su solicitud para la vacante de Diseñador Gráfico.',
                'assigned_to' => 'María López',
                'status' => 'Pendiente',
                'due_date' => null,
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDay(),
            ],
        ]);
    }
}