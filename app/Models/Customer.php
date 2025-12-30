<?php

namespace App\Models;

use App\Traits\HasContacts;
use App\Traits\HasUsers;
use App\Traits\IsPerson;
use App\Traits\Orderable;
use App\Traits\Searchable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Permission\Traits\HasRoles;

class Customer extends Base implements
    HasMedia,
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, MustVerifyEmail;
    use Notifiable, HasRoles, InteractsWithMedia, HasUsers;
    use Orderable, IsPerson, HasContacts, Searchable;

    /**
     * The attributes that are mass-assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'company_id',
        'title',
        'prefix',
        'first_name',
        'last_name',
        'suffix',
        'email',
        'password',
        'email_verified_at',
        'remember_token'
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
    protected function casts() : array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->loadRelations();
    }

    /**
     * Get the company that owns this customer.
     */
    public function company() : BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get all discussions for this customer.
     */
    public function discussions() : MorphMany
    {
        return $this->morphMany(Discussion::class, 'contactable');
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
            $image = url(str($this->getFirstMediaUrl('avatars')));
        }

        return Attribute::make(
            get: function () use ($image) {
                return $image;
            }
        );
    }
}

