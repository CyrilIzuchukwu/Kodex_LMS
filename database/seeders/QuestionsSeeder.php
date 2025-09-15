<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\Note;
use App\Models\Question;
use App\Models\QuestionReply;
use App\Models\User;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @throws Exception
     */
    public function run(): void
    {
        $faker = fake();

        $students = User::where('role', 'user')->get();
        $modules = Module::all();

        // Ensure required data exists
        if ($students->isEmpty() || $modules->isEmpty()) {
            throw new Exception('Required data (students or modules) not found. Please ensure database is populated.');
        }

        foreach ($modules as $module) {
            // Get an instructor associated with the course via user_profiles
            $instructor = User::where('role', 'instructor')
                ->whereHas('profile', function ($query) use ($module) {
                    $query->where('user_profiles.course_id', $module->course_id);
                })
                ->inRandomOrder()
                ->first();

            // If no instructor is found for this course, skip
            if (!$instructor) {
                continue;
            }

            // Get a random student
            $student = $students->random();

            // Create a question for the module (skip if already exists)
            if (!$module->questions()->exists()) {
                $question = Question::create([
                    'course_id' => $module->course_id,
                    'module_id' => $module->id,
                    'user_id' => $student->id,
                    'title' => $faker->sentence(4),
                    'content' => $faker->paragraph(),
                ]);

                // Create a reply for the question
                QuestionReply::create([
                    'question_id' => $question->id,
                    'user_id' => $instructor->id,
                    'content' => $faker->paragraph(2),
                    'is_instructor' => true,
                ]);
            }
        }
    }
}
