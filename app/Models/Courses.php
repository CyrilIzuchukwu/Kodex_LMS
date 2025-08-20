<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Courses extends Model
{
    use HasFactory ,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'course_category_id',
        'title',
        'slug',
        'students_enrolled',
        'price',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    /**
     * Get the courses for this category.
     */
    public function course_category(): BelongsTo
    {
        return $this->belongsTo(CourseCategory::class);
    }
}
