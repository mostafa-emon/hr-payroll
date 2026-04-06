<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropLeaveAndAttendanceTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('attendances');
        Schema::dropIfExists('attendance_policies');
        Schema::dropIfExists('attendance_records');
        Schema::dropIfExists('rosters');
        Schema::dropIfExists('roster_employees');
        Schema::dropIfExists('temporary_roster_selections');
        Schema::dropIfExists('govt_holiday_details');
        Schema::dropIfExists('govt_holidays');
        Schema::dropIfExists('leave_types');
        Schema::dropIfExists('leave_requests');
        Schema::dropIfExists('general_leaves');
        Schema::dropIfExists('paid_leaves');
        Schema::dropIfExists('leave_infos');
        Schema::dropIfExists('shift_types');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // No reverse possible for module excision.
    }
}
