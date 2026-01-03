<?php

namespace App\Models;

use App\Traits\IsPerson;
use App\Traits\Searchable;
use App\Traits\Sortable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Permission\Traits\HasRoles;


class User extends Base implements
    HasMedia,
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, MustVerifyEmail;
    use HasFactory, Notifiable, HasRoles, InteractsWithMedia, IsPerson;
    use Searchable, Sortable;

    /**
     * The attributes that are mass-assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'role',
        'first_name',
        'last_name',
        'email',
        'password'
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
     * Get all discussions for this user.
     */
    public function discussions() : MorphMany
    {
        return $this->morphMany(Discussion::class, 'on');
    }

    public function registerMediaConversions(?Media $media = null) : void
    {
        $this->addMediaConversion('avatars')
            ->fit(Fit::Contain, 300, 300)
            ->nonQueued();
    }

    public function registerMediaCollections() : void
    {
        $this->addMediaCollection('avatars')
            ->singleFile();
    }

    public function avatar() : Attribute
    {
        // check to make sure it exists, default if it doesn't
        if (!file_exists($this->getFirstMediaPath('avatars'))) {
            $image = null;
        } else {
            $image = str($this->getFirstMediaUrl('avatars'))->replace('http://127.0.0.1:8000', '');
        }

        return Attribute::make(
            get: function () use ($image) {
                return $image;
            }
        );
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts() : array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }
}
