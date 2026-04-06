<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('db_metrics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('database_id')->constrained('databases')->onDelete('cascade');
            $table->integer('active_count')->default(0);
            $table->integer('idle_count')->default(0);
            $table->integer('locked_count')->default(0);
            $table->boolean('is_active')->default(true);
            $table->foreignId('role_id')->nullable()->constrained('roles')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('db_metrics');
    }
};