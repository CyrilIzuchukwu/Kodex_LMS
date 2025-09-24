<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TestEmail extends Mailable
{
    use Queueable, SerializesModels;

    public ?string $test_message;
    public string $recipient_email;

    /**
     * Create a new message instance.
     */
    public function __construct(?string $test_message, string $recipient_email)
    {
        $this->test_message = $test_message ?? 'This is a default test message to confirm that your email configuration is working correctly.';
        $this->recipient_email = $recipient_email;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Test Email',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.test-email',
            with: [
                'test_message' => $this->test_message,
                'recipient_email' => $this->recipient_email,
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
