<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Personas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('personas', function (Blueprint $table) {
            $table->bigIncrements('clave_persona');
            $table->string('nombre', 100);
            $table->bigInteger('fk_ciudad')->unsigned();
            $table->string('telefono_movil', 20);
            $table->boolean('estatus');
            $table->timestamps();
            $table->foreign('fk_ciudad')->references('clave_ciudad')->on('ciudades');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('personas');
    }
}
