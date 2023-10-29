<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Cita;
use App\Models\Consultorio;
use App\Models\Estado;
use App\Models\Medico;
use App\Models\Paciente;
use App\Models\Pago;
use App\Models\User;

class CitaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Cita::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'fecha' => $this->faker->date(),
            'silla' => $this->faker->boolean,
            'hora' => $this->faker->dateTime(),
            'confirmar' => $this->faker->boolean,
            'llego' => $this->faker->boolean,
            'entro' => $this->faker->boolean,
            'user_id' => User::factory(),
            'paciente_id' => Paciente::factory(),
            'consultorio_id' => Consultorio::factory(),
            'medico_id' => Medico::factory(),
            'pago_id' => Pago::factory(),
            'estado_id' => Estado::factory(),
        ];
    }
}
