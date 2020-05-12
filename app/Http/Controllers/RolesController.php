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
            
            $roles = config('app.roles');
            $access = [];
            foreach($roles as $key => $role){
                if($request->$key == 1){
                    $access[] = $role;
                }
            }
            
            $newRole = new Role();
            $newRole->role_name         = $request->role_name;
            $newRole->access            = json_encode($access);
            $newRole->save();
            return redirect('roles')->with('message', 'Roles added successfully!');
        }
        return view('roles.add');
    }
    
    public function delete($role_id){
        $role = Role::find($role_id);
        $role->delete();
        return redirect('roles')->with('message', 'Roles deleted successfully!');
    }

    public function update($role_id, Request $request){
        if($request->role_name !=""){
            
            $roles = config('app.roles');
            $access = [];
            foreach($roles as $key => $role){
                if($request->$key == 1){
                    $access[] = $role;
                }
            }
            
            $newRole = Role::where('id',$role_id)->first();
            $newRole->role_name         = $request->role_name;
            $newRole->access            = json_encode($access);
            $newRole->save();
            return redirect('roles')->with('message', 'Roles updated successfully!');
        }
        $roles = Role::where('id',$role_id)->first();
        return view('roles.update', ['roles' => $roles]);
    }
}
