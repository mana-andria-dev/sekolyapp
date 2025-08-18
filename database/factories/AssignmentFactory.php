<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Assignment;

class AssignmentFactory extends Factory
{
    protected $model = Assignment::class;

    public function definition(): array
    {
        return [
            'title'      => 'Devoir: ' . $this->faker->sentence(3),
            'description'=> $this->faker->paragraph(),
            'due_date'   => $this->faker->dateTimeBetween('now', '+1 month'),
        ];
    }
}
