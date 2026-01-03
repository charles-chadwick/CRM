<?php

namespace App\Models;

use App\Traits\HasUsers;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Discussion extends Base
{
    use HasUsers;

    public $appends = ['users'];
    /**
     * The attributes that are mass-assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'on',
        'on_type',
        'type',
        'title',
        'status',
        'notes',
        'on_id'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->loadRelations();
        $this->with[] = 'posts';

    }

    /**
     * Get the parent-discussable model (User, Company, or Customer).
     */
    public function discussable() : MorphTo
    {
        return $this->morphTo();
    }

    public function getUsersAttribute()
    {
        return User::whereIn('id', $this->posts()
            ->get()
            ->pluck('created_by_id')
            ->unique())
            ->get();
    }

    /**
     * Get all posts for this discussion.
     */
    public function posts() : HasMany
    {
        return $this->hasMany(DiscussionPost::class);
    }

}

