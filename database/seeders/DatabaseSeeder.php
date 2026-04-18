<?php

namespace Database\Seeders;

use App\Models\Organisation;
use App\Models\Branch;
use App\Models\Server;
use App\Models\Database;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RolesAndPermissionsSeeder::class);

        $org = Organisation::updateOrCreate(['name' => 'Default Organisation'], ['is_active' => true]);
        $branch = Branch::updateOrCreate(['organisation_id' => $org->id, 'name' => 'Main Branch'], ['is_active' => true]);

        $admin = User::updateOrCreate(
            ['email' => 'harys@google.com'],
            [
                'name' => 'Default Admin',
                'password' => Hash::make('xcxcxc'),
                'organisation_id' => $org->id,
                'branch_id' => $branch->id,
                'is_active' => true,
            ]
        );
        $admin->assignRole('Admin');

        $manager = User::updateOrCreate(
            ['email' => 'manager@google.com'],
            [
                'name' => 'Branch Manager User',
                'password' => Hash::make('password'),
                'organisation_id' => $org->id,
                'branch_id' => $branch->id,
                'manager_id' => $admin->id,
                'is_active' => true,
            ]
        );
        $manager->assignRole('Branch Manager');

        $server = Server::updateOrCreate(
            ['hostname' => 'prod-server-1'],
            [
                'name' => 'Production Server 1',
                'ip' => '192.168.1.10',
                'os' => 'linux',
                'type' => 'server',
                'cpu_threshold' => 80,
                'ram_threshold' => 80,
                'disk_threshold' => 85,
                'network_threshold' => 100,
                'location' => 'Jakarta DC',
                'organisation_id' => $org->id,
                'branch_id' => $branch->id,
                'is_active' => true,
            ]
        );

        Database::updateOrCreate(
            ['connection_name' => 'main_postgres'],
            [
                'server_id' => $server->id,
                'name' => 'Main PostgreSQL',
                'type' => 'postgres',
                'host' => 'localhost',
                'port' => 5432,
                'database' => 'maindb',
                'active_threshold' => 50,
                'idle_threshold' => 100,
                'lock_threshold' => 5,
                'status' => 'ok',
                'organisation_id' => $org->id,
                'branch_id' => $branch->id,
                'is_active' => true,
            ]
        );
    }
}