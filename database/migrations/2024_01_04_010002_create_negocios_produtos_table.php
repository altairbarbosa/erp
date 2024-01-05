<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNegociosProdutosTable extends Migration {
    public function up() {
        Schema::create('negocios_produtos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_create_id')->nullable();
            $table->unsignedBigInteger('user_update_id')->nullable();
            $table->unsignedBigInteger('user_delete_id')->nullable();
            $table->unsignedBigInteger('negocio_id');
            $table->unsignedBigInteger('produto_id');
            $table->integer('quantidade');
            $table->timestamps();
            $table->softDeletes();
    
            $table->foreign('user_create_id')->references('id')->on('users');
            $table->foreign('user_update_id')->references('id')->on('users');
            $table->foreign('user_delete_id')->references('id')->on('users');
            $table->foreign('negocio_id')->references('id')->on('negocios');
            $table->foreign('produto_id')->references('id')->on('produtos');
        });
    }
    
    public function down() {
        Schema::table('negocios_produtos', function (Blueprint $table) {
            $table->dropForeign(['user_create_id']);
            $table->dropForeign(['user_update_id']);
            $table->dropForeign(['user_delete_id']);
            $table->dropColumn(['user_create_id', 'user_update_id', 'user_delete_id']);
        });
    
        Schema::dropIfExists('negocios_produtos');
    }    
}
