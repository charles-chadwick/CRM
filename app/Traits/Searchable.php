<?php

namespace App\Traits;

trait Searchable
{
    public function scopeSearch($query, string|array $fields, string $search)
    {
        if (!is_array($fields)) {
            $fields = [$fields];
        }
        return $query->whereAny($fields, 'LIKE', '%'.$search.'%');
    }
}