<?php

namespace Botble\Vendor\Models;

use Botble\Media\Models\MediaFile;
use Botble\RealEstate\Models\Property;
use Botble\Vendor\Notifications\ResetPasswordNotification;
use Botble\Base\Supports\Gravatar;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Storage;

/**
 * @mixin \Eloquent
 */
class Vendor extends Authenticatable
{
    use Notifiable;
    use HasApiTokens;

    /**
     * @var string
     */
    protected $table = 'vendors';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'avatar_id',
        'dob',
        'phone',
        'description',
        'gender',
        'package_id',
        'package_start_date',
        'package_end_date',
        'package_available_quota',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'dob',
        'package_start_date',
        'package_end_date',
    ];

    /**
     * Send the password reset notification.
     *
     * @param string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function avatar()
    {
        return $this->belongsTo(MediaFile::class)->withDefault();
    }

    /**
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function getAvatarUrlAttribute()
    {
        return $this->avatar->url ? Storage::url($this->avatar->url) : Gravatar::image($this->email);
    }

    /**
     * Always capitalize the first name when we retrieve it
     * @param string $value
     * @return string
     */
    public function getFirstNameAttribute($value)
    {
        return ucfirst($value);
    }

    /**
     * Always capitalize the last name when we retrieve it
     * @param string $value
     * @return string
     */
    public function getLastNameAttribute($value)
    {
        return ucfirst($value);
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return ucfirst($this->first_name) . ' ' . ucfirst($this->last_name);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function properties()
    {
        return $this->morphMany(Property::class, 'author');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function package()
    {
        return $this->belongsTo(Package::class)->withDefault();
    }

    /**
     * @return bool
     */
    public function canPost(): bool
    {
        if (!$this->package_id) {
            return false;
        }

        if (!$this->package_available_quota) {
            return false;
        }

        return $this->package_end_date->gt(now());
    }
}
