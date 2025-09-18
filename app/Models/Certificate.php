<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static where(string $string, mixed $id)
 * @method static updateOrCreate(array $array, string[] $array1)
 * @property mixed $thumbnail_path
 * @property mixed $certificate_path
 */
class Certificate extends Model
{
    protected $fillable = [
        'user_id',
        'course_enrollment_id',
        'course_id',
        'certificate_id',
        'certificate_path',
        'thumbnail_path'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(CourseEnrollment::class, 'course_enrollment_id');
    }
}
