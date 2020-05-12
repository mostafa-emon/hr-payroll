<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;

class RolesController extends Controller
{
    public function index(){
        $roles = Role::orderBy('role_name', 'asc')->get();
        return view('roles.index', ['roles'=>$roles]);
    }
    
    public function add(Request $request){
        if($request->role_name !=""){
            $roles = new Role();
            $roles->role_name       = $request->name;
            $roles->save();
            return redirect('roles')->with('message', 'Roles added successfully!');
        }
        return view('roles.add');
    }
    
    public function delete($user_id){
        $user = User::find($user_id);
        $user->delete();
        return redirect('user')->with('message', 'User deleted successfully!');
    }

    public function update($user_id, Request $request){
        if($request->name !=""){
            $user = User::where('id',$user_id)->first();
            $user->name             = $request->name;
            $user->designation      = $request->designation;
            $user->email            = $request->email;
            if($request->password != ""){
               $user->password      = Hash::make($request->password);
            }
            if($request->hasFile('avatar')){
                if($user->avatar != ""){
                    Storage::delete($user->avatar);
                }
                $user->avatar       = $request->file('avatar')->store('users');
            }
            $user->save();
            return redirect('user')->with('message', 'User updated successfully!');
        }
        $users = User::where('id',$user_id)->first();
        return view('users.update', ['users' => $users]);
    }
}
