<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('databases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('server_id')->nullable()->constrained('servers')->onDelete('set null');
            $table->string('name');
            $table->string('type');
            $table->string('connection_name')->nullable();
            $table->string('host');
            $table->integer('port')->default(5432);
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->string('database')->nullable();
            $table->integer('active_threshold')->default(50);
            $table->integer('idle_threshold')->default(100);
            $table->integer('lock_threshold')->default(10);
            $table->string('status')->default('ok');
            $table->boolean('is_active')->default(true);
            $table->foreignId('role_id')->nullable()->constrained('roles')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('databases');
    }
};