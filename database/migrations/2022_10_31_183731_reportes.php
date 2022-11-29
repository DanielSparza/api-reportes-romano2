<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Reportes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('reportes', function (Blueprint $table) {
            $table->bigIncrements('clave_reporte');
            $table->bigInteger('fk_servicio')->unsigned();
            $table->text('problema');
            $table->integer('veces_reportado');
            $table->string('reporto', 100);
            $table->date('fecha_reporte');
            $table->time('hora_reporte');
            $table->enum('estatus', ['Pendiente', 'En proceso', 'Finalizado']);
            $table->bigInteger('fk_tecnico')->unsigned()->nullable();
            $table->date('fecha_finalizacion')->nullable();
            $table->time('hora_finalizacion')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
            $table->foreign('fk_servicio')->references('clave_servicio')->on('servicios');
            $table->foreign('fk_tecnico')->references('fk_clave_persona')->on('usuarios');
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
        Schema::dropIfExists('reportes');
    }
}
