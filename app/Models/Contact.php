<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Contact extends Base
{
    use HasFactory;

    protected $fillable = [
        'on',
        'on_id',
        'type',
        'phone',
        'fax',
        'email',
        'address_1',
        'address_2',
        'city',
        'state',
        'postal_code',
        'country',
        'notes',
    ];

    public function contactable() : MorphTo
    {
        return $this->morphTo('contactable', 'on', 'on_id');
    }


}
