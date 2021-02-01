<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaryTransferLetterDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_transfer_letter_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('letter_id');
            $table->foreign('letter_id')->references('id')->on('salary_transfer_letters')->onDelete('cascade');
            $table->string('employee_id');
            $table->string('salary_amount');
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
        Schema::dropIfExists('salary_transfer_letter_details');
    }
}
