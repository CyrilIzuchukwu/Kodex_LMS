<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static where(string $string, int|string|null $user_id)
 * @method static create(array $array)
 */
class CourseEnrollment extends Model
{
    use HasFactory;

    public $fillable = [
        'course_id',
        'user_id',
        'progress',
        'lessons_completed',
        'last_accessed',
        'module_id',
        'status',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'course_id' => 'integer',
        'user_id' => 'integer',
        'last_accessed' => 'datetime'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function passed_quizzes()
    {
        return $this->hasManyThrough(QuizAttempt::class, Quiz::class, 'module_id', 'quiz_id', 'module_id');
    }

    public function certifications(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }

    public function getModulesCountAttribute()
    {
        return $this->course ? $this->course->modules()->count() : 0;
    }
}
