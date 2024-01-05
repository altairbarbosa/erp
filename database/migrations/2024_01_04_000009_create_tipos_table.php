<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTiposTable extends Migration {
    public function up() {
        Schema::create('tipos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_create_id')->nullable();
            $table->unsignedBigInteger('user_update_id')->nullable();
            $table->unsignedBigInteger('user_delete_id')->nullable();
            $table->string('nome', 100);
            $table->string('descricao', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('user_create_id')->references('id')->on('users');
            $table->foreign('user_update_id')->references('id')->on('users');
            $table->foreign('user_delete_id')->references('id')->on('users');
        });
    }
    
    public function down() {
        Schema::table('tipos', function (Blueprint $table) {
            $table->dropForeign(['user_create_id']);
            $table->dropForeign(['user_update_id']);
            $table->dropForeign(['user_delete_id']);
        });

        Schema::dropIfExists('tipos');
    }    
}
