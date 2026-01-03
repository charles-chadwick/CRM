<?php

namespace App\Models;

use App\Traits\HasContacts;
use App\Traits\HasDiscussions;
use App\Traits\HasUsers;
use App\Traits\Searchable;
use App\Traits\Sortable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Company extends Base implements HasMedia
{
    use InteractsWithMedia, HasUsers;
    use Sortable, Searchable;
    use HasDiscussions, HasContacts;

    /**
     * The attributes that are mass-assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'company_type_id',
        'name',
        'notes'
    ];

    protected $appends = ['logo'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->loadRelations();
        $this->with[] = 'companyType';
        $this->withCount[] = 'customers';
    }

    public function toSelect() : array
    {
        return $this->toArray();
    }

    /**
     * Get the company type for this company.
     */
    public function companyType() : BelongsTo
    {
        return $this->belongsTo(CompanyType::class);
    }

    /**
     * Get the customers for this company.
     */
    public function customers() : HasMany
    {
        return $this->hasMany(Customer::class);
    }


    public function registerMediaConversions(?Media $media = null) : void
    {
        $this->addMediaConversion('logo')
            ->fit(Fit::Contain, 300, 300)
            ->nonQueued();
    }

    public function registerMediaCollections() : void
    {
        $this->addMediaCollection('logo')
            ->singleFile();
    }

    public function logo() : Attribute
    {
        // check to make sure it exists, default if it doesn't
        if (!file_exists($this->getFirstMediaPath('logo'))) {
            $image = null;
        } else {
            $image = url(str($this->getFirstMediaUrl('logo')));
        }

        return Attribute::make(
            get: function () use ($image) {
                return $image;
            }
        );
    }

}

