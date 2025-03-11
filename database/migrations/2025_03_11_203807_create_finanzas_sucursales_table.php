<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('finanzas_sucursales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sucursal_id');
            $table->decimal('ingresos', 10, 2)->default(0);
            $table->decimal('gastos', 10, 2)->default(0);
            $table->decimal('ganancias', 10, 2)->default(0);
            $table->date('fecha');
            $table->text('notas')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('finanzas_sucursales');
    }
};