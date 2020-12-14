<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRosterEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roster_employees', function (Blueprint $table) {
            $table->id();
            $table->integer('roster_id');
            $table->integer('employee_id');
            $table->date('date');
            $table->string('shift_id')->nullable();
            $table->integer('day_off');
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
        Schema::dropIfExists('roster_employees');
    }
}
