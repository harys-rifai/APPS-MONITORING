<?php

namespace Database\Seeders;

use App\Models\organisation;
use App\Models\Server;
use App\Models\Database;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class SampleDataSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // 1. Create 20 Organisations
        $organisations = [];
        for ($i = 1; $i <= 20; $i++) {
            $org = organisation::create([
                'name' => "Organisation $i - {$faker->company}",
                'location' => $faker->city . ', ' . $faker->country,
                'is_active' => true,
                'created_by' => 1,
            ]);
            $organisations[] = $org;
        }

        // 2. Create 20 Servers
        for ($i = 1; $i <= 20; $i++) {
            Server::create([
                'organisation_id' => $organisations[array_rand($organisations)]->id,
                'name' => "Server-SV{$i}",
                'hostname' => 'server' . $i . '.example.com',
                'ip' => $faker->ipv4,
                'os' => $faker->randomElement(['linux', 'windows', 'macos']),
                'type' => $faker->randomElement(['server', 'db', 'both']),
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
        }

        // 3. Create 20 Databases
        for ($i = 1; $i <= 20; $i++) {
            Database::create([
                'organisation_id' => $organisations[array_rand($organisations)]->id,
                'server_id' => Server::inRandomOrder()->first()?->id,
                'name' => "DB{$i}-" . $faker->word,
                'type' => $faker->randomElement(['postgres', 'mysql', 'sqlserver']),
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
        }

        // 4. Create 20 Users
        for ($i = 1; $i <= 20; $i++) {
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

        echo "✅ Created 20 sample records each for Organisation, Server, Database, User!\n";
    }
}

