<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('servers', function (Blueprint $table) {
            $table->unsignedBigInteger('corporate_id')->nullable()->after('id');
            $table->foreign('corporate_id')->references('id')->on('corporates')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('servers', function (Blueprint $table) {
            $table->dropForeign(['corporate_id']);
            $table->dropColumn('corporate_id');
        });
    }
};