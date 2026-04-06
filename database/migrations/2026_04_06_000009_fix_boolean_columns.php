<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE servers ALTER COLUMN is_active TYPE boolean USING is_active::boolean');
        DB::statement('ALTER TABLE databases ALTER COLUMN is_active TYPE boolean USING is_active::boolean');
        DB::statement('ALTER TABLE alerts ALTER COLUMN is_active TYPE boolean USING is_active::boolean');
        DB::statement('ALTER TABLE db_metrics ALTER COLUMN is_active TYPE boolean USING is_active::boolean');
        DB::statement('ALTER TABLE server_metrics ALTER COLUMN is_active TYPE boolean USING is_active::boolean');
    }

    public function down(): void
    {
        //
    }
};