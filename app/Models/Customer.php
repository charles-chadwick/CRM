<?php

namespace App\Models;

use App\Traits\HasUserRelations;
use App\Traits\IsPerson;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

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


    protected function casts() : array
    {
        return [
            'email_verified_at' => 'timestamp',
        ];
    }

    public function contacts() : MorphMany
    {
        return $this->morphMany(Contact::class, 'contactable', 'on', 'on_id');
    }

    public function company() : BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
