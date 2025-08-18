<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Student;
use App\Models\Tenant;

class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition()
    {
        $prefixes = ['032', '033', '034', '038'];

        $malagasyFirstNames = ['Tahina','Fanja','Hery','Andry','Solo','Lova','Mialy','Fenohasina','Rivo','Tiana','Soa','Miora','Malala','Rado','Fetra'];
        $malagasyLastNames = ['Rajaonarison','Rakotoarisoa','Ratsimbazafy','Rasolofo','Rakotondrazaka','Rabe','Rasanjy','Rajaonson','Ratsimamanga','Rafaralahy'];

        return [
            'first_name' => $this->faker->randomElement($malagasyFirstNames),
            'last_name' => $this->faker->randomElement($malagasyLastNames),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->randomElement($prefixes) . $this->faker->numerify('######'),
            'tenant_id' => Tenant::factory(),
        ];
    }
}
