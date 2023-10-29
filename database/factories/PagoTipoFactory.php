<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Pago_tipo;

class PagoTipoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PagoTipo::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'tipoPago' => $this->faker->word,
        ];
    }
}
