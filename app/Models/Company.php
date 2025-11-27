<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Base
{
    use HasFactory;

    protected $fillable = [
        'type',
        'name',
        'notes'
    ];
}
