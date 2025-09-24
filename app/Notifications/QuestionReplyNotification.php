<?php

namespace App\Notifications;

use App\Models\QuestionReply;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class QuestionReplyNotification extends Notification
{
    use Queueable;

    public QuestionReply $reply;

    /**
     * Create a new notification instance.
     */
    public function __construct(QuestionReply $reply)
    {
        $this->reply = $reply;
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
            'type' => 'question_reply',
            'question_id' => $this->reply->question_id,
            'reply_id' => $this->reply->id,
            'title' => 'New Reply to Your Question',
            'content' => 'Reply: ' . strip_tags($this->reply->content),
        ];
    }
}
