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

            $table->string('house_rent_allowance_amount_yearly',12)->nullable();
            $table->double('house_rent_allowance_amount_monthly', 10, 2)->default(0);

            $table->string('house_rent_allowance_in_percent',12)->nullable();
            $table->string('conveyance_allowance_actual',12)->nullable();

            $table->string('conveyance_allowance_amount_yearly',12)->nullable();
            $table->double('conveyance_allowance_amount_monthly', 10, 2)->default(0);

            $table->string('medical_allowance_amount_yearly',12)->nullable();
            $table->double('medical_allowance_amount_monthly', 10, 2)->default(0);

            $table->string('medical_allowance_in_percent',12)->nullable();

            $table->string('first_amount_below_65_aged_male_yearly',12)->nullable();
            $table->double('first_amount_below_65_aged_male_monthly', 10, 2)->default(0);

            $table->string('first_amount_female_above_65_aged_male_yearly',12)->nullable();
            $table->double('first_amount_female_above_65_aged_male_monthly', 10, 2)->default(0);

            $table->string('first_tax_rate_percent',12)->nullable();

            $table->string('second_amount_below_65_aged_male_yearly',12)->nullable();
            $table->double('second_amount_below_65_aged_male_monthly', 10, 2)->default(0);

            $table->string('second_amount_female_above_65_aged_male_yearly',12)->nullable();
            $table->double('second_amount_female_above_65_aged_male_monthly', 10, 2)->default(0);

            $table->string('second_tax_rate_percent',12)->nullable();

            $table->string('third_amount_below_65_aged_male_yearly',12)->nullable();
            $table->double('third_amount_below_65_aged_male_monthly', 10, 2)->default(0);

            $table->string('third_amount_female_above_65_aged_male_yearly',12)->nullable();
            $table->double('third_amount_female_above_65_aged_male_monthly', 10, 2)->default(0);

            $table->string('third_tax_rate_percent',12)->nullable();

            $table->string('forth_amount_below_65_aged_male_yearly',12)->nullable();
            $table->double('forth_amount_below_65_aged_male_monthly', 10, 2)->default(0);

            $table->string('forth_amount_female_above_65_aged_male_yearly',12)->nullable();
            $table->double('forth_amount_female_above_65_aged_male_monthly', 10, 2)->default(0);

            $table->string('forth_tax_rate_percent',12)->nullable();

            $table->string('fifth_amount_below_65_aged_male_yearly',12)->nullable();
            $table->double('fifth_amount_below_65_aged_male_monthly', 10, 2)->default(0);

            $table->string('fifth_amount_female_above_65_aged_male_yearly',12)->nullable();
            $table->double('fifth_amount_female_above_65_aged_male_monthly', 10, 2)->default(0);

            $table->string('fifth_tax_rate_percent',12)->nullable();

            $table->string('rest_amount_below_65_aged_male',12)->nullable();

            $table->string('rest_amount_female_above_65_aged_male',12)->nullable();

            $table->string('rest_tax_rate_percent',12)->nullable();
            $table->string('per_percent_of_tax_income',12)->nullable();

            $table->string('maximum_investment_amount_allowed_yearly',12)->nullable();
            $table->double('maximum_investment_amount_allowed_monthly', 10, 2)->default(0);

            $table->string('investment_amount_less_percent',12)->nullable();

            $table->string('investment_amount_less_amount_yearly',12)->nullable();
            $table->double('investment_amount_less_amount_monthly', 10, 2)->default(0);

            $table->string('investment_amount_more_percent',12)->nullable();

            $table->string('investment_amount_more_amount_yearly',12)->nullable();
            $table->double('investment_amount_more_amount_monthly', 10, 2)->default(0);

            $table->date('query_income_date_from')->nullable();
            $table->date('query_income_date_to')->nullable();
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
