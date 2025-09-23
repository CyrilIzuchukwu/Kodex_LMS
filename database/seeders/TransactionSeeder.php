<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\Module;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get available users and courses
        $users = User::where('role', 'user')->pluck('id')->toArray();
        $courses = Course::pluck('id')->toArray();

        if (empty($users) || empty($courses)) {
            $this->command->warn('No users or courses found. Please seed users and courses first.');
            return;
        }

        // Ensure at least one transaction per month
        foreach (range(1, 12) as $month) {
            $this->createTransaction(
                $users,
                $courses,
                Carbon::now()->startOfYear()->month($month)->day(rand(1, 28))->setTime(rand(0, 23), rand(0, 59))
            );
        }

        // Create additional random transactions (to make total ~50)
        for ($i = 0; $i < 38; $i++) {
            $randomDate = Carbon::now()->subDays(rand(0, 365))->setTime(rand(0, 23), rand(0, 59));
            $this->createTransaction($users, $courses, $randomDate);
        }
    }

    private function createTransaction(array $users, array $courses, Carbon $date): void
    {
        $userId = $users[array_rand($users)];

        // Random cart items (2–6 courses)
        $cartItems = [];
        $numItems = rand(2, 6);
        $subtotal = 0;

        $selectedCourses = collect($courses)->random($numItems);

        foreach ($selectedCourses as $courseId) {
            $price = fake()->randomFloat(2, 1000, 20000);
            $cartItems[] = [
                'course_id' => $courseId,
                'price' => $price,
            ];
            $subtotal += $price;
        }

        $charges = $subtotal * 0.075; // 7.5% charge
        $discount = fake()->boolean(20) ? fake()->randomFloat(2, 100, 2000) : 0;
        $total = $subtotal + $charges - $discount;

        $transaction = Transaction::create([
            'user_id' => $userId,
            'cart_items' => json_encode($cartItems),
            'subtotal' => $subtotal,
            'charges' => $charges,
            'discount' => $discount,
            'total' => $total,
            'amount' => $total,
            'coupon' => $discount > 0 ? strtoupper(Str::random(6)) : null,
            'payment_method' => fake()->randomElement(['Paystack', 'Flutterwave', 'Stripe']),
            'channel' => fake()->randomElement(['card', 'bank', 'ussd']),
            'transaction_reference' => Str::random(10),
            'status' => fake()->randomElement(['pending', 'completed', 'cancelled']),
            'created_at' => $date,
            'updated_at' => $date,
        ]);

        // Create enrollments if the transaction is completed
        if ($transaction->status === 'completed') {
            foreach ($cartItems as $item) {
                $firstModule = Module::where('course_id', $item['course_id'])
                    ->orderBy('id', 'asc')
                    ->first();

                if ($firstModule) {
                    // Get total modules for the course
                    $totalModules = Module::where('course_id', $item['course_id'])->count();
                    $totalModules = $totalModules > 0 ? $totalModules : 1; // Ensure at least 1 to avoid division by zero

                    // Randomly determine enrollment status (30% chance of completed)
                    $enrollmentStatus = fake()->boolean(30) ? 'completed' : 'running';

                    // Calculate progress and lessons completed
                    $progress = $enrollmentStatus === 'completed' ? 100 : rand(0, 99);
                    $lessonsCompleted = $enrollmentStatus === 'completed'
                        ? $totalModules
                        : rand(0, $totalModules);

                    // Set last_accessed to a recent date if progress > 0
                    $lastAccessed = $progress > 0
                        ? $date->copy()->addDays(rand(0, 30))->setTime(rand(0, 23), rand(0, 59))
                        : null;

                    CourseEnrollment::create([
                        'user_id' => $userId,
                        'course_id' => $item['course_id'],
                        'module_id' => $firstModule->id,
                        'progress' => $progress,
                        'lessons_completed' => $lessonsCompleted,
                        'status' => $enrollmentStatus,
                        'last_accessed' => $lastAccessed,
                        'created_at' => $date,
                        'updated_at' => $date,
                    ]);
                }
            }
        }
    }
}
