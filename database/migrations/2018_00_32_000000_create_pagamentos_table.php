<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagamentosTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('pagamentos', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('taxa_adicional', 10, 2)->default(0.00);
            $table->enum('estorno', ['1', '0'])->default(0);
            $table->decimal('taxa_juros', 10, 2)->default(0.00);
            $table->decimal('multa_atraso', 10, 2)->default(0.00);
            $table->decimal('valor_pago', 10, 2)->default(0.00);
            $table->string('forma_pagamento')->default(0);

            $table->integer('pacote_cliente_id')->unsigned();
            $table->foreign('pacote_cliente_id')->references('id')->on('pacotes_cliente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('pagamentos');
    }
}
