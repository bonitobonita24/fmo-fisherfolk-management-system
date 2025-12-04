<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the permissions for the user.
     */
    public function permissions(): HasMany
    {
        return $this->hasMany(Permission::class);
    }

    /**
     * Check if user has permission for a specific module and action.
     *
     * @param string $module
     * @param string $action
     * @return bool
     */
    public function hasPermission(string $module, string $action): bool
    {
        $permission = $this->permissions()
            ->where('module', $module)
            ->first();

        if (!$permission) {
            return false;
        }

        $column = 'can_' . $action;
        return $permission->$column ?? false;
    }

    /**
     * Grant permission for a module and action.
     *
     * @param string $module
     * @param string $action
     * @return void
     */
    public function grantPermission(string $module, string $action): void
    {
        $permission = $this->permissions()->firstOrCreate(['module' => $module]);
        $permission->grantAction($action);
        $permission->save();
    }

    /**
     * Revoke permission for a module and action.
     *
     * @param string $module
     * @param string $action
     * @return void
     */
    public function revokePermission(string $module, string $action): void
    {
        $permission = $this->permissions()->where('module', $module)->first();
        
        if ($permission) {
            $permission->revokeAction($action);
            $permission->save();
        }
    }

    /**
     * Sync all permissions for a user.
     *
     * @param array $permissions
     * @return void
     */
    public function syncPermissions(array $permissions): void
    {
        // Delete existing permissions
        $this->permissions()->delete();

        // Create new permissions
        foreach ($permissions as $module => $actions) {
            $this->permissions()->create([
                'module' => $module,
                'can_create' => $actions['create'] ?? false,
                'can_view' => $actions['view'] ?? false,
                'can_update' => $actions['update'] ?? false,
                'can_delete' => $actions['delete'] ?? false,
            ]);
        }
    }

    /**
     * Check if user is active.
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}

