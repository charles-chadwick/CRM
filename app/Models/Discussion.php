<?php

namespace App\Models;

use App\Traits\HasUserRelations;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Discussion extends Base
{
    use HasUserRelations;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'on',
        'on_type',
        'type',
        'title',
        'status',
        'notes'
    ];

    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
        $this->loadRelations();

    }

    /**
     * Get the parent-discussable model (User, Company, or Customer).
     */
    public function discussable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get all posts for this discussion.
     */
    public function posts(): HasMany
    {
        return $this->hasMany(DiscussionPost::class);
    }

}

