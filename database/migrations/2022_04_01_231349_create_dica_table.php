<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDicaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dica', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('veiculo_id');
            $table->integer('numero');
            $table->string('descricao');
            $table->timestamps();

            $table->foreign('user_id','fk_dica_users_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('veiculo_id','fk_dica_veiculo_veiculo_id')->references('id')->on('veiculo')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dica');
    }
}
