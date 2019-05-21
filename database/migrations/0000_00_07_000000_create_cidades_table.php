<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCidadesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (!Schema::hasTable('cidades')) {

            Schema::create('cidades', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('codigo_ibge');
                $table->string('nome', 150);
                $table->integer('estado_id')->unsigned();
            });
        }

        Schema::table('cidades', function ($table) {
            $table->foreign('estado_id')->references('id')->on('estados');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('cidades');
    }
}
