<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEstadosTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        Schema::create('estados', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('nome', 150);
            $table->integer('pais_id')->unsigned();
            $table->char('uf', 2);
            $table->integer('posicao_lista_icms');
            $table->json('lista_icms');
            $table->integer('codigo_estado');
        });

        Schema::table('estados', function ($table) {
            $table->foreign('pais_id')->references('id')->on('paises');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('estados');
    }
}
