<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Hash;
use Illuminate\Support\Facades\Storage;
use App\Role;
use DB;
use Auth;
use App\Helpers\ViewHelper;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
        $user = User::orderBy('name', 'asc')->get();
        return view('users.index', ['users'=>$user]);
    }
    
    public function add(Request $request){
        if(roles() != "" && !in_array(29, json_decode(roles(),false))){
            return redirect('404');
        }
        if($request->name !=""){
            $user = new User();
            $user->name             = $request->name;
            $user->designation      = $request->designation;
            $user->email            = $request->email;
            $user->password         = Hash::make($request->password);
            if($request->hasFile('avatar')){  
                $user->avatar       = $request->file('avatar')->store('users');
            }
            $user->roles = $request->roles;
            $user->save();
            return redirect('user')->with('message', 'User added successfully!');
        }
        $roles = Role::orderBy('role_name','asc')->get();
        return view('users.add',['roles'=>$roles]);
    }
    
    public function delete($user_id){
        if(roles() != "" && !in_array(31, json_decode(roles(),false))){
            return redirect('404');
        }
        $user = User::find($user_id);
        $user->delete();
        return redirect('user')->with('message', 'User deleted successfully!');
    }

    public function update($user_id, Request $request){
        if(roles() != "" && !in_array(30, json_decode(roles(),false))){
            return redirect('404');
        }
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
            $user->roles = $request->roles;
            $user->save();
            return redirect('user')->with('message', 'User updated successfully!');
        }
        $users = User::where('id',$user_id)->first();
        $roles = Role::orderBy('role_name','asc')->get();
        return view('users.update', ['users' => $users, 'roles' => $roles]);
    }

    public function profile($user_id, Request $request){
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
            return redirect('user/profile/'.$user_id)->with('message', 'Profile updated successfully!');
        }
        $users = User::where('id',$user_id)->first();
        return view('users.profile', ['users' => $users]);
    }
}
