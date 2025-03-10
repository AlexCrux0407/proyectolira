<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('historial_cambios', function (Blueprint $table) {
            $table->id();
            $table->string('modelo_tipo'); // 'Sucursal', 'Empleado', etc.
            $table->unsignedBigInteger('modelo_id'); // ID del modelo
            $table->string('accion'); // 'crear', 'actualizar', 'eliminar'
            $table->string('campo')->nullable(); // Campo que cambió
            $table->text('valor_anterior')->nullable(); // Valor antes del cambio
            $table->text('valor_nuevo')->nullable(); // Valor después del cambio
            $table->unsignedBigInteger('usuario_id')->nullable(); // Usuario que hizo el cambio
            $table->timestamps();
            
            $table->index(['modelo_tipo', 'modelo_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('historial_cambios');
    }
};