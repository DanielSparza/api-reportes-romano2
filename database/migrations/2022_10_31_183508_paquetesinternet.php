<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Paquetesinternet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('paquetesinternet', function (Blueprint $table) {
            $table->bigIncrements('clave_paquete');
            $table->string('velocidad', 10);
            $table->double('costo');
            $table->string('periodo', 20);
            $table->text('descripcion')->nullable();
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
        //
        Schema::dropIfExists('paquetesinternet');
    }
}
