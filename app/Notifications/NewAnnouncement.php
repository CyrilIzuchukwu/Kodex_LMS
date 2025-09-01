<?php

namespace App\Notifications;

use App\Models\Announcements;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewAnnouncement extends Notification
{
    protected Announcements $announcement;

    /**
     * Create a new notification instance.
     */
    public function __construct(Announcements $announcement)
    {
        $this->announcement = $announcement;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('A new announcement has been published.')
            ->view('emails.new_announcement_notification', [
                'announcement' => $this->announcement,
                'notifiable' => $notifiable,
            ]);
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(): array
    {
        return [
            'announcement_id' => $this->announcement->id,
            'title' => $this->announcement->title,
            'content' => $this->announcement->content,
            'attachment_url' => $this->announcement->attachment_url,
        ];
    }
}
