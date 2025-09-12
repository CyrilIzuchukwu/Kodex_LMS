<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static create(array $array)
 * @method static count()
 * @method static orderBy(string $string)
 * @method static where(string $string, string $slug)
 * @method static whereIn(string $string, array $courseIds)
 * @property mixed $id
 * @property mixed $outcomes
 * @property mixed $media
 * @property mixed $video_url
 * @property mixed $title
 * @property mixed $subtitle
 * @property mixed $slug
 * @property mixed $category_id
 * @property mixed $price
 * @property mixed $summary
 */
class Course extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'subtitle',
        'slug',
        'category_id',
        'price',
        'summary',
        'video_url',
        'user_id',
        'status'
    ];

    public function outcomes()
    {
        return $this->hasMany(CourseOutcome::class, 'course_id');
    }

    public function media()
    {
        return $this->hasOne(CourseMedia::class, 'course_id');
    }

    public function modules()
    {
        return $this->hasMany(Module::class, 'course_id', 'id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(CourseCategory::class, 'category_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function profile()
    {
        return $this->hasOne(UserProfile::class, 'course_id');
    }

    public function enrollments()
    {
        return $this->hasMany(CourseEnrollment::class, 'course_id');
    }

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
}
