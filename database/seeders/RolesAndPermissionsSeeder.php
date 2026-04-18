<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        $permissions = [
            'view users', 'create users', 'edit users', 'delete users',
            'view servers', 'create servers', 'edit servers', 'delete servers',
            'view databases', 'create databases', 'edit databases', 'delete databases',
            'view alerts', 'manage alerts',
            'view metrics'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // create roles and assign created permissions
        $roleAdmin = Role::firstOrCreate(['name' => 'Admin']);
        $roleAdmin->givePermissionTo(Permission::all());

        $roleBranchManager = Role::firstOrCreate(['name' => 'Branch Manager']);
        $roleBranchManager->givePermissionTo([
            'view users', 'create users', 'edit users',
            'view servers', 'create servers', 'edit servers',
            'view databases', 'create databases', 'edit databases',
            'view alerts', 'manage alerts',
            'view metrics'
        ]);

        $roleLineManager = Role::firstOrCreate(['name' => 'Line Manager']);
        $roleLineManager->givePermissionTo([
            'view users', 'edit users',
            'view servers', 'view databases', 'view alerts', 'view metrics'
        ]);

        $roleSupervisor = Role::firstOrCreate(['name' => 'Supervisor']);
        $roleSupervisor->givePermissionTo([
            'view users', 'view servers', 'view databases', 'view alerts', 'view metrics'
        ]);

        $roleUser = Role::firstOrCreate(['name' => 'User']);
        $roleUser->givePermissionTo([
            'view servers', 'view databases', 'view alerts', 'view metrics'
        ]);
    }
}
