<?php

namespace App\Models;

use App\Traits\HasUserRelations;
use App\Traits\IsPerson;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

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

    public function __construct()
    {
        parent::__construct();
        $this->loadRelations();

    }

    protected function casts() : array
    {
        return [
            'email_verified_at' => 'timestamp',
        ];
    }

    public function contact() : MorphOne
    {
        return $this->morphOne(Contact::class, 'contactable', 'on', 'on_id');
    }

    public function company() : BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
