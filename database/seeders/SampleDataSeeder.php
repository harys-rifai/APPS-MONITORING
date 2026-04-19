<?php

namespace Database\Seeders;

use App\Models\Organisation;
use App\Models\Branch;
use App\Models\Server;
use App\Models\Database;
use App\Models\User;
use App\Models\Alert;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class SampleDataSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $statuses = ['ok', 'warning', 'critical'];

        // 1. Create 40 Organisations
        $organisations = [];
        for ($i = 1; $i <= 40; $i++) {
            $org = Organisation::create([
                'name' => "Organisation $i - {$faker->company}",
                'location' => $faker->city . ', ' . $faker->country,
                'is_active' => true,
                'created_by' => 1,
            ]);
            $organisations[] = $org;
        }

        // 2. Create 40 Branches
        $branches = [];
        for ($i = 1; $i <= 40; $i++) {
            $branch = Branch::create([
                'organisation_id' => $organisations[array_rand($organisations)]->id,
                'name' => "Branch BR{$i}",
                'location' => $faker->city . ', Branch Location',
                'is_active' => true,
                'created_by' => 1,
            ]);
            $branches[] = $branch;
        }

        // 3. Create 40 Servers
        $servers = [];
        for ($i = 1; $i <= 40; $i++) {
            $server = Server::create([
                'organisation_id' => $organisations[array_rand($organisations)]->id,
                'branch_id' => $branches[array_rand($branches)]->id,
                'name' => "Server-SV{$i}",
                'hostname' => 'server' . $i . '.example.com',
                'ip' => $faker->ipv4,
                'os' => $faker->randomElement(['Linux', 'Windows', 'macOS']),
                'type' => $faker->randomElement(['web', 'db', 'both']),
                'cpu_threshold' => $faker->numberBetween(70, 95),
                'ram_threshold' => $faker->numberBetween(70, 95),
                'disk_threshold' => $faker->numberBetween(80, 98),
                'network_threshold' => $faker->numberBetween(90, 100),
                'location' => $faker->city,
                'api_token' => $faker->uuid,
                'is_active' => true,
                'ping_status' => $faker->randomElement(['ok', 'failed', null]),
                'pinged_at' => now()->subHours(rand(1, 24)),
            ]);
            $servers[] = $server;
        }

        // 4. Create 40 Databases
        $databases = [];
        for ($i = 1; $i <= 40; $i++) {
            $database = Database::create([
                'organisation_id' => $organisations[array_rand($organisations)]->id,
                'server_id' => $servers[array_rand($servers)]->id,
                'name' => "DB{$i}-" . $faker->word,
                'type' => $faker->randomElement(['PostgreSQL', 'MySQL', 'SQL Server']),
                'connection_name' => 'conn_db_' . $i,
                'host' => $faker->domainName,
                'port' => $faker->randomElement([5432, 3306, 1433]),
                'username' => $faker->userName,
                'password' => $faker->password,
                'database' => $faker->word . '_' . $i,
                'active_threshold' => $faker->numberBetween(20, 100),
                'idle_threshold' => $faker->numberBetween(50, 200),
                'lock_threshold' => $faker->numberBetween(5, 50),
                'is_active' => true,
            ]);
            $databases[] = $database;
        }

        // 5. Create 40 Users
        for ($i = 1; $i <= 40; $i++) {
            User::updateOrCreate(
                ['email' => "user{$i}@example.com"],
                [
                    'name' => $faker->name,
                    'email_verified_at' => now(),
                    'password' => Hash::make('password123'),
                    'organisation_id' => $organisations[array_rand($organisations)]->id,
                    'is_active' => true,
                ]
            );
        }

        // 6. Create 40 Alerts
        for ($i = 1; $i <= 40; $i++) {
            Alert::create([
                'organisation_id' => $organisations[array_rand($organisations)]->id,
                'server_id' => $faker->randomElement([null, $servers[array_rand($servers)]->id]),
                'database_id' => $faker->randomElement([null, $databases[array_rand($databases)]->id]),
                'title' => $faker->sentence(3),
                'description' => $faker->paragraph(2),
                'type' => $faker->randomElement(['server', 'database', 'network']),
                'severity' => $faker->randomElement(['low', 'medium', 'high', 'critical']),
                'is_read' => $faker->boolean(30),
                'is_resolved' => $faker->boolean(20),
            ]);
        }

        echo "✅ Created 40 sample records for each model!\n";
        echo "   - 40 Organisations\n";
        echo "   - 40 Branches\n";
        echo "   - 40 Servers\n";
        echo "   - 40 Databases\n";
        echo "   - 40 Users\n";
        echo "   - 40 Alerts\n";
    }
}

