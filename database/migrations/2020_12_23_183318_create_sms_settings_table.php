<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmsSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->string('title')->nullable();

            $table->string('sms_api_url')->nullable();
            $table->string('send_to_parameter_name')->nullable();
            $table->string('sms_body_parameter_name')->nullable();
            $table->string('request_method')->nullable();

            $table->string('parameter_1_key')->nullable();
            $table->string('parameter_1_value')->nullable();

            $table->string('parameter_2_key')->nullable();
            $table->string('parameter_2_value')->nullable();

            $table->string('parameter_3_key')->nullable();
            $table->string('parameter_3_value')->nullable();

            $table->string('parameter_4_key')->nullable();
            $table->string('parameter_4_value')->nullable();

            $table->string('parameter_5_key')->nullable();
            $table->string('parameter_5_value')->nullable();

            $table->string('parameter_6_key')->nullable();
            $table->string('parameter_6_value')->nullable();

            $table->string('parameter_7_key')->nullable();
            $table->string('parameter_7_value')->nullable();

            $table->string('parameter_8_key')->nullable();
            $table->string('parameter_8_value')->nullable();

            $table->string('parameter_9_key')->nullable();
            $table->string('parameter_9_value')->nullable();

            $table->string('parameter_10_key')->nullable();
            $table->string('parameter_10_value')->nullable();

            $table->string('sms_balance')->nullable();
            $table->string('eng_character_1')->nullable();
            $table->string('eng_character_2')->nullable();
            $table->string('eng_character_3')->nullable();
            $table->string('eng_character_4')->nullable();
            $table->string('eng_character_5')->nullable();
            $table->string('other_character_1')->nullable();
            $table->string('other_character_2')->nullable();
            $table->string('other_character_3')->nullable();
            $table->string('other_character_4')->nullable();
            $table->string('other_character_5')->nullable();
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
        Schema::dropIfExists('sms_settings');
    }
}
