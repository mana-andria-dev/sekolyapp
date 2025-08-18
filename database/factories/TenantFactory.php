<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Tenant;

class TenantFactory extends Factory
{
    protected $model = Tenant::class;

    public function definition()
    {
        $cities = ['Antananarivo', 'Antsirabe', 'Fianarantsoa', 'Toamasina', 'Mahajanga', 'Toliara', 'Antsiranana', 'Ambatondrazaka'];
        $streets = ['Lot I', 'Lot II', 'Lot III', 'Rue Andohalo', 'Rue Isoraka', 'Rue Analakely', 'Rue Rainandriamampandry'];
        $prefixes = ['032', '033', '034', '038'];

        return [
            'name' => $this->faker->lastName() . ' ' . $this->faker->firstName(),
            'type' => $this->faker->randomElement(['École', 'Collège', 'Université']),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->randomElement($prefixes) . $this->faker->numerify('######'),
            'address' => $this->faker->streetAddress() . ', ' . $this->faker->randomElement($cities),
            'logo_path' => null,
            'subdomain' => $this->faker->unique()->domainWord(),
        ];        
    }
}
