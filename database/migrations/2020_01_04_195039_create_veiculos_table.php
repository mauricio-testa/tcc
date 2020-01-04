<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVeiculosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('veiculos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_unidade')->nullable(false);
            $table->string('descricao', 240)->nullable(false);
            $table->string('placa', 10)->nullable(false);
            $table->integer('lotacao')->nullable(false);
            $table->enum('tipo', ['PROPRIO', 'TERCEIRIZADO'])->default('PROPRIO');
            $table->string('ano_modelo', 9);
            $table->string('marca_modelo', 45);
            $table->timestamps();

            $table->foreign('id_unidade')->references('id')->on('unidades');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('veiculos');
    }
}
