<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Server;
use App\Models\Database;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Harys Rifai',
            'email' => 'harys@google.com',
            'password' => Hash::make('xcxcxc'),
        ]);

        Role::create(['name' => 'admin', 'description' => 'Administrator with full access']);
        Role::create(['name' => 'operator', 'description' => 'Operator with limited access']);

        Server::create([
            'name' => 'Production Server 1',
            'hostname' => 'prod-server-1',
            'ip' => '192.168.1.10',
            'os' => 'linux',
            'type' => 'server',
            'cpu_threshold' => 80,
            'ram_threshold' => 80,
            'disk_threshold' => 85,
            'network_threshold' => 100,
            'location' => 'Jakarta DC',
            'is_active' => true,
        ]);

        Server::create([
            'name' => 'Windows App Server',
            'hostname' => 'win-app-server',
            'ip' => '192.168.1.20',
            'os' => 'windows',
            'type' => 'server',
            'cpu_threshold' => 75,
            'ram_threshold' => 80,
            'disk_threshold' => 90,
            'network_threshold' => 50,
            'location' => 'Surabaya DC',
            'is_active' => true,
        ]);

        Database::create([
            'server_id' => 1,
            'name' => 'Main PostgreSQL',
            'type' => 'postgres',
            'connection_name' => 'main_postgres',
            'host' => 'localhost',
            'port' => 5432,
            'database' => 'maindb',
            'active_threshold' => 50,
            'idle_threshold' => 100,
            'lock_threshold' => 5,
            'status' => 'ok',
            'is_active' => true,
        ]);

        Database::create([
            'server_id' => 1,
            'name' => 'Analytics MySQL',
            'type' => 'mysql',
            'connection_name' => 'analytics_mysql',
            'host' => 'localhost',
            'port' => 3306,
            'database' => 'analytics',
            'active_threshold' => 30,
            'idle_threshold' => 50,
            'lock_threshold' => 3,
            'status' => 'ok',
            'is_active' => true,
        ]);
    }
}