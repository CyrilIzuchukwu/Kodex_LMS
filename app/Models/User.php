<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property mixed $role
 * @property mixed $profile
 * @property mixed $profile_photo_path
 * @property mixed $cartItems
 */
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class, 'course_id');
    }

    public function assigned(): HasOne
    {
        return $this->hasOne(Course::class, 'course_id');
    }

    /**
     * @return HasOne|User
     */
    public function profile(): HasOne|User
    {
        return $this->hasOne(UserProfile::class);
    }

    public function questions(): User|HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function questionReplies(): User|HasMany
    {
        return $this->hasMany(QuestionReply::class);
    }

    public function notes(): User|HasMany
    {
        return $this->hasMany(Note::class);
    }

    /**
     * Check if the user has a connected social account for the given provider.
     *
     * @param string $provider
     * @return bool
     */
    public function hasSocialAccount(string $provider): bool
    {
        return !empty($this->social_login_provider) && $this->social_login_provider === $provider;
    }
}
