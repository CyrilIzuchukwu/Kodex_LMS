<?php

namespace App\Notifications;

use App\Models\Question;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class InstructorQuestionNotification extends Notification
{
    use Queueable;

    public Question $question;

    /**
     * Create a new notification instance.
     */
    public function __construct(Question $question)
    {
        $this->question = $question;
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
            'type' => 'question_asked',
            'question_id' => $this->question->id,
            'title' => 'New Question in ' . $this->question->course->title,
            'content' => 'Question: ' . $this->question->title . ' - ' . strip_tags($this->question->content),
        ];
    }
}
