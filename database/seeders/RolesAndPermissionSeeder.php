<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'view customers',
            'create customers',
            'edit customers',
            'delete customers',
            'view companies',
            'create companies',
            'edit companies',
            'delete companies',
            'view users',
            'create users',
            'edit users',
            'delete users',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        $superAdminRole = Role::create(['name' => UserRole::SuperAdmin]);
        $superAdminRole->givePermissionTo(Permission::all());

        $adminRole = Role::create(['name' => UserRole::Admin]);
        $adminRole->givePermissionTo(Permission::all());

        $managerRole = Role::create(['name' => UserRole::Manager]);
        $managerRole->givePermissionTo([
            'view customers',
            'create customers',
            'edit customers',
            'delete customers',
            'view companies',
            'create companies',
            'edit companies',
            'delete companies',
        ]);

        $salesRepRole = Role::create(['name' => UserRole::SalesRep]);
        $salesRepRole->givePermissionTo([
            'view customers',
            'create customers',
            'edit customers',
            'delete customers'
        ]);

    }
}