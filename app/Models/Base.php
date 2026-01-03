<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

abstract class Base extends Model
{
    use SoftDeletes;



    /**
     * Boot the model.
     *
     * @return void
     */
    protected static function boot() : void
    {
        parent::boot();

        static::creating(function ($model) {
            if (auth()->check()) {
                $model->created_by_id = auth()->id();
                $model->updated_by_id = auth()->id();
            }
        });

        static::updating(function ($model) {
            if (auth()->check()) {
                $model->updated_by_id = auth()->id();
            }
        });

        static::deleting(function ($model) {
            if (auth()->check()) {
                $model->deleted_by_id = auth()->id();
                $model->save();
            }
        });

        // Activity logging
        static::created(function ($model) {
            if (auth()->check()) {
                activity()
                    ->performedOn($model)
                    ->causedBy(auth()->user())
                    ->useLog('Database')
                    ->log('Created');
            }
        });

        static::updated(function ($model) {
            if (auth()->check()) {
                $changes = $model->getChanges();
                $original = $model->getOriginal();
                $properties = [
                    'attributes' => $changes,
                    'old'        => array_intersect_key($original, $changes)
                ];

                activity()
                    ->performedOn($model)
                    ->causedBy(auth()->user())
                    ->withProperties($properties)
                    ->useLog('Database')
                    ->log('Updated');
            }
        });

        static::deleted(function ($model) {
            if (auth()->check()) {
                activity()
                    ->performedOn($model)
                    ->causedBy(auth()->user())
                    ->useLog('Database')
                    ->log('Deleted');
            }
        });

        static::restored(function ($model) {
            if (auth()->check()) {
                activity()
                    ->performedOn($model)
                    ->causedBy(auth()->user())
                    ->useLog('Database')
                    ->log('Restored');
            }
        });

        static::forceDeleted(function ($model) {
            if (auth()->check()) {
                activity()
                    ->performedOn($model)
                    ->causedBy(auth()->user())
                    ->useLog('Database')
                    ->log('Permanently deleted');
            }
        });
    }


    /**
     * Load default relationships.
     *
     * @return void
     */
    protected static function booted() : void
    {
        parent::booted();

        if (static::class !== User::class) {
            static::retrieved(function ($model) {
                $model->loadMissing([
                    'created_by',
                    'updated_by',
                    'deleted_by'
                ]);
            });
        }
    }

    /**
     * Get the fillable attributes.
     *
     * @return array
     */
    public function getFillable() : array
    {
        return array_merge(
            $this->fillable,
            [
                'created_at',
                'updated_at',
                'deleted_at'
            ]
        );
    }

    public function getCasts() : array {
        return array_merge($this->casts, [
            'created_at' => 'datetime:m/d/Y h:i A',
            'updated_at' => 'datetime:m/d/Y h:i A',
            'deleted_at' => 'datetime:m/d/Y h:i A'
        ]);
    }

    /**
     * Get the user who created this record.
     *
     * @return BelongsTo
     */
    public function created_by() : BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    /**
     * Get the user who last updated this record.
     *
     * @return BelongsTo
     */
    public function updated_by() : BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by_id');
    }

    /**
     * Get the user who deleted this record.
     *
     * @return BelongsTo
     */
    public function deleted_by() : BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by_id');
    }

}
