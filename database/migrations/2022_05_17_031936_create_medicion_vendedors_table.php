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
        Schema::create('medicion_vendedors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('calculo_id');
            $table->integer('ventas');
            $table->integer('rentas');
            $table->integer('bracket_ventas')->default(0);
            $table->integer('bracket_rentas')->default(0);
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
        Schema::dropIfExists('medicion_vendedors');
    }
};
