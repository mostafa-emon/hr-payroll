<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\VoucherFormat;

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
            $table->unsignedBigInteger('company_id')->nullable();
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
            $table->integer('location')->default(0);
            $table->integer('location_top')->nullable();
            $table->integer('location_left')->nullable();
            $table->integer('reference_no')->default(0);
            $table->integer('reference_no_top')->nullable();
            $table->integer('reference_no_left')->nullable();


            $table->integer('account_code')->default(0);
            $table->integer('customer_job_project')->default(0);
            $table->integer('class')->default(0);
            $table->integer('name')->default(0);
            $table->integer('default')->default(0);

            $table->integer('table_top')->nullable();
            $table->integer('table_left')->nullable();
            $table->integer('signatory_top')->nullable();

            $table->timestamps();
        });

        $voucher_format = new VoucherFormat();
        $voucher_format->title                  = "Default";
        $voucher_format->type                   = "Cash-Payment-Voucher";
        $voucher_format->qb_logo_top            = 0;
        $voucher_format->qb_logo_left           = 5;
        $voucher_format->voucher_no_top         = 28;
        $voucher_format->voucher_no_left        = 150;
        $voucher_format->voucher_date_top       = 35;
        $voucher_format->voucher_date_left      = 150;
        $voucher_format->payee_name             = 1;
        $voucher_format->payee_name_top         = 28;
        $voucher_format->payee_name_left        = 5;
        $voucher_format->cheque_no              = 0;
        $voucher_format->cheque_no_top          = 0;
        $voucher_format->cheque_no_left         = 0;
        $voucher_format->cheque_date            = 0;
        $voucher_format->cheque_date_top        = 5;
        $voucher_format->cheque_date_left       = 0;
        $voucher_format->received_from          = 0;
        $voucher_format->received_from_top      = 10;
        $voucher_format->received_from_left     = 0;
        $voucher_format->location               = 0;
        $voucher_format->location_top           = 23;
        $voucher_format->location_left          = 140;
        $voucher_format->reference_no           = 0;
        $voucher_format->reference_no_top       = 18;
        $voucher_format->reference_no_left      = 140;
        $voucher_format->account_code           = 1;
        $voucher_format->customer_job_project   = 1;
        $voucher_format->class                  = 1;
        $voucher_format->name                   = 0;
        $voucher_format->table_top              = 43;
        $voucher_format->table_left             = 5;
        $voucher_format->signatory_top          = 130;
        $voucher_format->save();

        $voucher_format = new VoucherFormat();
        $voucher_format->title                  = "Default";
        $voucher_format->type                   = "Bank-Payment-Voucher";
        $voucher_format->qb_logo_top            = 0;
        $voucher_format->qb_logo_left           = 5;
        $voucher_format->voucher_no_top         = 28;
        $voucher_format->voucher_no_left        = 150;
        $voucher_format->voucher_date_top       = 35;
        $voucher_format->voucher_date_left      = 150;
        $voucher_format->payee_name             = 1;
        $voucher_format->payee_name_top         = 42;
        $voucher_format->payee_name_left        = 5;
        $voucher_format->cheque_no              = 1;
        $voucher_format->cheque_no_top          = 28;
        $voucher_format->cheque_no_left         = 5;
        $voucher_format->cheque_date            = 1;
        $voucher_format->cheque_date_top        = 35;
        $voucher_format->cheque_date_left       = 5;
        $voucher_format->received_from          = 0;
        $voucher_format->received_from_top      = 0;
        $voucher_format->received_from_left     = 0;
        $voucher_format->location               = 0;
        $voucher_format->location_top           = 23;
        $voucher_format->location_left          = 140;
        $voucher_format->reference_no           = 0;
        $voucher_format->reference_no_top       = 18;
        $voucher_format->reference_no_left      = 140;
        $voucher_format->account_code           = 1;
        $voucher_format->customer_job_project   = 1;
        $voucher_format->class                  = 1;
        $voucher_format->name                   = 0;
        $voucher_format->table_top              = 52;
        $voucher_format->table_left             = 5;
        $voucher_format->signatory_top          = 130;
        $voucher_format->save();

        $voucher_format = new VoucherFormat();
        $voucher_format->title                  = "Default";
        $voucher_format->type                   = "Cash-Receipt-Voucher";
        $voucher_format->qb_logo_top            = 0;
        $voucher_format->qb_logo_left           = 5;
        $voucher_format->voucher_no_top         = 28;
        $voucher_format->voucher_no_left        = 150;
        $voucher_format->voucher_date_top       = 35;
        $voucher_format->voucher_date_left      = 150;
        $voucher_format->payee_name             = 0;
        $voucher_format->payee_name_top         = 0;
        $voucher_format->payee_name_left        = 0;
        $voucher_format->cheque_no              = 0;
        $voucher_format->cheque_no_top          = 5;
        $voucher_format->cheque_no_left         = 0;
        $voucher_format->cheque_date            = 0;
        $voucher_format->cheque_date_top        = 10;
        $voucher_format->cheque_date_left       = 0;
        $voucher_format->received_from          = 1;
        $voucher_format->received_from_top      = 28;
        $voucher_format->received_from_left     = 5;
        $voucher_format->location               = 0;
        $voucher_format->location_top           = 23;
        $voucher_format->location_left          = 140;
        $voucher_format->reference_no           = 0;
        $voucher_format->reference_no_top       = 18;
        $voucher_format->reference_no_left      = 140;
        $voucher_format->account_code           = 1;
        $voucher_format->customer_job_project   = 0;
        $voucher_format->class                  = 1;
        $voucher_format->name                   = 0;
        $voucher_format->table_top              = 43;
        $voucher_format->table_left             = 5;
        $voucher_format->signatory_top          = 130;
        $voucher_format->save();

        $voucher_format = new VoucherFormat();
        $voucher_format->title                  = "Default";
        $voucher_format->type                   = "Bank-Receipt-Voucher";
        $voucher_format->qb_logo_top            = 0;
        $voucher_format->qb_logo_left           = 5;
        $voucher_format->voucher_no_top         = 28;
        $voucher_format->voucher_no_left        = 150;
        $voucher_format->voucher_date_top       = 35;
        $voucher_format->voucher_date_left      = 150;
        $voucher_format->payee_name             = 0;
        $voucher_format->payee_name_top         = 0;
        $voucher_format->payee_name_left        = 0;
        $voucher_format->cheque_no              = 1;
        $voucher_format->cheque_no_top          = 28;
        $voucher_format->cheque_no_left         = 5;
        $voucher_format->cheque_date            = 1;
        $voucher_format->cheque_date_top        = 35;
        $voucher_format->cheque_date_left       = 5;
        $voucher_format->received_from          = 1;
        $voucher_format->received_from_top      = 42;
        $voucher_format->received_from_left     = 5;
        $voucher_format->location               = 0;
        $voucher_format->location_top           = 23;
        $voucher_format->location_left          = 140;
        $voucher_format->reference_no           = 0;
        $voucher_format->reference_no_top       = 18;
        $voucher_format->reference_no_left      = 140;
        $voucher_format->account_code           = 1;
        $voucher_format->customer_job_project   = 0;
        $voucher_format->class                  = 1;
        $voucher_format->name                   = 0;
        $voucher_format->table_top              = 52;
        $voucher_format->table_left             = 5;
        $voucher_format->signatory_top          = 130;
        $voucher_format->save();

        $voucher_format = new VoucherFormat();
        $voucher_format->title                  = "Default";
        $voucher_format->type                   = "Contra-Voucher";
        $voucher_format->qb_logo_top            = 0;
        $voucher_format->qb_logo_left           = 5;
        $voucher_format->voucher_no_top         = 28;
        $voucher_format->voucher_no_left        = 150;
        $voucher_format->voucher_date_top       = 35;
        $voucher_format->voucher_date_left      = 150;
        $voucher_format->payee_name             = 0;
        $voucher_format->payee_name_top         = 0;
        $voucher_format->payee_name_left        = 0;
        $voucher_format->cheque_no              = 1;
        $voucher_format->cheque_no_top          = 28;
        $voucher_format->cheque_no_left         = 5;
        $voucher_format->cheque_date            = 1;
        $voucher_format->cheque_date_top        = 35;
        $voucher_format->cheque_date_left       = 5;
        $voucher_format->received_from          = 0;
        $voucher_format->received_from_top      = 10;
        $voucher_format->received_from_left     = 0;
        $voucher_format->location               = 0;
        $voucher_format->location_top           = 23;
        $voucher_format->location_left          = 140;
        $voucher_format->reference_no           = 0;
        $voucher_format->reference_no_top       = 18;
        $voucher_format->reference_no_left      = 140;
        $voucher_format->account_code           = 1;
        $voucher_format->customer_job_project   = 0;
        $voucher_format->class                  = 1;
        $voucher_format->name                   = 0;
        $voucher_format->table_top              = 43;
        $voucher_format->table_left             = 5;
        $voucher_format->signatory_top          = 130;
        $voucher_format->save();

        $voucher_format = new VoucherFormat();
        $voucher_format->title                  = "Default";
        $voucher_format->type                   = "Journal-Voucher";
        $voucher_format->qb_logo_top            = 0;
        $voucher_format->qb_logo_left           = 5;
        $voucher_format->voucher_no_top         = 28;
        $voucher_format->voucher_no_left        = 150;
        $voucher_format->voucher_date_top       = 35;
        $voucher_format->voucher_date_left      = 150;
        $voucher_format->payee_name             = 0;
        $voucher_format->payee_name_top         = 0;
        $voucher_format->payee_name_left        = 0;
        $voucher_format->cheque_no              = 0;
        $voucher_format->cheque_no_top          = 10;
        $voucher_format->cheque_no_left         = 0;
        $voucher_format->cheque_date            = 0;
        $voucher_format->cheque_date_top        = 5;
        $voucher_format->cheque_date_left       = 0;
        $voucher_format->received_from          = 0;
        $voucher_format->received_from_top      = 15;
        $voucher_format->received_from_left     = 0;
        $voucher_format->location               = 0;
        $voucher_format->location_top           = 23;
        $voucher_format->location_left          = 140;
        $voucher_format->reference_no           = 0;
        $voucher_format->reference_no_top       = 18;
        $voucher_format->reference_no_left      = 140;
        $voucher_format->account_code           = 1;
        $voucher_format->customer_job_project   = 0;
        $voucher_format->class                  = 1;
        $voucher_format->name                   = 1;
        $voucher_format->table_top              = 43;
        $voucher_format->table_left             = 5;
        $voucher_format->signatory_top          = 130;
        $voucher_format->save();
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
