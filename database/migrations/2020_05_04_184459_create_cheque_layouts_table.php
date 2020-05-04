<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChequeLayoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cheque_layouts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bank_id');
            $table->foreign('bank_id')->references('id')->on('banks')->onDelete('cascade');
            $table->integer('height')->nullable();
            $table->integer('width')->nullable();
            $table->boolean('date')->default(1);
            $table->integer('date_top')->nullable();
            $table->integer('date_left')->nullable();
            $table->boolean('payee')->default(1);
            $table->integer('payee_top')->nullable();
            $table->integer('payee_left')->nullable();
            $table->boolean('amount')->default(1);
            $table->integer('amount_top')->nullable();
            $table->integer('amount_left')->nullable();
            $table->boolean('amount_in_word')->default(1);
            $table->integer('amount_in_word_top')->nullable();
            $table->integer('amount_in_word_left')->nullable();
            $table->boolean('ac_payee_only')->default(1);
            $table->integer('ac_payee_only_top')->nullable();
            $table->integer('ac_payee_only_left')->nullable();
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
        Schema::dropIfExists('cheque_layouts');
    }
}
