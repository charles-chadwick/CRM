<?php

namespace App\Traits;

trait Searchable
{
    public function scopeSearch($query, string|array $fields)
    {
        $search = request('search');
        if ($search == "") return $query;
        if (!is_array($fields)) {
            $fields = [$fields];
        }
        return $query->when($search !== "", fn($query) => $query->whereAny($fields, 'LIKE', '%'.$search.'%'));
    }
}