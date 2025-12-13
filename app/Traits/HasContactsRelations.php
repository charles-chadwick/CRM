<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\MorphTo;

trait HasContactsRelations
{

    /**
     * Get the parent-contactable model (Company or Customer).
     */
    public function contactable(): MorphTo
    {
        return $this->morphTo('contactable', 'on_type', 'on_id');
    }
}