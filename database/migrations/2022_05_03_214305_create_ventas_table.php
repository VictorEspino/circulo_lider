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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->string('tipo');
            $table->foreignId('sucursal');
            $table->foreignId('ejecutivo');
            $table->date('fecha');
            $table->foreignId('plan');
            $table->float('renta');
            $table->integer('plazo');
            $table->string('propiedad');
            $table->string('imei')->nullable();
            $table->string('iccid')->nullable();
            $table->string('dn');
            $table->string('cliente');
            $table->string('co_id');
            $table->string('mail_cliente');
            $table->integer('addon_control')->default(0);
            $table->integer('seguro_proteccion')->default(0);
            $table->text('observaciones')->nullable();
            $table->foreignId('validador')->default(0);
            $table->integer('validado')->default(0);
            $table->integer('doc_completa')->default(0);
            $table->foreignID('cis_id')->default(0);
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
        Schema::dropIfExists('ventas');
    }
};
