<?php

namespace App\Mail;

use App\Models\Course;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CoursePurchasedConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public $courses;
    public Transaction $payment;

    /**
     * Create a new message instance.
     */
    public function __construct(Transaction $payment)
    {
        $this->user = $payment->user;
        $this->payment = $payment;

        // Decode cart_items JSON and fetch Course models
        $cartItems = json_decode($payment->cart_items, true) ?? [];
        $courseIds = array_column($cartItems, 'course_id');
        $this->courses = Course::whereIn('id', $courseIds)->with('category')->get();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Course Purchased Confirmation',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.course-purchased-confirmation',
            with: [
                'payment' => $this->payment,
                'user' => $this->user,
                'courses' => $this->courses
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
