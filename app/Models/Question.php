<?php

namespace App\Models;

use App\Traits\Likeable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static where(string $string, $id)
 * @method static create(array $array)
 * @property mixed $user_id
 * @property mixed $id
 * @property mixed $title
 * @property mixed $content
 * @property mixed $user
 * @property mixed $created_at
 * @property mixed $module
 * @property mixed $replies
 * @property mixed $course
 */
class Question extends Model
{
    use Likeable;

    protected $fillable = ['course_id', 'module_id', 'user_id', 'title', 'content'];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function replies(): HasMany
    {
        return $this->hasMany(QuestionReply::class, 'question_id', 'id');
    }
}
