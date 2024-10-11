<?php

namespace Database\Factories;

use App\Models\PersonWithDisability;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EducationalAttainment>
 */
class EducationalAttainmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'person_with_disability_id' => PersonWithDisability::factory(),
            'elementary_school' => 'Old Balara Elementary School',
            'elementary_school_address' => 'Old Balara Quezon City',
            'high_school' => 'Ernesto Rondon High School',
            'high_school_address' => 'Project 6, Quezon City',
            'vocational_school' => 'Gardner College',
            'vocational_address' => 'Gardner College, Diliman Quezon City',
            'college_school' => 'World Citi Colleges',
            'college_address' => 'Anons Quezon City',
        ];
    }
}
