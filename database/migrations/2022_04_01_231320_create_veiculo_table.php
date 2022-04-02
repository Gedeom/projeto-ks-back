<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVeiculoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('veiculo', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('tipo_id');
            $table->unsignedBigInteger('modelo_id');
            $table->unsignedBigInteger('versao_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id','fk_veiculo_users_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('tipo_id','fk_veiculo_tipo_tipo_id')->references('id')->on('tipo')->onDelete('cascade');
            $table->foreign('modelo_id','fk_veiculo_modelo_modelo_id')->references('id')->on('modelo')->onDelete('cascade');
            $table->foreign('versao_id','fk_veiculo_versao_versao_id')->references('id')->on('versao')->onDelete('cascade');

            $table->unique(['tipo_id','modelo_id','versao_id'],'unique_veiculo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('veiculo');
    }
}
