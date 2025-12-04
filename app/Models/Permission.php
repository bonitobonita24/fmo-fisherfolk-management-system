<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Permission extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'module',
        'can_create',
        'can_view',
        'can_update',
        'can_delete',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'can_create' => 'boolean',
        'can_view' => 'boolean',
        'can_update' => 'boolean',
        'can_delete' => 'boolean',
    ];

    /**
     * Available modules in the system.
     *
     * @var array
     */
    public static $modules = [
        'dashboard',
        'fisherfolk',
        'users',
        'reports',
        'import',
        'settings',
    ];

    /**
     * Get the user that owns the permission.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if permission has a specific action.
     *
     * @param string $action
     * @return bool
     */
    public function hasAction(string $action): bool
    {
        $column = 'can_' . $action;
        return $this->$column ?? false;
    }

    /**
     * Grant a specific action.
     *
     * @param string $action
     * @return void
     */
    public function grantAction(string $action): void
    {
        $column = 'can_' . $action;
        $this->$column = true;
    }

    /**
     * Revoke a specific action.
     *
     * @param string $action
     * @return void
     */
    public function revokeAction(string $action): void
    {
        $column = 'can_' . $action;
        $this->$column = false;
    }
}
