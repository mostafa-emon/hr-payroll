<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSignatoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('signatories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->string('name',60);
            $table->integer('cash_payment_voucher')->default(0);
            $table->integer('bank_payment_voucher')->default(0);
            $table->integer('cash_receipt_voucher')->default(0);
            $table->integer('bank_receipt_voucher')->default(0);
            $table->integer('contra_voucher')->default(0);
            $table->integer('journal_voucher')->default(0);
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
        Schema::dropIfExists('signatories');
    }
}
