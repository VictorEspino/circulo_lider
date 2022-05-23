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
        Schema::create('pagos_vendedors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('calculo_id');
            $table->foreignId('user_id');
            $table->float('comisiones');
            $table->float('bono_rentas');
            $table->float('total_pago');
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
        Schema::dropIfExists('pagos_vendedors');
    }
};
