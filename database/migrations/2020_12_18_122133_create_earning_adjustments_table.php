<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEarningAdjustmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('earning_adjustments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->unsignedBigInteger('salary_component_id');
            $table->foreign('salary_component_id')->references('id')->on('salary_components')->onDelete('cascade');
            $table->string('amount',100);
            $table->string('month',100);
            $table->string('year',100);
            $table->text('note')->nullable();
            $table->string('attach_file')->nullable();
            $table->string('reference_no',100)->nullable();
            $table->string('type',50);
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('earning_adjustments');
    }
}
