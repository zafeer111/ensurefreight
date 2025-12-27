<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create the "super-admin" role
        $superAdminRole = Role::create([
            'name' => 'super-admin',
            'guard_name' => 'filament'
        ]);

        // Create the "admin-users.update" permission
        $permission1 = Permission::create([
            'name' => 'admin-users.update',
            'guard_name' => 'filament'
        ]);

        // Create the "permissions.update" permission
        $permission2 = Permission::create([
            'name' => 'permissions.update',
            'guard_name' => 'filament'
        ]);

        // Assign the permissions to the "super-admin" role
        $superAdminRole->givePermissionTo([$permission1, $permission2]);

        // Alternatively, set up a one-to-one relationship (1 role to 1 permission and 1 role to 2 permissions)
        $superAdminRole->permissions()->sync([$permission1->id, $permission2->id]);
    }
}
