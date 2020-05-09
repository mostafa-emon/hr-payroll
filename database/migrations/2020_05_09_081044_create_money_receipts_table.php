<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoneyReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('money_receipts', function (Blueprint $table) {
            $table->id();
            $table->string('site_office_name',100);
            $table->string('site_office_prefix',10)->nullable();
            $table->string('site_office_suffix',10)->nullable();
            $table->string('invoice_no',10);
            $table->string('customer_name',100);
            $table->string('amount',30);
            $table->string('currency',30);
            $table->string('amount_in_word',30)->nullable();
            $table->string('payment_method',30)->nullable();
            $table->string('cheque_no',30)->nullable();
            $table->date('cheque_date')->nullable();
            $table->string('bank_name',100)->nullable();
            $table->string('purpose')->nullable();
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
        Schema::dropIfExists('money_receipts');
    }
}
