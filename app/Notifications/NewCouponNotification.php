<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Coupon;

class NewCouponNotification extends Notification
{
    use Queueable;

    protected Coupon $coupon;

    /**
     * Create a new notification instance.
     *
     * @param Coupon $coupon
     * @return void
     */
    public function __construct(Coupon $coupon)
    {
        $this->coupon = $coupon;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array
     */
    public function via(): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification for database storage.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'type' => 'system_update',
            'coupon_id' => $this->coupon->id,
            'code' => $this->coupon->code,
            'value' => $this->coupon->value,
            'valid_from' => $this->coupon->valid_from->toDateTimeString(),
            'valid_to' => $this->coupon->valid_to->toDateTimeString(),
            'title' => 'New Coupon ' . $this->coupon->code . ' Available!',
            'content' => 'A new ' . ($this->coupon->type === 'percentage' ? $this->coupon->value . '% off' : '$' . $this->coupon->value . ' off') . ' coupon (' . $this->coupon->code . ') is now available! Use it between ' . $this->coupon->valid_from->format('M d, Y') . ' and ' . $this->coupon->valid_to->format('M d, Y') . '.'
        ];
    }
}
