<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->integer('document_id');
            $table->string('type');
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->unsignedBigInteger('currency_id');
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');
            $table->string('api_type');
            $table->string('voucher_no')->nullable();
            $table->string('prefix',20)->nullable();
            $table->string('suffix',20)->nullable();
            $table->date('voucher_date');
            $table->string('reference_no')->nullable();
            $table->string('payee_name')->nullable();
            $table->string('received_from')->nullable();
            $table->string('cheque_no')->nullable();
            $table->date('cheque_date')->nullable();
            $table->string('location')->nullable();
            $table->string('memo')->nullable();
            $table->double('total_debit')->nullable();
            $table->double('total_credit')->nullable();
            $table->text('amount_in_word')->nullable();
            $table->boolean('status')->default(true);
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
        Schema::dropIfExists('vouchers');
    }
}
