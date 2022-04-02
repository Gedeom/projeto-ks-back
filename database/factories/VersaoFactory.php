<?php

namespace Database\Factories;

use App\Models\Versao;
use Illuminate\Database\Eloquent\Factories\Factory;

class VersaoFactory extends Factory
{
    protected $model = Versao::class;


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $versao = (string)($this->faker->unique()->randomFloat(1,1.0,5.0));
        $versao = strpos($versao,'.') ? $versao: ($versao . '.0');

        return [
            'descricao' => $versao
        ];
    }
}
