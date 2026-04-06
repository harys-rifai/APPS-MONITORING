<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE servers ALTER COLUMN is_active DROP DEFAULT');
        DB::statement('ALTER TABLE servers ALTER COLUMN is_active TYPE boolean');
        DB::statement('ALTER TABLE servers ALTER COLUMN is_active SET DEFAULT true');

        DB::statement('ALTER TABLE databases ALTER COLUMN is_active DROP DEFAULT');
        DB::statement('ALTER TABLE databases ALTER COLUMN is_active TYPE boolean');
        DB::statement('ALTER TABLE databases ALTER COLUMN is_active SET DEFAULT true');

        DB::statement('ALTER TABLE alerts ALTER COLUMN is_active DROP DEFAULT');
        DB::statement('ALTER TABLE alerts ALTER COLUMN is_active TYPE boolean');
        DB::statement('ALTER TABLE alerts ALTER COLUMN is_active SET DEFAULT true');

        DB::statement('ALTER TABLE db_metrics ALTER COLUMN is_active DROP DEFAULT');
        DB::statement('ALTER TABLE db_metrics ALTER COLUMN is_active TYPE boolean');
        DB::statement('ALTER TABLE db_metrics ALTER COLUMN is_active SET DEFAULT true');

        DB::statement('ALTER TABLE server_metrics ALTER COLUMN is_active DROP DEFAULT');
        DB::statement('ALTER TABLE server_metrics ALTER COLUMN is_active TYPE boolean');
        DB::statement('ALTER TABLE server_metrics ALTER COLUMN is_active SET DEFAULT true');
    }

    public function down(): void
    {
        //
    }
};