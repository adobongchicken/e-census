<?php

namespace Database\Factories;

use App\Models\PersonWithDisability;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EmploymentRecord>
 */
class EmploymentRecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'person_with_disability_id' => PersonWithDisability::factory(),  // Assuming you have a factory for PersonWithDisability
            'duration' => $this->faker->numberBetween(1, 10) . ' years',     // Example: "5 years"
            'company_name' => $this->faker->company,                         // Example: "Acme Corp"
            'company_address' => $this->faker->address,
        ];
    }
}
