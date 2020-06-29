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
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->string('bank_name',100);
            $table->string('ac_number',30);
            $table->string('book_no',30);
            $table->string('cheque_no',30);
            $table->string('cheque_name',100);
            $table->date('date');
            $table->string('amount');
            $table->string('amount_in_word_line_1')->nullable();
            $table->string('amount_in_word_line_2')->nullable();
            $table->boolean('ac_payee_only')->default(0);
            $table->integer('status')->default(0);
            
            $table->string('api_type')->nullable();
            $table->integer('document_id')->nullable();
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
