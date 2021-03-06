<?php

namespace Database\Factories;

use App\Models\Host;
use Illuminate\Database\Eloquent\Factories\Factory;

class HostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Host::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => 1,
            'name' => $this->faker->unique()->name,
            'address' => $this->faker->unique()->word(),
            'host_login' => $this->faker->word(),
            'host_password' => $this->faker->password(),
            'comment' => $this->faker->realText(150),
        ];
    }
}
