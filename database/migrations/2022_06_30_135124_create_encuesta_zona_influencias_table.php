<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('encuesta_zona_influencias', function (Blueprint $table) {
            $table->id();
            $table->string('empleado');
            $table->string('nombre');
            $table->integer('udn');
            $table->string('pdv');
            $table->string('region');
            $table->string('nombre_contacto');
            $table->string('telefono');
            $table->string('compañia');
            $table->string('tipo_plan');
            $table->string('gasto_mes');
            $table->string('beneficios');
            $table->string('equipo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('encuesta_zona_influencias');
    }
};
