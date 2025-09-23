<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Create 24 regular users
        for ($i = 0; $i < 24; $i++) {
            $user = User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'email_verified_at' => $faker->boolean(80) ? now() : null,
                'password' => Hash::make('password123'),
                'role' => 'user',
                'status' => $faker->randomElement(['active', 'inactive']),
                'remember_token' => Str::random(10),
            ]);

            UserProfile::create([
                'user_id' => $user->id,
                'profile_photo_path' => null,
                'phone_number' => $faker->phoneNumber,
                'address' => $faker->address,
                'biography' => $faker->optional()->paragraph,
            ]);
        }

        // Create 1 admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'status' => 'active',
            'remember_token' => Str::random(10),
        ]);

        UserProfile::create([
            'user_id' => $admin->id,
            'profile_photo_path' => null,
            'phone_number' => $faker->phoneNumber,
            'address' => $faker->address,
            'biography' => 'Admin user biography.',
        ]);

        // Create 25 instructor users
        for ($i = 0; $i < 25; $i++) {
            $instructor = User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'email_verified_at' => now(),
                'password' => Hash::make('instructor123'),
                'role' => 'instructor',
                'status' => 'active',
                'remember_token' => Str::random(10),
            ]);

            UserProfile::create([
                'user_id' => $instructor->id,
                'profile_photo_path' => null,
                'phone_number' => $faker->phoneNumber,
                'address' => $faker->address,
                'biography' => 'Instructor user biography.',
            ]);
        }
    }
}
