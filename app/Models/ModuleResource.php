<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static create(array $array)
 * @method static where(string $string, mixed $moduleId)
 */
class ModuleResource extends Model
{
    use HasFactory;

    protected $fillable = ['module_id', 'resource_url'];

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }
}
