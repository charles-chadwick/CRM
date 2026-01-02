<?php

namespace App\Traits;

trait Filterable
{

    public function scopeFilter($query, array|string $fields) : void
    {
        if (!is_array($fields)) {
            $fields = [$fields];
        }
        $query->whereIn($fields);
    }
}
