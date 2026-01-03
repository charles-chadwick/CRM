<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaleLeadProgress extends Base
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sale_leads_progress';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sales_lead_id',
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
        'contacted_at' => 'datetime'
    ];

    /**
     * Get the sales lead that owns the progress record.
     */
    public function salesLead() : BelongsTo
    {
        return $this->belongsTo(SalesLead::class);
    }
}
