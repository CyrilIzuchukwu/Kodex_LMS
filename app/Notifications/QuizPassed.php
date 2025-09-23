<?php

namespace App\Notifications;

use App\Models\QuizAttempt;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class QuizPassed extends Notification
{
    use Queueable;

    protected QuizAttempt $attempt;

    /**
     * Create a new notification instance.
     */
    public function __construct(QuizAttempt $attempt)
    {
        $this->attempt = $attempt;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'type' => 'quiz_submission',
            'attempt_id' => $this->attempt->id,
            'title' => 'You have successfully passed the quiz!',
            'content' => 'Score: ' . $this->attempt->score . '/' . $this->attempt->total_questions . ' (Percentage: ' . $this->attempt->percentage . '%)',
        ];
    }
}
