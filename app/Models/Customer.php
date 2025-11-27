<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

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
        'remember_token',
        'created_by_id',
        'updated_by_id',
        'deleted_by_id',
    ];

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
