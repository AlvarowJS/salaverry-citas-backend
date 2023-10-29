<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Consultorio;
use App\Models\Ubicacion;

class ConsultorioFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Consultorio::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'numero_consultorio' => $this->faker->word,
            'ubicacion_id' => Ubicacion::factory(),
        ];
    }
}
