<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Module;
use App\Models\Quiz;
use App\Models\QuizQuestion;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = fake();

        $modules = Module::all();

        foreach ($modules as $module) {
            // Skip if module already has a quiz
            if ($module->quizzes()->exists()) {
                continue;
            }

            $quiz = Quiz::create([
                'course_id'       => $module->course_id,
                'module_id'       => $module->id,
                'title'           => "{$module->title} Quiz",
                'description'     => "Test your knowledge of {$module->title}.",
                'question_count'  => 10,
                'pass_percentage' => 80,
                'time_limit'      => 20,
            ]);

            // Create 10 randomized questions
            for ($i = 1; $i <= 10; $i++) {
                // Generate 4 options with explanations
                $options = [];
                for ($j = 0; $j < 4; $j++) {
                    $options[] = [
                        'text'        => $faker->sentence(3),   // short phrase
                        'correct'     => false,                 // mark later
                        'explanation' => $faker->sentence(),    // explanation for this option
                    ];
                }

                // Pick one random option as correct
                $correctIndex = array_rand($options);
                $options[$correctIndex]['correct'] = true;

                QuizQuestion::create([
                    'quiz_id'        => $quiz->id,
                    'question_text'  => $faker->sentence(8), // random sentence
                    'explanation'    => $faker->sentence(), // general question explanation
                    'options'        => json_encode($options),
                    'correct_answer' => $options[$correctIndex]['text'], // still keep for compatibility
                    'points'         => 1
                ]);
            }
        }
    }
}
