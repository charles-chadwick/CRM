<?php

namespace App\Models;

use App\Traits\HasUsers;
use Illuminate\Database\Eloquent\Concerns\HasRelationships;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SalesLead extends Base
{
    use HasUsers;

    /**
     * The attributes that are mass-assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'company_id',
        'type',
        'status',
        'title',
        'notes'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'contacted_at' => 'datetime',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->loadRelations();
    }

    /**
     * Get the company that owns the sales lead.
     */
    public function company() : BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the progress records for the sales lead.
     */
    public function progress() : HasMany
    {
        return $this->hasMany(SaleLeadProgress::class);
    }
}
