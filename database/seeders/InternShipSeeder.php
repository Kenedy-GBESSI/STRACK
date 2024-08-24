<?php

namespace Database\Seeders;

use App\Models\InternShip;
use Illuminate\Database\Seeder;

class InternShipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        InternShip::factory(5)
        ->create();
    }
}
