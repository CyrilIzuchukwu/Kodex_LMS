<?php

namespace Database\Seeders;

use App\Models\CourseCategory;
use App\Models\User;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class CoursesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @throws Exception
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Fetch all category IDs from the course_categories table
        $categoryIds = CourseCategory::pluck('id')->toArray();

        if (empty($categoryIds)) {
            throw new Exception('No categories found. Please seed CourseCategoriesSeeder first.');
        }

        // Fetch all user IDs from the users table
        $userIds = User::pluck('id')->toArray();

        if (empty($userIds)) {
            throw new Exception('No users found. Please seed UsersSeeder first.');
        }

        $courseTitles = [
            'Introduction to {category}', 'Advanced {category} Techniques', 'Mastering {category}',
            '{category} for Beginners', 'Professional {category} Certification',
            'Building Applications with {category}', 'Deep Dive into {category}',
            'Practical {category} Projects', 'Fundamentals of {category}',
            '{category} in the Real World', 'Complete {category} Bootcamp',
            '{category} and Beyond', 'Expert {category} Skills',
            'Modern {category} Development', 'Hands-On {category} Labs',
            '{category} for Professionals', 'Next-Level {category} Mastery',
            '{category} Essentials', 'Core {category} Concepts',
            '{category} for Enterprise Solutions'
        ];

        $courses = [];
        $courseOutcomes = [];
        $courseMedia = [];
        $modules = [];
        $moduleResources = [];

        // Generate 50 courses
        for ($i = 0; $i < 50; $i++) {
            // Randomly select a category
            $categoryId = $faker->randomElement($categoryIds);
            $category = CourseCategory::find($categoryId)->name;

            // Pick a random title template and replace {category} with the actual category name
            $titleTemplate = $faker->randomElement($courseTitles);
            $title = str_replace('{category}', $category, $titleTemplate);

            // Generate a unique slug
            $slug = Str::slug($title) . '-' . $faker->unique()->numberBetween(1000, 9999);

            // Create course entry
            $course = [
                'category_id' => $categoryId,
                'title' => $title,
                'subtitle' => $faker->sentence(6, true),
                'slug' => $slug,
                'price' => $faker->randomFloat(2, 0, 999.99),
                'summary' => $faker->paragraph(3, true),
                'video_url' => $faker->boolean(50) ? $faker->url : null,
                'user_id' => $faker->randomElement($userIds),
                'status' => $faker->randomElement(['draft', 'published']),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $courses[] = $course;

            // Insert the course to get its ID
            $courseId = DB::table('courses')->insertGetId($course);

            // Generate 2–4 course outcomes
            $numOutcomes = $faker->numberBetween(2, 4);
            for ($j = 0; $j < $numOutcomes; $j++) {
                $courseOutcomes[] = [
                    'course_id' => $courseId,
                    'outcome' => $faker->sentence(8, true),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // Generate 1–3 course media entries
            $numMedia = $faker->numberBetween(1, 3);
            for ($j = 0; $j < $numMedia; $j++) {
                $courseMedia[] = [
                    'course_id' => $courseId,
                    'image_url' => $faker->imageUrl(640, 480, 'course'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // Generate 2–5 modules
            $numModules = $faker->numberBetween(2, 5);
            for ($j = 0; $j < $numModules; $j++) {
                $module = [
                    'course_id' => $courseId,
                    'title' => $faker->sentence(4, true),
                    'video_url' => $faker->boolean(70) ? $faker->url : null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                $moduleId = DB::table('modules')->insertGetId($module);
                $modules[] = $module;

                // Generate 1–3 resources per module
                $numResources = $faker->numberBetween(1, 3);
                for ($k = 0; $k < $numResources; $k++) {
                    $moduleResources[] = [
                        'module_id' => $moduleId,
                        'resource_url' => $faker->url,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        // Insert related data in chunks
        foreach (array_chunk($courseOutcomes, 25) as $chunk) {
            DB::table('course_outcomes')->insert($chunk);
        }
        foreach (array_chunk($courseMedia, 25) as $chunk) {
            DB::table('course_media')->insert($chunk);
        }
        foreach (array_chunk($modules, 25) as $chunk) {
            DB::table('modules')->insert($chunk);
        }
        foreach (array_chunk($moduleResources, 25) as $chunk) {
            DB::table('module_resources')->insert($chunk);
        }
    }
}
