<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $seo_image
 * @method static updateOrCreate(null[] $array, array $validated)
 */
class SeoSetting extends Model
{
    protected $table = 'seo_settings';

    protected $fillable = [
        'meta_title',
        'meta_description',
        'meta_keywords',
        'seo_image',
        'og_title',
        'og_description',
        'robots',
        'twitter_card',
        'id',
    ];

    /**
     * Get the latest SEO settings.
     *
     * @return SeoSetting|null
     */
    public static function getLatest(): ?SeoSetting
    {
        return self::latest()->first();
    }
}
