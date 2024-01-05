<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnderecosTable extends Migration
{
    public function up()
    {
        Schema::create('enderecos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('logradouro');
            $table->string('numero');
            $table->string('bairro');
            $table->string('cidade');
            $table->string('estado');
            $table->string('pais');
            $table->string('cep');
            $table->unsignedBigInteger('user_create_id')->nullable();
            $table->unsignedBigInteger('user_update_id')->nullable();
            $table->unsignedBigInteger('user_delete_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_create_id')->references('id')->on('users');
            $table->foreign('user_update_id')->references('id')->on('users');
            $table->foreign('user_delete_id')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::table('enderecos', function (Blueprint $table) {
            $table->dropForeign(['user_create_id']);
            $table->dropForeign(['user_update_id']);
            $table->dropForeign(['user_delete_id']);
        });

        Schema::dropIfExists('enderecos');
    }
}
