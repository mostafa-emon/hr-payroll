<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepositSalaryTaxDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deposit_salary_tax_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tax_id');
            $table->foreign('tax_id')->references('id')->on('deposit_salary_taxes')->onDelete('cascade');
            $table->integer('sl');
            $table->string('employee_id');
            $table->string('original_employee_id')->nullable();
            $table->date('query_date')->nullable();
            $table->string('amount')->nullable();
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
        Schema::dropIfExists('deposit_salary_tax_details');
    }
}
