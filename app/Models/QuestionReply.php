<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static create(array $array)
 * @property mixed $user_id
 * @property mixed $id
 * @property mixed $content
 * @property mixed $user
 * @property mixed $created_at
 */
class QuestionReply extends Model
{
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
}
