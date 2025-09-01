<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static firstOrCreate(array $array)
 */
class MaintenanceMode extends Model
{
    protected $table = 'maintenance_modes';

    protected $fillable = [
        'maintenance_mode',
        'maintenance_message',
        'maintenance_end',
    ];

    protected $casts = [
        'maintenance_mode' => 'boolean',
        'maintenance_end' => 'datetime',
    ];

    /**
     * Get the latest maintenance mode.
     *
     * @return MaintenanceMode|null
     */
    public static function getLatest(): ?MaintenanceMode
    {
        return self::latest()->first();
    }
}
