<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancePoliciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance_policies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->string('start_time',50);
            $table->boolean('start_time_meridiem');
            $table->string('end_time',50);
            $table->boolean('end_time_meridiem');
            $table->boolean('late_policy')->default(0);
            $table->string('late_mark');
            $table->boolean('late_absent_policy')->default(0);
            $table->string('marks_absent_for');
            $table->string('time_for_ot');
            $table->boolean('use_ot_round')->default(0);
            $table->string('ot_round')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendance_policies');
    }
}
