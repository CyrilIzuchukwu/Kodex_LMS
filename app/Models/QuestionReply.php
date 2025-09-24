<?php

namespace App\Models;

use App\Traits\Likeable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static create(array $array)
 * @property mixed $user_id
 * @property mixed $id
 * @property mixed $content
 * @property mixed $user
 * @property mixed $created_at
 * @property mixed $question_id
 * @property mixed $question
 */
class QuestionReply extends Model
{
    use Likeable;

    protected $fillable = ['question_id', 'user_id', 'content', 'is_instructor'];

    protected $casts = [
        'is_instructor' => 'boolean',
    ];

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getUserLikeStatusAttribute(): ?string
    {
        if (!auth()->check()) {
            return null;
        }

        $like = $this->likes()->where('user_id', auth()->id())->first();
        return $like ? ($like->is_like ? 'liked' : 'disliked') : null;
    }
}
