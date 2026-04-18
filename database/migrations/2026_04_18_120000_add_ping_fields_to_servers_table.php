<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('servers', function (Blueprint $table) {
            $table->enum('ping_status', ['ok', 'failed'])->nullable()->after('is_active');
            $table->timestamp('pinged_at')->nullable()->after('ping_status');
        });
    }

    public function down(): void
    {
        Schema::table('servers', function (Blueprint $table) {
            $table->dropColumn(['ping_status', 'pinged_at']);
        });
    }
};