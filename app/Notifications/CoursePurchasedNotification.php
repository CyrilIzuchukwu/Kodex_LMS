<?php

namespace App\Notifications;

use App\Models\Course;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CoursePurchasedNotification extends Notification
{
    use Queueable;

    public User $user;
    public $courses;
    public Transaction $payment;

    /**
     * Create a new notification instance.
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
            'payment_id' => $this->payment->id,
            'title' => 'Your Course Purchase Confirmation',
            'content' => 'Thank you, ' . $this->user->name . ', for purchasing ' . $this->courses->count() . ' course(s) on ' . $this->payment->created_at->format('F j, Y') . '. Transaction ID: ' . $this->payment->transaction_reference . '.',
            'course_count' => $this->courses->count(),
            'transaction_reference' => $this->payment->transaction_reference,
            'purchase_date' => $this->payment->created_at->format('F j, Y'),
        ];
    }
}
