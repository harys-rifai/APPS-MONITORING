<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE databases ALTER COLUMN is_active TYPE boolean USING is_active::boolean');
        DB::statement('ALTER TABLE databases ALTER COLUMN is_active SET DEFAULT true');
    }

    public function down(): void
    {
        //
    }
};