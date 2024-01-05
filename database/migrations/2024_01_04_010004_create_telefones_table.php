<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTelefonesTable extends Migration {
    public function up() {
        Schema::create('telefones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_create_id')->nullable();
            $table->unsignedBigInteger('user_update_id')->nullable();
            $table->unsignedBigInteger('user_delete_id')->nullable();
            $table->unsignedBigInteger('tipo_id');
            $table->unsignedBigInteger('cliente_id');
            $table->string('numero', 20);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_create_id')->references('id')->on('users');
            $table->foreign('user_update_id')->references('id')->on('users');
            $table->foreign('user_delete_id')->references('id')->on('users');
            $table->foreign('tipo_id')->references('id')->on('tipos');
            $table->foreign('cliente_id')->references('id')->on('clientes');
        });
    }

    public function down() {
        Schema::table('telefones', function (Blueprint $table) {
            $table->dropForeign(['user_create_id']);
            $table->dropForeign(['user_update_id']);
            $table->dropForeign(['user_delete_id']);
            $table->dropForeign(['tipo_id']);
            $table->dropForeign(['cliente_id']);
        });

        Schema::dropIfExists('telefones');
    }    
}
