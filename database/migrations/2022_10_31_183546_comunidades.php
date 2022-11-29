<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Comunidades extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('comunidades', function (Blueprint $table) {
            $table->bigIncrements('clave_comunidad');
            $table->string('comunidad', 100);
            $table->bigInteger('fk_ciudad')->unsigned();
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
        Schema::dropIfExists('comunidades');
    }
}
