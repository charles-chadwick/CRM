<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Sortable
{
    public function scopeSort(Builder $query) : void
    {
        $query->orderBy(request('sort_by', 'created_at'), request('sort_direction', 'desc'));
    }
}