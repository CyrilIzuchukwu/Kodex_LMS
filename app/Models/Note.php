<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static where(string $string, $id)
 * @method static create(array $array)
 * @property mixed $user_id
 * @property mixed $id
 * @property mixed $title
 * @property mixed $content
 * @property mixed $module
 * @property mixed $created_at
 */
class Note extends Model
{
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
}
