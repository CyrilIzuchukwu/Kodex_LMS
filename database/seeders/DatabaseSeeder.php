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
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Create 5 regular users
        for ($i = 0; $i < 50; $i++) {
            $user = User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'email_verified_at' => $faker->boolean(80) ? now() : null, // 80% chance of verified email
                'password' => Hash::make('password123'), // Default password
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

        // Create 1 instructor user
        $instructor = User::create([
            'name' => 'Instructor User',
            'email' => 'instructor@example.com',
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

        // Create 1 social login user (e.g., Google)
        $socialUser = User::create([
            'name' => $faker->name,
            'email' => $faker->unique()->safeEmail,
            'social_login_provider' => 'google',
            'social_login_id' => $faker->unique()->uuid,
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // No password for social login
            'role' => 'user',
            'status' => 'active',
            'remember_token' => Str::random(10),
        ]);

        UserProfile::create([
            'user_id' => $socialUser->id,
            'profile_photo_path' => null,
            'phone_number' => $faker->phoneNumber,
            'address' => $faker->address,
            'biography' => $faker->optional()->paragraph,
        ]);
    }
}
