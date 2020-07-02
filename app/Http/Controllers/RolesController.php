<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use DB;
use Auth;
use App\Helpers\ViewHelper;

class RolesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
        $roles = Role::where('id','>',2)->where('company_id',Auth::user()->company_id)->orderBy('role_name', 'asc')->paginate(10);
        return view('roles.index', ['roles'=>$roles]);
    }
    
    public function add(Request $request){
        if(roles() != "" && !in_array(29, json_decode(roles(),false))){
            return redirect('404');
        }
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
            $newRole->company_id        = Auth::user()->company_id;
            $newRole->save();
            return redirect('roles')->with('message', 'Roles added successfully!');
        }
        return view('roles.add');
    }
    
    public function delete($role_id){
        if(roles() != "" && !in_array(31, json_decode(roles(),false))){
            return redirect('404');
        }
        $role = Role::find($role_id);
        $role->delete();
        return redirect('roles')->with('message', 'Roles deleted successfully!');
    }

    public function update($role_id, Request $request){
        if(roles() != "" && !in_array(30, json_decode(roles(),false))){
            return redirect('404');
        }
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
