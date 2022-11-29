<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Datosempresa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('datosempresa', function (Blueprint $table) {
            $table->bigIncrements('clave_empresa');
            $table->string('nombre', 50);
            $table->string('eslogan', 80)->nullable();
            $table->string('logo', 100);
            $table->string('imagen_fondo', 100);
            $table->text('sobre_nosotros');
            $table->string('direccion', 100);
            $table->string('ciudad', 100);
            $table->string('telefono', 20);
            $table->string('correo', 100)->nullable();
            $table->string('facebook', 200)->nullable();
            $table->string('whatsapp', 50)->nullable();
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
        Schema::dropIfExists('datosempresa');
    }
}
