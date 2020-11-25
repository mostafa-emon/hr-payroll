<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmploymentInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employment_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->string('department_id')->nullable();
            $table->string('designation_id')->nullable();
            $table->string('project_id')->nullable();
            $table->string('branch_id')->nullable();
            $table->string('date_of_joining')->nullable();
            $table->string('date_of_confirmation')->nullable();
            $table->string('date_of_resign')->nullable();
            $table->string('current_status')->nullable();
            $table->text('reason_for_resign')->nullable();
            $table->string('terminated')->nullable();
            $table->string('date_of_termination')->nullable();
            $table->text('reason_for_termination')->nullable();
            $table->string('duty_type')->nullable();
            $table->string('salary_payment_method')->nullable();
            $table->string('bank_account_no')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_branch_id')->nullable();
            $table->string('pay_slip_send_method')->nullable();
            $table->string('weekend_1')->nullable();
            $table->string('weekend_2')->nullable();
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
        Schema::dropIfExists('employment_infos');
    }
}
