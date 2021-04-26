<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->date('date')->nullable();

            $table->date('actual_in_time_date')->nullable();
            $table->time('actual_in_time')->nullable();
            $table->date('actual_out_time_date')->nullable();
            $table->time('actual_out_time')->nullable();
            $table->integer('roster_employee')->default(0);

            $table->date('in_time_date')->nullable();
            $table->time('in_time')->nullable();
            $table->date('out_time_date')->nullable();
            $table->time('out_time')->nullable();

            $table->integer('late')->default(0); // In minute
            $table->integer('late_over_allowed_time')->default(0);
            $table->integer('punishment_processed')->default(0);
            $table->integer('day_absent_for_late')->default(0);

            $table->integer('work_in_govt_holiday')->default(0);
            $table->integer('work_in_leave_day')->default(0);
            $table->integer('over_time')->default(0); // In minute
            $table->integer('over_time_round_slab')->default(0); // In minute
            $table->integer('early_leave')->default(0); // In minute
            $table->integer('total_working_hour')->default(0); // In minute

            $table->string('status')->default('ABSENT'); // PRESENT,ABSENT,HOLIDAY,PAID_LEAVE
            $table->string('readable_status')->default('Absent');

            $table->text('note')->nullable();

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
        Schema::dropIfExists('attendances');
    }
}
