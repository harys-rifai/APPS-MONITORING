<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppVersionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\AppVersion::firstOrCreate([
            'version' => 'v.1.0.0'
        ], [
            'changelog' => 'Initial release with multi-tenancy and RBAC.',
            'is_active' => true
        ]);
    }
}
