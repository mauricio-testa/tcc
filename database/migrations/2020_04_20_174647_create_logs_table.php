<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_user');
            $table->string('context', 240)->nullable();
            $table->unsignedInteger('context_id')->nullable();
            $table->enum('level', ['CRUD', 'INFO', 'WARNING', 'EXCEPTION'])->default('INFO');
            $table->enum('action', ['INSERT', 'UPDATE', 'DELETE', 'EXPORT'])->nullable();
            $table->text('message');
            $table->json('payload')->nullable();            
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logs');
    }
}
