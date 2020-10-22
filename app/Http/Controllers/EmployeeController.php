<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use Auth;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $employees = Employee::where('company_id',Auth::user()->company_id)->paginate(10);
        return view('employee.index',compact('employees'));
    }

    public function add(Request $request){
        if($request->name != "") {

        }
        return view('employee.add');
    }
}
