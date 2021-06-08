<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tax_rules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->string('income_year_from',10);
            $table->string('income_year_to',10);
            $table->string('assesment_year_from',10);
            $table->string('assesment_year_to',10);

            $table->string('house_rent_allowance_amount',12)->nullable();
            $table->string('house_rent_allowance_in_percent',12)->nullable();
            $table->string('conveyance_allowance_actual',12)->nullable();
            $table->string('conveyance_allowance_amount',12)->nullable();
            $table->string('medical_allowance_amount',12)->nullable();
            $table->string('medical_allowance_in_percent',12)->nullable();

            $table->string('first_amount_below_65_aged_male',12)->nullable();
            $table->string('first_amount_female_above_65_aged_male',12)->nullable();
            $table->string('first_tax_rate_percent',12)->nullable();
            $table->string('second_amount_below_65_aged_male',12)->nullable();
            $table->string('second_amount_female_above_65_aged_male',12)->nullable();
            $table->string('second_tax_rate_percent',12)->nullable();
            $table->string('third_amount_below_65_aged_male',12)->nullable();
            $table->string('third_amount_female_above_65_aged_male',12)->nullable();
            $table->string('third_tax_rate_percent',12)->nullable();
            $table->string('forth_amount_below_65_aged_male',12)->nullable();
            $table->string('forth_amount_female_above_65_aged_male',12)->nullable();
            $table->string('forth_tax_rate_percent',12)->nullable();
            $table->string('fifth_amount_below_65_aged_male',12)->nullable();
            $table->string('fifth_amount_female_above_65_aged_male',12)->nullable();
            $table->string('fifth_tax_rate_percent',12)->nullable();
            $table->string('rest_amount_below_65_aged_male',12)->nullable();
            $table->string('rest_amount_female_above_65_aged_male',12)->nullable();
            $table->string('rest_tax_rate_percent',12)->nullable();

            $table->string('per_percent_of_tax_income',12)->nullable();
            $table->string('maximum_investment_amount_allowed',12)->nullable();
            $table->string('investment_amount_less_percent',12)->nullable();
            $table->string('investment_amount_less_amount',12)->nullable();
            $table->string('investment_amount_more_percent',12)->nullable();
            $table->string('investment_amount_more_amount',12)->nullable();
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
        Schema::dropIfExists('tax_rules');
    }
}
