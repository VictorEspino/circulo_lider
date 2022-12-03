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
        Schema::create('boletos_vendedors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ejecutivo');
            $table->foreignId('venta_id');
            $table->string('boleto1');
            $table->string('boleto2');
            $table->string('boleto3');
            $table->string('boleto4');
            $table->string('boleto5');
            $table->string('boleto6');
            $table->integer('etapa');
            $table->integer('objetivo')->default(0);
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
        Schema::dropIfExists('boletos_vendedors');
    }
};
