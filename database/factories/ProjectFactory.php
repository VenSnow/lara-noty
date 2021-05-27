<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Project::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'user_id' => 1,
            'name' => $this->faker->unique()->sentence(),
            'domain' => $this->faker->unique()->sentence(1, 3),
            'domain_end' => $this->faker->dateTimeBetween('now', '+2 years'),
            'host_end' => $this->faker->dateTimeBetween('now', '+2 years'),
            'ftp_login' => $this->faker->word,
            'ftp_password' => $this->faker->password(),
            'db_login' => $this->faker->word,
            'db_password' => $this->faker->password(),
            'comment' => $this->faker->realText(40),
        ];

    }
}
