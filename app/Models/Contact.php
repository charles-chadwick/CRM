<?php

namespace App\Models;

use App\Traits\HasUserRelations;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Testing\Fluent\Concerns\Has;

class Contact extends Base
{

    use HasUserRelations;

    /**
     * The attributes that are mass-assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'on',
        'on_type',
        'type',
        'is_primary',
        'address_1',
        'address_2',
        'city',
        'state',
        'postal_code',
        'country',
        'notes'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_primary' => 'boolean',
        ];
    }

    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
        $this->loadRelations();
    }

    /**
     * Get the parent-contactable model (Company or Customer).
     */
    public function contactable(): MorphTo
    {
        return $this->morphTo();
    }
}

