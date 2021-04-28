<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Role;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->string('role_name',100);
            $table->text('access');
            $table->timestamps();
        });

        $access = [];
        $access[] = 200;

        $role = new Role();
        $role->role_name = "System Admin";
        $role->access    = json_encode($access);
        $role->save(); 

        $access = [];
        for($i=1; $i<=168; $i++){
            if($i==161) {continue;}
            $access[] = $i;
        }
        $role = new Role();
        $role->role_name = "Company Admin";
        $role->access    = json_encode($access);
        $role->save(); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
