<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CourseCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Web Development', 'slug' => Str::slug('Web Development')],
            ['name' => 'Mobile Development', 'slug' => Str::slug('Mobile Development')],
            ['name' => 'Data Science', 'slug' => Str::slug('Data Science')],
            ['name' => 'Machine Learning', 'slug' => Str::slug('Machine Learning')],
            ['name' => 'Cloud Computing', 'slug' => Str::slug('Cloud Computing')],
            ['name' => 'Cybersecurity', 'slug' => Str::slug('Cybersecurity')],
            ['name' => 'DevOps', 'slug' => Str::slug('DevOps')],
            ['name' => 'Artificial Intelligence', 'slug' => Str::slug('Artificial Intelligence')],
            ['name' => 'Database Management', 'slug' => Str::slug('Database Management')],
            ['name' => 'Software Engineering', 'slug' => Str::slug('Software Engineering')],
            ['name' => 'Game Development', 'slug' => Str::slug('Game Development')],
            ['name' => 'UI/UX Design', 'slug' => Str::slug('UI/UX Design')],
            ['name' => 'Blockchain Technology', 'slug' => Str::slug('Blockchain Technology')],
            ['name' => 'Internet of Things (IoT)', 'slug' => Str::slug('Internet of Things (IoT)')],
            ['name' => 'Augmented Reality', 'slug' => Str::slug('Augmented Reality')],
            ['name' => 'Virtual Reality', 'slug' => Str::slug('Virtual Reality')],
            ['name' => 'Big Data Analytics', 'slug' => Str::slug('Big Data Analytics')],
            ['name' => 'Network Administration', 'slug' => Str::slug('Network Administration')],
            ['name' => 'Ethical Hacking', 'slug' => Str::slug('Ethical Hacking')],
            ['name' => 'Frontend Development', 'slug' => Str::slug('Frontend Development')],
            ['name' => 'Backend Development', 'slug' => Str::slug('Backend Development')],
            ['name' => 'Full Stack Development', 'slug' => Str::slug('Full Stack Development')],
            ['name' => 'Data Engineering', 'slug' => Str::slug('Data Engineering')],
            ['name' => 'Cloud Architecture', 'slug' => Str::slug('Cloud Architecture')],
            ['name' => 'Quantum Computing', 'slug' => Str::slug('Quantum Computing')],
            ['name' => 'Robotics', 'slug' => Str::slug('Robotics')],
            ['name' => 'Embedded Systems', 'slug' => Str::slug('Embedded Systems')],
            ['name' => 'Business Intelligence', 'slug' => Str::slug('Business Intelligence')],
            ['name' => 'IT Project Management', 'slug' => Str::slug('IT Project Management')],
            ['name' => 'Digital Marketing Technology', 'slug' => Str::slug('Digital Marketing Technology')],
        ];

        DB::table('course_categories')->insert($categories);
    }
}
