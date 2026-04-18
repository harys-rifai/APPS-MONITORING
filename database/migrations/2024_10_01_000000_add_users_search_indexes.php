<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->index(['organisation_id', 'name'], 'users_org_name_idx');
            $table->index(['organisation_id', 'email'], 'users_org_email_idx');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('users_org_name_idx');
            $table->dropIndex('users_org_email_idx');
        });
    }
};

