<?php

namespace App\Mail;

use App\Models\Course;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CourseCreated extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public Course $courses;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, Course $courses)
    {
        $this->user = $user;
        $this->courses = $courses;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Course Created',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.course-created',
            with: [
                'user' => $this->user,
                'course' => $this->courses,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
