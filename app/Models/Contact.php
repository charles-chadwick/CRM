<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact
{
    use HasFactory, SoftDeletes;

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
}
