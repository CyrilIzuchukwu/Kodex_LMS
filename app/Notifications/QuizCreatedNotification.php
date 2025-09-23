<?php

namespace App\Notifications;

use App\Models\Quiz;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class QuizCreatedNotification extends Notification
{
    use Queueable;

    public Quiz $quiz;

    /**
     * Create a new notification instance.
     */
    public function __construct(Quiz $quiz)
    {
        $this->quiz = $quiz;
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
            'type' => 'quiz_created',
            'quiz_id' => $this->quiz->id,
            'title' => 'New Quiz Available: ' . $this->quiz->title,
            'content' => 'A new quiz has been added to the module: ' . $this->quiz->module->title . ' in the course: ' . $this->quiz->course->title,
        ];
    }
}
