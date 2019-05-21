<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContasReceberPagarsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('contas_receber_pagar', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pessoa_id')->unsigned();
            $table->integer('vendedor_id')->unsigned();
            $table->string('titulo')->index();
            $table->date('data_emissao');
            $table->decimal('vlr_total', 10, 2)->default(0.00);
            $table->decimal('vlr_restante', 10, 2)->default(0.00);
            $table->decimal('taxa_juros', 10, 2)->default(0.00);
            $table->decimal('taxa_adicional', 10, 2)->default(0.00);
            $table->integer('qtd_parcelas');
            $table->integer('qtd_dias');
            $table->string('observacao');
            $table->char('tipo_operacao', 1); //P ou R);
            $table->string('tipo_documento'); //CHEQUE, TITULO, BOLETO
            $table->integer('pagamento_id')->unsigned()->nullable();
            $table->foreign('pagamento_id')->references('id')->on('pagamentos')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::table('contas_receber_pagar', function ($table) {
            $table->foreign('pessoa_id')->references('id')->on('pessoas');
            $table->foreign('vendedor_id')->references('id')->on('pessoas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('contas_receber_pagar');
    }
}
