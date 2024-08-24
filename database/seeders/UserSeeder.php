<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'username' => 'evo',
                'email' => 'evo@gmail.com',
                'password' => bcrypt('password'),
                'gender' => User::GENDER_MALE,
                'phone' => '08123456789',
                'coin_amount' => 0,
                'linkedin_url' => 'https://www.linkedin.com/in/evo',
                'profile_url' => 'evo.png',
                'is_profile_visible' => true,
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'username' => 'andreas',
                'email' => 'andreas@gmail.com',
                'password' => bcrypt('password'),
                'gender' => User::GENDER_MALE,
                'phone' => '08123456789',
                'coin_amount' => 0,
                'linkedin_url' => 'https://www.linkedin.com/in/andreas',
                'profile_url' => 'andreas.png',
                'is_profile_visible' => true,
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'username' => 'miko',
                'email' => 'miko@gmail.com',
                'password' => bcrypt('password'),
                'gender' => User::GENDER_FEMALE,
                'phone' => '08123456789',
                'coin_amount' => 0,
                'linkedin_url' => 'https://www.linkedin.com/in/miko',
                'profile_url' => 'miko.png',
                'is_profile_visible' => true,
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        User::insert($users);
    }
}
