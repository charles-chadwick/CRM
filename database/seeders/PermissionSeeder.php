<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // User permissions
            'view users',
            'create users',
            'edit users',
            'delete users',

            // Role and permission management
            'view roles',
            'create roles',
            'edit roles',
            'delete roles',
            'assign roles',
            'view permissions',
            'assign permissions',

            // company management
            'view companies',
            'create companies',
            'edit companies',
            'delete companies',

            // customer management
            'view customers',
            'create customers',
            'edit customers',
            'delete customers',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Create roles and assign permissions
        $admin = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        $admin->givePermissionTo(Permission::all());

        $manager = Role::firstOrCreate(['name' => 'Manager', 'guard_name' => 'web']);
        $manager->givePermissionTo([
            // company management
            'view companies',
            'create companies',
            'edit companies',
            'delete companies',

            // customer management
            'view customers',
            'create customers',
            'edit customers',
            'delete customers',
        ]);

        $salesRep = Role::firstOrCreate(['name' => 'Sales Rep', 'guard_name' => 'web']);
        $salesRep->givePermissionTo([
            // company management
            'view companies',

            // customer management
            'view customers',
            'create customers',
            'edit customers',
            'delete customers',
        ]);
    }
}
