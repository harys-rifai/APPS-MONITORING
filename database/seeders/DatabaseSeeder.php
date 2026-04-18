<?php

namespace Database\Seeders;

use App\Models\Organisation;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            SampleDataSeeder::class,
        ]);

        // Ensure admin user exists
        $admin = User::updateOrCreate(
            ['email' => 'harys@google.com'],
            [
                'name' => 'Default Admin',
                'password' => Hash::make('xcxcxc'),
                'organisation_id' => Organisation::first()->id ?? 1,
                'is_active' => true,
            ]
        );
        if ($admin->hasRole('Admin') === false) {
            $admin->assignRole('Admin');
        }
    }
}

