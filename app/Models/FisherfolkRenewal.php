<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FisherfolkRenewal extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fisherfolk_renewals';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fisherfolk_id',
        'renewal_date',
        'renewal_year',
        'notes',
        'processed_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'renewal_date' => 'date',
        'renewal_year' => 'integer',
    ];

    /**
     * Get the fisherfolk that owns this renewal.
     */
    public function fisherfolk(): BelongsTo
    {
        return $this->belongsTo(Fisherfolk::class, 'fisherfolk_id', 'id_number');
    }

    /**
     * Get the user who processed this renewal.
     */
    public function processedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
    }
}
