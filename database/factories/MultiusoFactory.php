<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Multiuso;

class MultiusoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Multiuso::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'nombre_multiuso' => $this->faker->word,
            'estado' => $this->faker->boolean,
        ];
    }
}
