<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayrollInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payroll_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->boolean('company_pf_on_salary_statement')->default(0);
            $table->double('festival_bonus_per_festival')->default(0);
            $table->double('gratuity_amount')->default(0);
            $table->double('investment_amount')->default(0);
            $table->boolean('ot_allowed')->default(0);
            $table->double('hourly_ot_rate')->default(0);
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
        Schema::dropIfExists('payroll_infos');
    }
}
