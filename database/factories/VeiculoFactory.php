<?php

namespace Database\Factories;

use App\Models\Marca;
use App\Models\Modelo;
use App\Models\Tipo;
use App\Models\User;
use App\Models\Utils\VeiculoFakeData;
use App\Models\Veiculo;
use App\Models\Versao;
use Illuminate\Database\Eloquent\Factories\Factory;

class VeiculoFactory extends Factory
{
    protected $model = Veiculo::class;


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $versoes = Versao::all()->pluck('id','id')->prepend(null,0);
        return [
            'user_id' => $this->faker->numberBetween(User::min('id'), User::max('id')),
            'tipo_id' => $this->faker->numberBetween(Tipo::min('id'), Tipo::max('id')),
            'modelo_id' => $this->faker->numberBetween(Modelo::min('id'), Modelo::max('id')),
            'versao_id' => $this->faker->randomElement($versoes)
        ];
    }
}
