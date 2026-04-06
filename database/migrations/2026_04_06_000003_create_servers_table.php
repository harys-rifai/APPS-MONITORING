<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('servers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('hostname');
            $table->string('ip');
            $table->string('os')->default('linux');
            $table->string('type')->default('server');
            $table->integer('cpu_threshold')->default(80);
            $table->integer('ram_threshold')->default(80);
            $table->integer('disk_threshold')->default(80);
            $table->integer('network_threshold')->default(100);
            $table->string('location')->nullable();
            $table->string('api_token')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('role_id')->nullable()->constrained('roles')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('servers');
    }
};