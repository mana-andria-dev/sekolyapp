<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Classe;

class ClasseFactory extends Factory
{
    protected $model = Classe::class;

    public function definition(): array
    {
        $levels = ['6ème', '5ème', '4ème', '3ème', '2nde', '1ère', 'Terminale'];

        return [
            'name'        => 'Classe ' . $this->faker->randomElement(['A', 'B', 'C', 'D']),
            'level'       => $this->faker->randomElement($levels),
            'description' => 'Classe de ' . $this->faker->randomElement($levels),
        ];
    }
}
