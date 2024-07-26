<?php

namespace Database\Factories;

use App\Enums\Gender;
use App\Enums\Status;
use App\Models\Language;
use App\Models\Treatments;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Inquiry>
 */
class InquiryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $treatment = Treatments::inRandomOrder()->first();
        $language = Language::inRandomOrder()->first();

        return [
            'name' => $this->faker->name(),
            'surname' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'country' => $this->faker->country(),
            'ip_address' => $this->faker->ipv4(),
            'treatment_id' => $treatment->id,
            'language_id' => $language->id,
            'status' => Status::Passive->value,
            'gender' => array_rand(Gender::toArray(), 1),
            'message' => $this->faker->text(),
        ];
    }
}
