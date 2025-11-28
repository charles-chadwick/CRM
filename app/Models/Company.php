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

    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
        $this->with[] = 'created_by';
    }

    public function customers() : HasMany {
        return $this->hasMany(Customer::class);
    }
}
