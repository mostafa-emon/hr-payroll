<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->string('voucher_number',10);
            $table->string('voucher_size',10);

            $table->string('cash_payment_voucher_prefix',10)->nullable();
            $table->string('cash_payment_voucher_suffix',10)->nullable();
            $table->string('cash_payment_voucher_start_from',10)->nullable();

            $table->string('bank_payment_voucher_prefix',10)->nullable();
            $table->string('bank_payment_voucher_suffix',10)->nullable();
            $table->string('bank_payment_voucher_start_from',10)->nullable();

            $table->string('cash_receipt_voucher_prefix',10)->nullable();
            $table->string('cash_receipt_voucher_suffix',10)->nullable();
            $table->string('cash_receipt_voucher_start_from',10)->nullable();

            $table->string('bank_receipt_voucher_prefix',10)->nullable();
            $table->string('bank_receipt_voucher_suffix',10)->nullable();
            $table->string('bank_receipt_voucher_start_from',10)->nullable();

            $table->string('contra_voucher_prefix',10)->nullable();
            $table->string('contra_voucher_suffix',10)->nullable();
            $table->string('contra_voucher_start_from',10)->nullable();

            $table->string('journal_voucher_prefix',10)->nullable();
            $table->string('journal_voucher_suffix',10)->nullable();
            $table->string('journal_voucher_start_from',10)->nullable();

            $table->string('mr_number',10);

            $table->string('mr_prefix',10)->nullable();
            $table->string('mr_suffix',10)->nullable();
            $table->string('mr_start_from',10)->nullable();

            $table->string('mr_size',10);
            $table->string('amount_in_word_format',30);
            $table->boolean('approval_for_mr')->default(true);
            $table->boolean('approval_for_cheque')->default(true);
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
        Schema::dropIfExists('settings');
    }
}
