<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtTransferLetterDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ot_transfer_letter_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('letter_id');
            $table->foreign('letter_id')->references('id')->on('ot_transfer_letters')->onDelete('cascade');
            $table->string('employee_id');
            $table->string('ot_amount');
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
        Schema::dropIfExists('ot_transfer_letter_details');
    }
}
