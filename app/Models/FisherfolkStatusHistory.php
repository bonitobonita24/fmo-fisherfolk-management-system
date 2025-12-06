<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FisherfolkStatusHistory extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fisherfolk_status_history';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fisherfolk_id',
        'old_status',
        'new_status',
        'reason',
        'notes',
        'changed_by',
    ];

    /**
     * Reason constants
     */
    const REASON_MANUAL = 'manual';
    const REASON_AUTO_INACTIVE = 'auto_inactive_january';
    const REASON_RENEWAL = 'renewal';
    const REASON_NEW_REGISTRATION = 'new_registration';

    /**
     * Get the fisherfolk that owns this status history.
     */
    public function fisherfolk(): BelongsTo
    {
        return $this->belongsTo(Fisherfolk::class, 'fisherfolk_id', 'id_number');
    }

    /**
     * Get the user who changed the status.
     */
    public function changedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
