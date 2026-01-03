<?php

namespace App\Models;

use App\Traits\HasUsers;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DiscussionPost extends Base
{
    use HasUsers;

    /**
     * The attributes that are mass-assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'discussion_id',
        'status',
        'content',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->loadRelations();
    }

    /**
     * Get the discussion that owns this post.
     */
    public function discussion() : BelongsTo
    {
        return $this->belongsTo(Discussion::class);
    }

}

