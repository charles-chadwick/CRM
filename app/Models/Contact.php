<?php

namespace App\Models;

use App\Enums\ContactType;
use App\Traits\HasUserRelations;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Contact extends Base
{

    use HasUserRelations;

    /**
     * The attributes that are mass-assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'on_id',
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
            'type'       => ContactType::class
        ];
    }

    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
        $this->loadRelations();
    }

    public function contactable() : MorphTo
    {
        return $this->morphTo('contactable', 'on_type', 'on_id');
    }

}

