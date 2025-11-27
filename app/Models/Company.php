<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Base
{
    use HasFactory;

    protected $fillable = [
        'type',
        'name',
        'notes'
    ];

    public function customers() : HasMany {
        return $this->hasMany(Customer::class);
    }
}
