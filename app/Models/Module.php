<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 * @method static whereIn(string $string, mixed $deleteModuleIds)
 * @method static findOrFail(mixed $id)
 * @method static count()
 */
class Module extends Model
{
    use HasFactory;

    protected $fillable = ['course_id', 'title', 'video_url'];

    public function resources()
    {
        return $this->hasMany(ModuleResource::class);
    }
}
