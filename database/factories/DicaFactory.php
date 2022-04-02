<?php

namespace Database\Factories;

use App\Models\Dica;
use App\Models\User;
use App\Models\Veiculo;
use Illuminate\Database\Eloquent\Factories\Factory;

class DicaFactory extends Factory
{
    protected $model = Dica::class;


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $veic_id = $this->faker->numberBetween(Veiculo::min('id'), Veiculo::max('id'));

        return [
            'user_id' => $this->faker->numberBetween(User::min('id'), User::max('id')),
            'veiculo_id' => $veic_id,
            'numero' => 0,
            'descricao' => $this->faker->randomElement([$this->faker->country, $this->faker->colorName])
        ];
    }
}
