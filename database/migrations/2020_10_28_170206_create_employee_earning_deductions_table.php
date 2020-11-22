<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeEarningDeductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_earning_deductions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->unsignedBigInteger('salary_component_id');
            $table->string('earning_or_deduction');
            $table->foreign('salary_component_id')->references('id')->on('salary_components')->onDelete('cascade');
            $table->string('fixed_or_percentage');
            $table->string('percentage_amount')->nullable();
            $table->string('of_component_id')->nullable(); 
            $table->string('final_amount')->nullable(); 
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
        Schema::dropIfExists('employee_earning_deductions');
    }
}
