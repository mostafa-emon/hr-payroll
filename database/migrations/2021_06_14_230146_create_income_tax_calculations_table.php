<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncomeTaxCalculationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('income_tax_calculations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->string('income_year_from',10);
            $table->string('income_year_to',10);
            $table->string('assesment_year_from',10);
            $table->string('assesment_year_to',10);

            $table->double('basic_salary_monthly', 12, 2)->default(0);
            $table->double('house_rent_monthly', 12, 2)->default(0);
            $table->double('house_rent_monthly_non_tax_limit', 12, 2)->default(0);
            $table->double('conveyance_monthly', 12, 2)->default(0);
            $table->double('conveyance_monthly_non_tax_limit', 12, 2)->default(0);
            $table->double('medical_monthly', 12, 2)->default(0);
            $table->double('medical_monthly_non_tax_limit', 12, 2)->default(0);
            $table->double('company_portion_monthly', 12, 2)->default(0);
            $table->double('other_allowance_monthly', 12, 2)->default(0);
            $table->double('festival_bonus', 12, 2)->default(0);
            $table->double('taxable_income', 12, 2)->default(0);

            $table->double('first_slab_amount_monthly', 12, 2)->default(0);
            $table->double('second_slab_amount_monthly', 12, 2)->default(0);
            $table->double('third_slab_amount_monthly', 12, 2)->default(0);
            $table->double('forth_slab_amount_monthly', 12, 2)->default(0);
            $table->double('fifth_slab_amount_monthly', 12, 2)->default(0);
            $table->double('rest_slab_amount_monthly', 12, 2)->default(0);
            $table->double('first_slab_tax_amount_monthly', 12, 2)->default(0);
            $table->double('second_slab_tax_amount_monthly', 12, 2)->default(0);
            $table->double('third_slab_tax_amount_monthly', 12, 2)->default(0);
            $table->double('forth_slab_tax_amount_monthly', 12, 2)->default(0);
            $table->double('fifth_slab_tax_amount_monthly', 12, 2)->default(0);
            $table->double('rest_slab_tax_amount_monthly', 12, 2)->default(0);
            $table->double('tax_amount_monthly', 12, 2)->default(0);

            $table->double('percent_25_of_total_income_monthly', 12, 2)->default(0);
            $table->double('investment_amount_monthly', 12, 2)->default(0);
            $table->double('maximum_investment_amount_allowed_monthly', 12, 2)->default(0);

            $table->double('income_tax_monthly', 12, 2)->default(0);
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
        Schema::dropIfExists('income_tax_calculations');
    }
}
