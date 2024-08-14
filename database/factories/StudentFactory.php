<?php

namespace Database\Factories;

use App\Enums\InternshipStatus;
use App\Enums\StudyField;
use App\Models\Student;
use App\Models\User;
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
            'study_field' => fake()->randomElement(StudyField::cases()),
            'internship_status' => fake()->randomElement(InternshipStatus::cases()),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Student $student) {
            User::create([
                'last_name' => fake()->lastName(),
                'first_name' => fake()->firstName(),
                'email' => fake()->unique()->safeEmail(),
                'password' => bcrypt('password'),
                'profile_type' => Student::class,
                'profile_id' => $student->id,
            ]);
        });
    }
}
