<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePacientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('rg', 10, 0);
            $table->string('nome', 240)->nullable(false);
            $table->string('telefone', 15);
            $table->string('endereco', 240);
            $table->unsignedInteger('id_unidade');
            $table->integer('codigo_municipio')->nullable(false);
            $table->timestamps();

            $table->foreign('id_unidade')->references('id')->on('unidades');
            $table->foreign('codigo_municipio')->references('codigo')->on('municipios');

            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pacientes');
    }
}
