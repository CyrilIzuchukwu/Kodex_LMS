<?php

namespace App\Notifications;

use App\Models\Question;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class QuestionLikedNotification extends Notification
{
    use Queueable;

    public Question $question;
    public bool $isLike;
    public string $actorName;

    /**
     * Create a new notification instance.
     */
    public function __construct(Question $question, bool $isLike, string $actorName)
    {
        $this->question = $question;
        $this->isLike = $isLike;
        $this->actorName = $actorName;
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
        $action = $this->isLike ? 'liked' : 'disliked';
        return [
            'type' => 'question_asked',
            'question_id' => $this->question->id,
            'title' => 'Your Question Was ' . ucfirst($action),
            'content' => $this->actorName . ' ' . $action . ' your question: "' . $this->question->title . '" in the course "' . $this->question->course->title . '".',
        ];
    }
}
