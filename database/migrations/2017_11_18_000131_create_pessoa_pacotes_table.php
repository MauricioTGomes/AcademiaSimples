<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePessoaPacotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pacotes_cliente', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal("vlr_total", 10, 2)->default(0.00);
            $table->decimal("vlr_desconto", 10, 2)->default(0.00);
            $table->integer('pessoa_id')->unsigned();
            $table->foreign('pessoa_id')->references('id')->on('pessoas');
            $table->integer('pacote_id')->unsigned();
            $table->foreign('pacote_id')->references('id')->on('pacotes');
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
        Schema::dropIfExists('pacotes_cliente');
    }
}
