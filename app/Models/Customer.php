<?php

namespace App\Models;

use App\Traits\HasUserRelations;
use App\Traits\IsPerson;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Customer extends Base
{
    use HasFactory, HasUserRelations;
    use IsPerson;

    protected $fillable = [
        'company_id',
        'title',
        'prefix',
        'first_name',
        'last_name',
        'suffix',
        'email',
        'email_verified_at',
        'password',
        'remember_token'
    ];

    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
        $this->loadRelations();

    }

    public function company() : BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    protected function casts() : array
    {
        return [
            'email_verified_at' => 'timestamp',
        ];
    }
}
