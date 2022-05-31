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
        Schema::create('cis_pospagos', function (Blueprint $table) {
            $table->id();
            $table->string('no_contrato_impreso');
            $table->string('id_orden_contratacion')->nullable();
            $table->date('fecha_contratacion')->nullable();
            $table->string('cuenta_cliente')->nullable();
            $table->string('nombre_cliente')->nullable();
            $table->string('tipo_venta')->nullable();
            $table->string('status_orden')->nullable();
            $table->date('fecha_status_orden')->nullable();
            $table->string('nombre_pdv_unico')->nullable();
            $table->string('cve_unica_ejecutivo')->nullable();
            $table->string('nombre_ejecutivo_unico')->nullable();
            $table->string('id_contrato')->nullable();
            $table->string('mdn_inicial')->nullable();
            $table->string('propiedad')->nullable();
            $table->string('mdn_actual')->nullable();
            $table->string('sim')->nullable();
            $table->string('imei')->nullable();
            $table->string('plan_tarifario_homo')->nullable();
            $table->string('plazo_forzoso')->nullable();
            $table->string('nva_renta')->nullable();
            $table->string('mdn_definitivo')->nullable();
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
        Schema::dropIfExists('cis_pospagos');
    }
};
