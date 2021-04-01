<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepositSalaryTaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deposit_salary_taxes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->string('department_id')->nullable();
            $table->string('project_id')->nullable();
            $table->string('branch_id')->nullable();
            $table->string('currency_id')->nullable();
            $table->string('from');
            $table->string('to');
            $table->string('challan_no')->nullable();
            $table->text('attachment')->nullable();
            $table->text('text_1')->nullable();
            $table->text('text_2')->nullable();
            $table->text('text_3')->nullable();
            $table->text('text_4')->nullable();
            $table->date('chalan_date')->nullable();
            $table->string('status');
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
        Schema::dropIfExists('deposit_salary_taxes');
    }
}
