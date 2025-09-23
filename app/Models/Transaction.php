<?php

namespace App\Models;

use Illuminate\Contracts\Database\Query\Expression;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static create(array $validated)
 * @method static where(string $string, int $id)
 * @method static findOrFail(string|null $payment)
 * @method static select(Expression|\Illuminate\Database\Query\Expression $raw, Expression|\Illuminate\Database\Query\Expression $raw1, Expression|\Illuminate\Database\Query\Expression $raw2, Expression|\Illuminate\Database\Query\Expression $raw3)
 * @method static selectRaw(string $string)
 * @property mixed $payment_method
 * @property mixed $id
 * @property mixed $user
 * @property mixed $cart_items
 * @property mixed $transaction_reference
 * @property mixed $created_at
 * @property mixed $user_id
 * @property mixed $status
 * @property mixed $courses
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
        'status',
        'created_at',
        'updated_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
