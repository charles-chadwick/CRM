<?php

namespace App\Models;

use App\Traits\HasUserRelations;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Company extends Base implements HasMedia
{
    use InteractsWithMedia, LogsActivity, HasUserRelations;

    /**
     * The attributes that are mass-assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type',
        'name',
        'notes'
    ];

    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
        $this->loadRelations();
    }

    /**
     * Get the customers for this company.
     */
    public function customers() : HasMany
    {
        return $this->hasMany(Customer::class);
    }

    /**
     * Get all contacts for this company.
     */
    public function contacts() : MorphMany
    {
        return $this->morphMany(Contact::class, 'on');
    }

    /**
     * Get all discussions for this company.
     */
    public function discussions() : MorphMany
    {
        return $this->morphMany(Discussion::class, 'on');
    }

}

