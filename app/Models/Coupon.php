<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, mixed $couponCode)
 * @method static latest()
 * @method static create(array $array)
 * @property mixed $id
 */
class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'value',
        'valid_from',
        'valid_to',
        'is_active',
        'created_at',
        'updated_at',
    ];
}
