<?php

namespace Database\Factories;

use App\Models\Marca;
use App\Models\Modelo;
use App\Models\Utils\VeiculoFakeData;
use Illuminate\Database\Eloquent\Factories\Factory;

class ModeloFactory extends Factory
{
    protected $model = Modelo::class;


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'marca_id' => $this->faker->unique()->numberBetween(Marca::min('id'), Marca::max('id')),
            'descricao' => $this->faker->unique()->randomElement(VeiculoFakeData::getModels()),
        ];
    }
}
