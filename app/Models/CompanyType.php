<?php

namespace App\Models;

use App\Traits\Orderable;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CompanyType extends Base
{
    use Orderable, Searchable;

    /**
     * The attributes that are mass-assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Get the companies for this company type.
     */
    public function companies(): HasMany
    {
        return $this->hasMany(Company::class);
    }
    
    public function toSelect() : array {
        return $this->get()
            ->map(function ($item) {
                return [
                    'value' => $item->id,
                    'label' => $item->name
                ];
            })
            ->toArray();
    }
}
