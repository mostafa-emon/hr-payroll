<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name',100);
            $table->string('phone',100)->nullable();
            $table->string('fax',100)->nullable();
            $table->string('email',100)->nullable();
            $table->text('address_line_1')->nullable();
            $table->text('address_line_2')->nullable();
            $table->string('bin',100)->nullable();
            $table->string('tin',100)->nullable();
            $table->string('ein',100)->nullable();
            $table->string('vat_reg_no',100)->nullable();
            $table->string('logo',150)->nullable();
            $table->string('website',100)->nullable();

            $table->string('leave_year_from',30)->nullable();
            $table->string('leave_year_to',30)->nullable();
            $table->boolean('status')->default(false);
            
            
            $table->boolean('attendance')->default(true);
            $table->boolean('leave')->default(true);
            $table->boolean('payroll')->default(true);
            $table->boolean('document_upload')->default(true);
            $table->boolean('quickbooks')->default(false);
            
            $table->integer('employee_limit')->nullable();
            $table->string('qb_client_id')->nullable();
            $table->string('qb_client_secret')->nullable();
            $table->string('qb_company_id')->nullable();
            $table->string('qb_environment')->nullable();

            $table->unsignedBigInteger('subscription_id');
            $table->foreign('subscription_id')->references('id')->on('subscriptions');

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
        Schema::dropIfExists('companies');
    }
}
