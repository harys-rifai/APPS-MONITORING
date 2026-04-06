<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('server_metrics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('server_id')->constrained('servers')->onDelete('cascade');
            $table->float('cpu_usage')->default(0);
            $table->float('ram_usage')->default(0);
            $table->float('disk_usage')->default(0);
            $table->float('network_in')->default(0);
            $table->float('network_out')->default(0);
            $table->boolean('is_active')->default(true);
            $table->foreignId('role_id')->nullable()->constrained('roles')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('server_metrics');
    }
};