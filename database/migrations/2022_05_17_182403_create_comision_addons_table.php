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
        Schema::create('comision_addons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venta_id');
            $table->foreignId('calculo_id');
            $table->string('tipo');
            $table->float('comision_vendedor')->default(0);
            $table->float('comision_gerente')->default(0);
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
        Schema::dropIfExists('comision_addons');
    }
};
