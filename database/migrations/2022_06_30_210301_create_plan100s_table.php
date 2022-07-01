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
        Schema::create('plan100s', function (Blueprint $table) {
            $table->id();
            $table->integer('circulo');
            $table->foreignId('padre');
            $table->foreignId('user_id');
            $table->string('nombre_contacto')->nullable();
            $table->string('telefono')->nullable();
            $table->string('compañia')->nullable();
            $table->string('tipo_plan')->nullable();
            $table->string('gasto_mes')->nullable();
            $table->string('beneficios')->nullable();
            $table->string('equipo')->nullable();
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
        Schema::dropIfExists('plan100s');
    }
};
