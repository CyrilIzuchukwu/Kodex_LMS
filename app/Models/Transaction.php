<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static create(array $validated)
 * @method static where(string $string, int $id)
 * @method static findOrFail(string|null $payment)
 * @property mixed $payment_method
 * @property mixed $id
 * @property mixed $user
 * @property mixed $cart_items
 * @property mixed $transaction_reference
 * @property mixed $created_at
 */
class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cart_items',
        'subtotal',
        'charges',
        'discount',
        'total',
        'amount',
        'coupon',
        'payment_method',
        'channel',
        'transaction_reference',
        'status'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
