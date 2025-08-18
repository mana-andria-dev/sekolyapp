<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Subject;
use App\Models\Tenant;

class SubjectFactory extends Factory
{
    protected $model = Subject::class;

    public function definition(): array
    {
        // Liste de matières malagasy réalistes
        $subjects = [
            'Mathématiques', 
            'Langue malgache', 
            'Anglais', 
            'Sciences', 
            'Histoire', 
            'Géographie', 
            'Éducation physique', 
            'Musique', 
            'Arts plastiques', 
            'Technologie', 
            'Physique', 
            'Chimie', 
            'Éducation civique', 
            'Technique', 
            'Sécurité'
        ];

        return [
            'name' => $this->faker->randomElement($subjects),
            'tenant_id' => Tenant::factory(),
        ];
    }
}
