<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\Department;
use App\Designation;
use App\Project;
use App\Branch;
use App\PayrollBank;
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
        $departments = Department::where('company_id',Auth::user()->company_id)->orderby('name','asc')->get();
        $designations = Designation::where('company_id',Auth::user()->company_id)->orderby('name','asc')->get();
        $projects = Project::where('company_id',Auth::user()->company_id)->orderby('name','asc')->get();
        $branches = Branch::where('company_id',Auth::user()->company_id)->orderby('name','asc')->get();
        $banks    = PayrollBank::where('company_id',Auth::user()->company_id)->orderby('bank_name','asc')->get();

        return view('employee.add',compact('departments','designations','projects','branches','banks'));
    }
}
