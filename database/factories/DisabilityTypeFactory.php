<?php

namespace Database\Factories;

use App\Models\PersonWithDisability;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DisabilityType>
 */
class DisabilityTypeFactory extends Factory
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
            'visual_impairment' => $this->faker->randomElement([null, 'Blind', 'Low Vision']),
            'speech_language_impairment' => $this->faker->randomElement([null, 'Speech Disorder', 'Language Disorder']),
            'learning_disabilities' => $this->faker->randomElement([null, 'Dyslexia', 'Dysgraphia']),
            'hearing_impairment' => $this->faker->randomElement([null, 'Deaf', 'Hard of Hearing']),
            'intellectual_disabilities' => $this->faker->randomElement([null, 'Mild', 'Severe']),
            'mobility_impairment' => $this->faker->randomElement([null, 'Paralysis', 'Amputation']),
            'pyscho_social_disabilities' => $this->faker->randomElement([null, 'Depression', 'Anxiety Disorder', 'Schizophrenia', 'Bipolar Disorder']),
            'others' => $this->faker->optional()->sentence(),
        ];
    }
}
