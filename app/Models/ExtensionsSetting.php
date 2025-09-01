<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static first()
 * @method static create(array $data)
 */
class ExtensionsSetting extends Model
{
    protected $table = 'extensions_settings';

    protected $fillable = [
        'google_tag',
        'smartsupp_key',
        'zoho_salesiq',
        'whatsapp_number',
        'telegram_username',
        'intercom_app_id',
    ];

    /**
     * Get the latest maintenance mode.
     *
     * @return ExtensionsSetting|null
     */
    public static function getLatest(): ?ExtensionsSetting
    {
        return self::latest()->first();
    }
}
