<?php

namespace Database\Seeders;

use App\Models\Dica;
use App\Models\Marca;
use App\Models\Modelo;
use App\Models\User;
use App\Models\Veiculo;
use App\Models\Versao;
use Database\Factories\DicaFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)->create();

        $marcas = Marca::factory(20)->make();
        $marcas->each(function ($marca) {
            Marca::hasMarca($marca->descricao) ?: $marca->save();
        });

        $modelos = Modelo::factory(20)->make();
        $modelos->each(function ($modelo) {
            Modelo::hasModelo($modelo->descricao) ?: $modelo->save();
        });

        $versoes = Versao::factory(5)->make();
        $versoes->each(function ($versao) {
            Versao::hasVersao($versao->descricao) ?: $versao->save();
        });

        $veiculos = Veiculo::factory(20)->make();
        $veiculos->each(function ($veiculo) {
            Veiculo::hasVeiculo($veiculo->tipo_id, $veiculo->modelo_id, $veiculo->versao_id) ?: $veiculo->save();
        });

        $dicas = Dica::factory(100)->make();
        $dicas->each(function ($dica) {
            $dica->numero = Dica::getNextNumero();
            $dica->save();
        });
    }
}
