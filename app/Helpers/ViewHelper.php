<?php

use Illuminate\Support\Facades\Auth;
use App\Role;

function roles(){
    $user_roles = Role::where('id',Auth::user()->roles)->first();
    if($user_roles == null){$roles = "";} else {$roles = $user_roles->access;}
    return $roles;
}

function amountFormat($amount) {
    return $amount;
}


