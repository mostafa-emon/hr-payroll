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
            $table->text('address',100)->nullable();
            $table->string('phone',100)->nullable();
            $table->string('email',100)->nullable();
            $table->string('tin',30)->nullable();
            $table->string('vat_reg_no',50)->nullable();
            $table->string('logo',150)->nullable();
            $table->boolean('status')->default(false);
            $table->date('subscription_end_date',150)->nullable();
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
