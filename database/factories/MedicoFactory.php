<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Medico;

class MedicoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Medico::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->word,
            'apellido_paterno' => $this->faker->word,
            'apellido_materno' => $this->faker->word,
            'status' => $this->faker->boolean,
        ];
    }
}
