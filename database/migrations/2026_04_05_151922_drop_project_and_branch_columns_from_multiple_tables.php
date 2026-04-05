<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('employment_infos', function (Blueprint $table) {
            $table->dropColumn(['project_id', 'branch_id']);
        });

        Schema::table('rosters', function (Blueprint $table) {
            $table->dropColumn(['branch_id']);
        });

        Schema::table('sms_campaigns', function (Blueprint $table) {
            $table->dropColumn(['project_id', 'branch_id']);
        });

        Schema::table('deposit_salary_taxes', function (Blueprint $table) {
            $table->dropColumn(['project_id', 'branch_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employment_infos', function (Blueprint $table) {
            $table->string('project_id')->nullable();
            $table->string('branch_id')->nullable();
        });

        Schema::table('rosters', function (Blueprint $table) {
            $table->string('branch_id')->nullable();
        });

        Schema::table('sms_campaigns', function (Blueprint $table) {
            $table->string('project_id')->nullable();
            $table->string('branch_id')->nullable();
        });

        Schema::table('deposit_salary_taxes', function (Blueprint $table) {
            $table->string('project_id')->nullable();
            $table->string('branch_id')->nullable();
        });
    }
};
