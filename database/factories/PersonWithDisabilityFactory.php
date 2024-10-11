<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PersonWithDisability>
 */
class PersonWithDisabilityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'last_name' => 'Romero',
            'first_name' => 'Mark Kevin',
            'middle_name' => 'Malapit',
            'present_house' => fake()->address(),
            'present_sitio' => fake()->address(),
            'present_baranggay' => fake()->address(),
            'present_city' => fake()->address(),
            'present_province' => fake()->address(),
            'province_house' => fake()->address(),
            'province_sitio' => fake()->address(),
            'province_baranggay' => fake()->address(),
            'province_city' => fake()->address(),
            'province_province' => fake()->address(),
            'sex' => 'Male',
            'civil_status' => 'Single',
            'date_of_birth' => 'March 28, 2004',
            'place_of_birth' => fake()->streetAddress(),
            'contact_no' => '09123456789',
            'email' => fake()->safeEmail(),
            'height' => 165,
            'weight' => 54,
            'religion' => 'Catholic'
        ];
    }
}
