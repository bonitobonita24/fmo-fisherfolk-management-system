<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Super Admin user
        $admin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@fmo.gov.ph',
            'password' => Hash::make('password'),
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        // Grant all permissions to admin
        foreach (Permission::$modules as $module) {
            Permission::create([
                'user_id' => $admin->id,
                'module' => $module,
                'can_create' => true,
                'can_view' => true,
                'can_update' => true,
                'can_delete' => true,
            ]);
        }

        // Create a viewer user (read-only)
        $viewer = User::create([
            'name' => 'Viewer User',
            'email' => 'viewer@fmo.gov.ph',
            'password' => Hash::make('password'),
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        // Grant view-only permissions to viewer
        foreach (Permission::$modules as $module) {
            Permission::create([
                'user_id' => $viewer->id,
                'module' => $module,
                'can_create' => false,
                'can_view' => true,
                'can_update' => false,
                'can_delete' => false,
            ]);
        }

        // Create a data entry user
        $dataEntry = User::create([
            'name' => 'Data Entry Staff',
            'email' => 'dataentry@fmo.gov.ph',
            'password' => Hash::make('password'),
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        // Grant specific permissions to data entry
        Permission::create([
            'user_id' => $dataEntry->id,
            'module' => 'dashboard',
            'can_create' => false,
            'can_view' => true,
            'can_update' => false,
            'can_delete' => false,
        ]);

        Permission::create([
            'user_id' => $dataEntry->id,
            'module' => 'fisherfolk',
            'can_create' => true,
            'can_view' => true,
            'can_update' => true,
            'can_delete' => false,
        ]);

        Permission::create([
            'user_id' => $dataEntry->id,
            'module' => 'reports',
            'can_create' => false,
            'can_view' => true,
            'can_update' => false,
            'can_delete' => false,
        ]);

        Permission::create([
            'user_id' => $dataEntry->id,
            'module' => 'import',
            'can_create' => true,
            'can_view' => true,
            'can_update' => false,
            'can_delete' => false,
        ]);
    }
}
