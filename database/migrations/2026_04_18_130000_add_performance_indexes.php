<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('servers', function (Blueprint $table) {
            $table->index('is_active', 'servers_is_active_idx');
            $table->index('organisation_id', 'servers_organisation_id_idx');
            $table->index('branch_id', 'servers_branch_id_idx');
            $table->index(['organisation_id', 'is_active'], 'servers_org_active_idx');
        });

        Schema::table('databases', function (Blueprint $table) {
            $table->index('is_active', 'databases_is_active_idx');
            $table->index('server_id', 'databases_server_id_idx');
            $table->index('organisation_id', 'databases_organisation_id_idx');
            $table->index('branch_id', 'databases_branch_id_idx');
            $table->index(['organisation_id', 'is_active'], 'databases_org_active_idx');
        });

        Schema::table('organisations', function (Blueprint $table) {
            $table->index('is_active', 'organisations_is_active_idx');
            $table->index('created_by', 'organisations_created_by_idx');
        });

        Schema::table('branches', function (Blueprint $table) {
            $table->index('organisation_id', 'branches_organisation_id_idx');
            $table->index('is_active', 'branches_is_active_idx');
            $table->index(['organisation_id', 'is_active'], 'branches_org_active_idx');
        });

        Schema::table('audit_logs', function (Blueprint $table) {
            $table->index('user_id', 'audit_logs_user_id_idx');
            $table->index('entity_type', 'audit_logs_entity_type_idx');
            $table->index('entity_id', 'audit_logs_entity_id_idx');
            $table->index('created_at', 'audit_logs_created_at_idx');
            $table->index(['entity_type', 'entity_id'], 'audit_logs_entity_idx');
        });

        Schema::table('alerts', function (Blueprint $table) {
            $table->index('is_active', 'alerts_is_active_idx');
            $table->index('organisation_id', 'alerts_organisation_id_idx');
            $table->index('branch_id', 'alerts_branch_id_idx');
            $table->index('status', 'alerts_status_idx');
            $table->index('severity', 'alerts_severity_idx');
            $table->index(['organisation_id', 'status'], 'alerts_org_status_idx');
            $table->index(['alertable_type', 'alertable_id'], 'alerts_alertable_idx');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->index('organisation_id', 'users_organisation_id_idx');
            $table->index('branch_id', 'users_branch_id_idx');
        });

        Schema::table('server_metrics', function (Blueprint $table) {
            $table->index('server_id', 'server_metrics_server_id_idx');
            $table->index('created_at', 'server_metrics_created_at_idx');
        });

        Schema::table('db_metrics', function (Blueprint $table) {
            $table->index('database_id', 'db_metrics_database_id_idx');
            $table->index('created_at', 'db_metrics_created_at_idx');
        });
    }

    public function down(): void
    {
        Schema::table('servers', function (Blueprint $table) {
            $table->dropIndex('servers_is_active_idx');
            $table->dropIndex('servers_organisation_id_idx');
            $table->dropIndex('servers_branch_id_idx');
            $table->dropIndex('servers_org_active_idx');
        });

        Schema::table('databases', function (Blueprint $table) {
            $table->dropIndex('databases_is_active_idx');
            $table->dropIndex('databases_server_id_idx');
            $table->dropIndex('databases_organisation_id_idx');
            $table->dropIndex('databases_branch_id_idx');
            $table->dropIndex('databases_org_active_idx');
        });

        Schema::table('organisations', function (Blueprint $table) {
            $table->dropIndex('organisations_is_active_idx');
            $table->dropIndex('organisations_created_by_idx');
        });

        Schema::table('branches', function (Blueprint $table) {
            $table->dropIndex('branches_organisation_id_idx');
            $table->dropIndex('branches_is_active_idx');
            $table->dropIndex('branches_org_active_idx');
        });

        Schema::table('audit_logs', function (Blueprint $table) {
            $table->dropIndex('audit_logs_user_id_idx');
            $table->dropIndex('audit_logs_entity_type_idx');
            $table->dropIndex('audit_logs_entity_id_idx');
            $table->dropIndex('audit_logs_created_at_idx');
            $table->dropIndex('audit_logs_entity_idx');
        });

        Schema::table('alerts', function (Blueprint $table) {
            $table->dropIndex('alerts_is_active_idx');
            $table->dropIndex('alerts_organisation_id_idx');
            $table->dropIndex('alerts_branch_id_idx');
            $table->dropIndex('alerts_status_idx');
            $table->dropIndex('alerts_severity_idx');
            $table->dropIndex('alerts_org_status_idx');
            $table->dropIndex('alerts_alertable_idx');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('users_organisation_id_idx');
            $table->dropIndex('users_branch_id_idx');
        });

        Schema::table('server_metrics', function (Blueprint $table) {
            $table->dropIndex('server_metrics_server_id_idx');
            $table->dropIndex('server_metrics_created_at_idx');
        });

        Schema::table('db_metrics', function (Blueprint $table) {
            $table->dropIndex('db_metrics_database_id_idx');
            $table->dropIndex('db_metrics_created_at_idx');
        });
    }
};