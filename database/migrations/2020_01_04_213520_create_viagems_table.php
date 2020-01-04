<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViagemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('viagems', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_unidade')->nullable(false);
            $table->integer('id_veiculo');
            $table->integer('id_motorista');
            $table->integer('cod_destino')->nullable(false);
            $table->date('data_viagem')->nullable(false);
            $table->time('hora_saida');
            $table->string('observacao', 240);
            $table->timestamps();

            $table->foreign('id_unidade')->references('id')->on('unidades');
            $table->foreign('cod_destino')->references('codigo')->on('municipios');
            $table->foreign('id_motorista')->references('id')->on('motoristas');
            $table->foreign('id_veiculo')->references('id')->on('veiculos');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('viagems');
    }
}
