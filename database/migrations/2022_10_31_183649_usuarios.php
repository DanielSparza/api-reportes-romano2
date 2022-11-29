<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Usuarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('usuarios', function (Blueprint $table) {
            $table->bigIncrements('fk_clave_persona');
            $table->string('usuario', 20)->unique();
            $table->string('email', 50)->unique();
            $table->bigInteger('fk_rol')->unsigned();
            $table->string('password', 255);
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('fk_clave_persona')->references('clave_persona')->on('personas');
            $table->foreign('fk_rol')->references('clave_rol')->on('roles');
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
        Schema::dropIfExists('usuarios');
    }
}
