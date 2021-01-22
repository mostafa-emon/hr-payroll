<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalarySheetDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_sheet_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->string('month');
            $table->string('year');
            $table->unsignedBigInteger('component_id');
            $table->foreign('component_id')->references('id')->on('salary_components')->onDelete('cascade');
            $table->string('component_name')->nullable();
            $table->string('component_type')->nullable();
            $table->string('component_reference')->nullable();
            $table->double('actual_amount')->default(0);
            $table->double('increase_adjustment')->default(0);
            $table->double('decrease_adjustment')->default(0);
            $table->double('payable_amount')->default(0);
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
        Schema::dropIfExists('salary_sheet_details');
    }
}
