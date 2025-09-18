<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, string $string1)
 * @property mixed $icon
 * @property mixed $name
 * @property mixed $status
 */
class Gateway extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'icon', 'status'];

    protected $casts = [
        'status' => 'string',
    ];

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset('storage/gateways/' . $this->icon) : null;
    }
}
