<?php

namespace Database\Factories;

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
        return [
            'title' => fake()->title(),
            'description' => fake()->text(),
            'start_date' => fake()->dateTimeBetween($this->startOfThisMonth(), $this->endOfThisMonth()),
            'end_date' => fake()->dateTimeBetween($this->startOfTheNextMonth(), $this->endOfTheNextMonth()),
        ];
    }
}
