<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static first()
 * @property mixed $provider
 * @property bool|mixed $status
 * @property mixed $from_name
 * @property mixed $from_email
 * @property mixed $host
 * @property mixed $port
 * @property mixed $encryption
 * @property mixed $username
 * @property mixed $password
 * @property mixed|null $api_public
 * @property mixed|null $api_secret
 */
class EmailSetting extends Model
{
    protected $fillable = [
        'provider',
        'status',
        'host',
        'port',
        'encryption',
        'username',
        'password',
        'api_public',
        'api_secret',
        'from_name',
        'from_email',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * Get the latest email setting.
     *
     * @return EmailSetting|null
     */
    public static function getLatest(): ?EmailSetting
    {
        return self::latest()->first();
    }
}
