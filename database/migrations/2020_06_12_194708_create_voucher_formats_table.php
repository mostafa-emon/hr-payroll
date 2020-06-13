<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVoucherFormatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voucher_formats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->string('title');
            $table->string('type');

            $table->integer('qb_logo_top')->nullable();
            $table->integer('qb_logo_left')->nullable();
            $table->integer('voucher_no_top')->nullable();
            $table->integer('voucher_no_left')->nullable();
            $table->integer('voucher_date_top')->nullable();
            $table->integer('voucher_date_left')->nullable();

            $table->integer('payee_name')->default(0);
            $table->integer('payee_name_top')->nullable();
            $table->integer('payee_name_left')->nullable();
            $table->integer('cheque_no')->default(0);
            $table->integer('cheque_no_top')->nullable();
            $table->integer('cheque_no_left')->nullable();
            $table->integer('cheque_date')->default(0);
            $table->integer('cheque_date_top')->nullable();
            $table->integer('cheque_date_left')->nullable();
            $table->integer('received_from')->default(0);
            $table->integer('received_from_top')->nullable();
            $table->integer('received_from_left')->nullable();

            $table->integer('account_code')->default(0);
            $table->integer('customer_job')->default(0);
            $table->integer('class')->default(0);
            $table->integer('name')->default(0);
            $table->integer('project')->default(0);
            $table->integer('location')->default(0);

            $table->integer('table_top')->nullable();
            $table->integer('table_left')->nullable();
            $table->integer('signatory_top')->nullable();

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
        Schema::dropIfExists('voucher_formats');
    }
}
