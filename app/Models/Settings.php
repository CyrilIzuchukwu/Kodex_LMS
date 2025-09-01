<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static firstOrNew()
 */
class Settings extends Model
{
    protected $table = 'settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'site_name',
        'site_email',
        'site_phone',
        'site_address',
        'site_fb',
        'site_instagram',
        'site_linkedin',
        'site_youtube',
    ];

    /**
     * Get the latest Site settings.
     *
     * @return Settings|null
     */
    public static function getLatest(): ?Settings
    {
        return self::latest()->first();
    }
}
