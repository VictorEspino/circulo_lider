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
        Schema::create('cis_renovacions', function (Blueprint $table) {
            $table->id();
            $table->string('no_contrato_impreso');
            $table->string('id_orden_renovacion')->nullable();
            $table->string('cuenta_cliente')->nullable();
            $table->string('status_renovacion')->nullable();
            $table->date('fecha_status')->nullable();
            $table->string('id_ejecutivo')->nullable();
            $table->string('nombre_ejecutivo')->nullable();
            $table->string('co_id')->nullable();
            $table->date('fecha_activacion_contrato')->nullable();
            $table->string('new_sim')->nullable();
            $table->string('modelo_nuevo')->nullable();
            $table->string('plan_actual')->nullable();
            $table->string('renta_actual')->nullable();
            $table->string('plazo_actual')->nullable();
            $table->string('dn_actual')->nullable();
            $table->string('propiedad')->nullable();
            $table->string('carga_id');
            $table->foreignId('user_id');
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
        Schema::dropIfExists('cis_renovacions');
    }
};
