<?php

namespace App\Traits;

use App\Models\Like;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @method morphMany(string $class, string $string)
 */
trait Likeable
{
    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function getLikesCountAttribute(): int
    {
        return $this->likes()->where('is_like', true)->count();
    }

    public function getDislikesCountAttribute(): int
    {
        return $this->likes()->where('is_like', false)->count();
    }

    public function getUserLikeStatusAttribute(): ?string
    {
        if (!auth()->check()) {
            return null;
        }

        $like = $this->likes()->where('user_id', auth()->id())->first();

        if (!$like) {
            return null;
        }

        return $like->is_like ? 'liked' : 'disliked';
    }

    public function isLikedBy($userId): bool
    {
        return $this->likes()
            ->where('user_id', $userId)
            ->where('is_like', true)
            ->exists();
    }

    public function isDislikedBy($userId): bool
    {
        return $this->likes()
            ->where('user_id', $userId)
            ->where('is_like', false)
            ->exists();
    }
}
