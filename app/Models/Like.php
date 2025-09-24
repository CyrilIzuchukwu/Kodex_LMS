<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @method static where(array $array)
 * @method static create(array $array)
 */
class Like extends Model
{
    protected $fillable = [
        'user_id',
        'likeable_type',
        'likeable_id',
        'is_like'
    ];

    protected $casts = [
        'is_like' => 'boolean'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function likeable(): MorphTo
    {
        return $this->morphTo();
    }
}
