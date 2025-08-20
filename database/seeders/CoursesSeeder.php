<?php

namespace Database\Seeders;

use App\Models\CourseCategory;
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

        $courses = [];
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
            '{category} for Enterprise Solutions', '{category} with Real Projects',
            'Advanced {category} Frameworks', 'Beginner to Pro in {category}',
            '{category} Design Patterns', 'Scalable {category} Solutions',
            '{category} for Data Scientists', 'Building Secure {category} Systems',
            'Optimizing {category} Performance', '{category} Best Practices',
            'Real-Time {category} Applications'
        ];

        // Generate 500 courses
        for ($i = 0; $i < 500; $i++) {
            // Randomly select a category
            $categoryId = $faker->randomElement($categoryIds);
            $category = CourseCategory::find($categoryId)->name;

            // Pick a random title template and replace {category} with the actual category name
            $titleTemplate = $faker->randomElement($courseTitles);
            $title = str_replace('{category}', $category, $titleTemplate);

            // Generate a unique slug
            $slug = Str::slug($title) . '-' . $faker->unique()->numberBetween(1000, 9999);

            $courses[] = [
                'course_category_id' => $categoryId,
                'title' => $title,
                'slug' => $slug,
                'students_enrolled' => $faker->numberBetween(0, 10000),
                'price' => $faker->randomFloat(2, 0, 999.99), // Price between 0 and 999.99
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert courses in chunks to avoid memory issues
        foreach (array_chunk($courses, 100) as $chunk) {
            DB::table('courses')->insert($chunk);
        }
    }
}
