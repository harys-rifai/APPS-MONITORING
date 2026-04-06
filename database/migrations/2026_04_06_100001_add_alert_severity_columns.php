<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('alerts', function (Blueprint $table) {
            $table->enum('severity', ['info', 'warning', 'critical'])->default('warning')->after('type');
            $table->string('group_key')->nullable()->index()->after('severity');
            $table->timestamp('resolved_at')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('alerts', function (Blueprint $table) {
            $table->dropColumn(['severity', 'group_key', 'resolved_at']);
        });
    }
};