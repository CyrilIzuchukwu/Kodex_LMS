<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static create(array $array)
 * @method static whereIn(string $string, mixed $deleteModuleIds)
 * @method static findOrFail(mixed $id)
 * @method static count()
 * @method static where(string $string, string $module)
 * @property mixed $title
 * @property mixed $course
 * @property mixed $quiz_count
 * @property mixed $quizzes
 * @property mixed $attempts_count
 * @property mixed $id
 */
class Module extends Model
{
    use HasFactory;

    protected $fillable = ['course_id', 'title', 'video_url'];

    public function resources()
    {
        return $this->hasMany(ModuleResource::class);
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class, 'module_id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
