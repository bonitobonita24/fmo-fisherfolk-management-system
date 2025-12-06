<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Fisherfolk extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fisherfolk';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_number';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'boat_owneroperator' => false,
        'capture_fishing' => false,
        'gleaning' => false,
        'vendor' => false,
        'fish_processing' => false,
        'aquaculture' => false,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_number',
        'full_name',
        'date_of_birth',
        'address',
        'sex',
        'image',
        'signature',
        'rsbsa',
        'contact_number',
        'boat_owneroperator',
        'capture_fishing',
        'gleaning',
        'vendor',
        'fish_processing',
        'aquaculture',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'date_of_birth' => 'date',
        'boat_owneroperator' => 'boolean',
        'capture_fishing' => 'boolean',
        'gleaning' => 'boolean',
        'vendor' => 'boolean',
        'fish_processing' => 'boolean',
        'aquaculture' => 'boolean',
        'date_registered' => 'datetime',
        'date_updated' => 'datetime',
    ];

    /**
     * Status constants
     */
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['image_url', 'signature_url', 'age', 'categories'];

    /**
     * Laravel 11+ timestamp column names
     */
    const CREATED_AT = 'date_registered';
    const UPDATED_AT = 'date_updated';

    /**
     * Get the image URL attribute.
     *
     * @return string
     */
    public function getImageUrlAttribute(): string
    {
        return $this->image 
            ? asset('storage/uploads/' . $this->image)
            : asset('images/placeholder.png');
    }

    /**
     * Get the signature URL attribute.
     *
     * @return string
     */
    public function getSignatureUrlAttribute(): string
    {
        return $this->signature
            ? asset('storage/uploads/' . $this->signature)
            : asset('images/signature-placeholder.png');
    }

    /**
     * Get the age attribute.
     *
     * @return int
     */
    public function getAgeAttribute(): int
    {
        return $this->date_of_birth->age;
    }

    /**
     * Get all active categories for this fisherfolk.
     *
     * @return array
     */
    public function getCategoriesAttribute(): array
    {
        $categories = [];
        
        if ($this->boat_owneroperator) {
            $categories[] = 'Boat Owner/Operator';
        }
        if ($this->capture_fishing) {
            $categories[] = 'Capture Fishing';
        }
        if ($this->gleaning) {
            $categories[] = 'Gleaning';
        }
        if ($this->vendor) {
            $categories[] = 'Vendor';
        }
        if ($this->fish_processing) {
            $categories[] = 'Fish Processing';
        }
        if ($this->aquaculture) {
            $categories[] = 'Aquaculture';
        }
        
        return $categories;
    }

    /**
     * Get the age group for this fisherfolk.
     *
     * @return string
     */
    public function getAgeGroup(): string
    {
        $age = $this->age;
        
        if ($age < 26) return '18-25';
        if ($age < 36) return '26-35';
        if ($age < 46) return '36-45';
        if ($age < 56) return '46-55';
        if ($age < 66) return '56-65';
        
        return '66+';
    }

    /**
     * Scope a query to filter by barangay.
     */
    public function scopeByBarangay($query, string $barangay)
    {
        return $query->where('address', $barangay);
    }

    /**
     * Scope a query to filter by sex.
     */
    public function scopeBySex($query, string $sex)
    {
        return $query->where('sex', $sex);
    }

    /**
     * Scope a query to search by name or ID.
     */
    public function scopeSearch($query, string $search)
    {
        return $query->where('full_name', 'like', "%{$search}%")
                     ->orWhere('id_number', 'like', "%{$search}%");
    }

    /**
     * Get all renewals for this fisherfolk.
     */
    public function renewals(): HasMany
    {
        return $this->hasMany(FisherfolkRenewal::class, 'fisherfolk_id', 'id_number');
    }

    /**
     * Get status history for this fisherfolk.
     */
    public function statusHistory(): HasMany
    {
        return $this->hasMany(FisherfolkStatusHistory::class, 'fisherfolk_id', 'id_number');
    }

    /**
     * Check if fisherfolk is active.
     */
    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    /**
     * Check if fisherfolk is inactive.
     */
    public function isInactive(): bool
    {
        return $this->status === self::STATUS_INACTIVE;
    }

    /**
     * Check if fisherfolk has renewed in a given year.
     */
    public function hasRenewedInYear(int $year): bool
    {
        return $this->renewals()->where('renewal_year', $year)->exists();
    }

    /**
     * Get latest renewal.
     */
    public function getLatestRenewal()
    {
        return $this->renewals()->latest('renewal_date')->first();
    }

    /**
     * Record a renewal for this fisherfolk.
     */
    public function recordRenewal(?int $userId = null, ?string $notes = null): FisherfolkRenewal
    {
        $renewal = $this->renewals()->create([
            'renewal_date' => Carbon::now(),
            'renewal_year' => Carbon::now()->year,
            'notes' => $notes,
            'processed_by' => $userId,
        ]);

        // Update status to active if inactive
        if ($this->isInactive()) {
            $this->updateStatus(self::STATUS_ACTIVE, FisherfolkStatusHistory::REASON_RENEWAL, $userId, $notes);
        }

        return $renewal;
    }

    /**
     * Update status with history tracking.
     */
    public function updateStatus(string $newStatus, string $reason = 'manual', ?int $userId = null, ?string $notes = null): void
    {
        $oldStatus = $this->status;

        if ($oldStatus !== $newStatus) {
            $this->statusHistory()->create([
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
                'reason' => $reason,
                'notes' => $notes,
                'changed_by' => $userId,
            ]);

            $this->update(['status' => $newStatus]);
        }
    }

    /**
     * Mark as inactive.
     */
    public function markInactive(string $reason = 'manual', ?int $userId = null, ?string $notes = null): void
    {
        $this->updateStatus(self::STATUS_INACTIVE, $reason, $userId, $notes);
    }

    /**
     * Mark as active.
     */
    public function markActive(string $reason = 'manual', ?int $userId = null, ?string $notes = null): void
    {
        $this->updateStatus(self::STATUS_ACTIVE, $reason, $userId, $notes);
    }

    /**
     * Scope for active fisherfolk.
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    /**
     * Scope for inactive fisherfolk.
     */
    public function scopeInactive($query)
    {
        return $query->where('status', self::STATUS_INACTIVE);
    }

    /**
     * Scope for fisherfolk registered in a specific year.
     */
    public function scopeRegisteredInYear($query, int $year)
    {
        return $query->whereYear('date_registered', $year);
    }
}
