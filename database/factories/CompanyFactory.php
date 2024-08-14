<?php

namespace Database\Factories;

use App\Enums\PartnershipStatus;
use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
     /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Company::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company_name' => fake()->company(),
            'phone_number' => fake()->e164PhoneNumber(),
            'address' => fake()->address(),
            'website' => fake()->domainName(),
            'service' => fake()->text(),
            'description' => fake()->text(),
            'partnership_status' => fake()->randomElement(PartnershipStatus::cases()),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Company $company) {
            User::create([
                'last_name' => fake()->lastName(),
                'first_name' => fake()->firstName(),
                'email' => fake()->unique()->safeEmail(),
                'password' => bcrypt('password'),
                'profile_type' => Company::class,
                'profile_id' => $company->id,
            ]);
        });
    }
}
