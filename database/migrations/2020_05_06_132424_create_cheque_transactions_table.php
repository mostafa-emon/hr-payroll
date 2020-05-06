<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChequeTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cheque_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('bank_name',100);
            $table->string('ac_number',30);
            $table->string('book_no',30);
            $table->string('cheque_no',30);
            $table->string('cheque_name',100);
            $table->date('date');
            $table->integer('amount');
            $table->text('amount_in_words');
            $table->boolean('ac_payee_only')->default(0);
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
        Schema::dropIfExists('cheque_transactions');
    }
}
