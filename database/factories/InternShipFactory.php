<?php

namespace Database\Factories;

use App\Enums\AcademicYear;
use App\Models\InternShip;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Traits\WithCarbonDateTimeUtilities;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InternShip>
 */
class InternShipFactory extends Factory
{
    use WithCarbonDateTimeUtilities;

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = InternShip::class;


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $topics = ['Artificial Intelligence', 'Data Science', 'Software Engineering', 'Biotechnology', 'Cybersecurity', 'Business Analytics'];
        $levels = ['Bachelor', 'Master', 'PhD'];
        $domains = ['Research', 'Development', 'Internship', 'Thesis'];

        $topic = $this->faker->randomElement($topics);
        $level = $this->faker->randomElement($levels);
        $domain = $this->faker->randomElement($domains);

        return [
            'title' => $domain . ' in ' . $topic . ' (' . $level . ' Level)',
            'description' => fake()->text(),
            'start_date' => fake()->dateTimeBetween($this->startOfThisMonth(), $this->endOfThisMonth()),
            'end_date' => fake()->dateTimeBetween($this->startOfTheNextMonth(), $this->endOfTheNextMonth()),
            'academic_year' => fake()->randomElement(AcademicYear::cases()),
        ];
    }
}
