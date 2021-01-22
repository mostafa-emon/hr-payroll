<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\SalarySheet;
use App\SalarySheetDetails;
use App\Employee;
use App\EmployeeEarningDeduction;

class SalarySheetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('transactions.payroll.salary_sheet.index');
    }

    public function add(Request $request){
        if($request->confirmation_check =="1") {
            /*
            $array = [];
            $employees = Employee::where('id','>',0)->get();
            
            foreach($employees as $key => $employee) {
                $array[$key]['index'] = $key;
                $array[$key]['name'] = $employee->name;
                $array[$key]['fathers_name'] = $employee->fathers_name;
                $array[$key]['mothers_name'] = $employee->mothers_name;
            }

            $column = array_column($array, 'name');
            $search = array_search('Md. Habibur Rahman',$column);

            if($search !== false) {
                return $array[$search]['name'];
            }else{
                return "Null";
            }
            */

            $employees = Employee::where('company_id',auth()->user->id)->get();

            foreach($employees as $employee) {
                $earnings_deductions = EmployeeEarningDeduction::where('employee_id',$employee->id)->orderBy('earning_or_deduction','desc')->orderBy('salary_component_id','asc')->get();
                foreach($earnings_deductions as $earn_ded) {
                    if($earn_ded->earning_or_deduction == "earnings") {
                        
                    }

                    if($earn_ded->earning_or_deduction == "deductions") {
                        
                    }
                }
            }

            return view('transactions.payroll.salary_sheet.create');
        }
    }
}
