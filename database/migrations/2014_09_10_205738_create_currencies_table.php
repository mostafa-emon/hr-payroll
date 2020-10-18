<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Currency;
class CreateCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('currency_name')->nullable();
            $table->string('short_name')->nullable();
            $table->string('full_unit_name')->nullable();
            $table->string('sub_unit_name')->nullable();
            $table->timestamps();
        });

        $currency = new Currency();
        $currency->currency_name        = "Bangladeshi Taka";
        $currency->short_name           = "BDT";
        $currency->full_unit_name       = "Taka";
        $currency->sub_unit_name        = "Paisa";
        $currency->save();

        $currency = new Currency();
        $currency->currency_name        = "US Dollar";
        $currency->short_name           = "USD";
        $currency->full_unit_name       = "USD";
        $currency->sub_unit_name        = "Cent";
        $currency->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currencies');
    }
}
