<?php

namespace Database\Factories;

use App\Enums\InternshipStatus;
use App\Enums\StudyField;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
     /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Student::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'matriculation_number' => fake()->unique()->regexify('[0-9]{8}'),
            'first_name' => fake()->lastName(),
            'last_name' => fake()->firstName(),
            'study_field' => fake()->randomElement(StudyField::cases()),
            'internship_status' => fake()->randomElement(InternshipStatus::cases()),
            'email' => fake()->email(),
        ];
    }
}
