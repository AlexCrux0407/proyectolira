<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ventas_productos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sucursal_id');
            $table->foreignId('producto_id')->constrained()->onDelete('cascade');
            $table->integer('cantidad');
            $table->decimal('precio_unitario', 10, 2);
            $table->decimal('total', 10, 2);
            $table->date('fecha_venta');
            $table->timestamps();

            // Especificar explícitamente el nombre de la tabla
            $table->foreign('sucursal_id')
                  ->references('id')
                  ->on('sucursales')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ventas_productos');
    }
};