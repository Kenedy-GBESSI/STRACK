<?php

namespace Database\Seeders;

use App\Models\Institute;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $institute = Institute::create(['institute_name' => 'IFRI']);

        $instituteAdmin = User::create([
            'first_name' => 'GBESSI',
            'last_name' => 'Kénédy',
            'email' => 'gbessikenedy@gmail.com',
            // TODO WARNING: CHANGE THIS BEFORE GOING TO PRODUCTION
            'password' => 'admin',
            'profile_type' => Institute::class,
            'profile_id' => $institute->id,
        ]);
    }
}
