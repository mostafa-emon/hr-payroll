<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\SalarySheet;
use App\SalarySheetDetails;
use App\Employee;
use App\EmployeeEarningDeduction;
use App\EarningDeductionAdjustment;

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
        
        if($request->confirmation_check == "1") {

            $month = date('F',strtotime($request->salary_month));
            $year  = date('Y',strtotime($request->salary_month));

            SalarySheet::where('company_id',Auth::user()->company_id)->where('month',$month)->where('year',$year)->delete();
            SalarySheetDetails::where('company_id',Auth::user()->company_id)->where('month',$month)->where('year',$year)->delete();
            // TODO: Delete 2 more data: Income Tax & PF Employee Portion

            $employees = Employee::where('company_id',Auth::user()->company_id)
                        ->join('payroll_infos','employees.id','payroll_infos.employee_id')
                        ->select('employees.*','payroll_infos.festival_bonus_per_festival')
                        ->get();
            
            foreach($employees as $employee) {

                // ADJUSTMENTS
                $adjustment_array = [];
                $adjustments = EarningDeductionAdjustment::where('employee_id',$employee->id)->where('month',$month)->where('year',$year)->where('status',1)->get();
                foreach($adjustments as $key => $adjustment) {
                    $adjustment_array[$key]['component_id']            = 'component_'.$adjustment->salary_component_id;
                    $adjustment_array[$key]['earning_or_deduction']    = $adjustment->earning_or_deduction;
                    $adjustment_array[$key]['amount']                  = $adjustment->amount;
                    $adjustment_array[$key]['type']                    = $adjustment->type;
                }
                
                // EMPLOYEE EARNING DEDUCTIONS
                $earnings_deductions = EmployeeEarningDeduction::where('employee_id',$employee->id)
                                    ->join('salary_components','employee_earning_deductions.salary_component_id','salary_components.id')
                                    ->select('employee_earning_deductions.*','salary_components.component_name','salary_components.component_type','salary_components.component_reference')
                                    ->orderBy('earning_or_deduction','desc')
                                    ->orderBy('salary_component_id','asc')
                                    ->get();
                  
                $total_salary = 0; $final_amount = 0;
                
                foreach($earnings_deductions as $earn_ded) {

                    $adjustment_type = 0; $adjustment_amount = 0;

                    if($earn_ded->component_reference != "Gratuity" && $earn_ded->component_reference != "PF Company Portion") {
                        $column = array_column($adjustment_array, 'component_id');
                        $search = array_search('component_'.$earn_ded->salary_component_id,$column);

                        if($search !== false) {
                            $adjustment_type   = $adjustment_array[$search]['type'];
                            $adjustment_amount = $adjustment_array[$search]['amount'];
                        }

                        $salary_sheet_details = new SalarySheetDetails();
                        $salary_sheet_details->company_id               = $employee->company_id;
                        $salary_sheet_details->employee_id              = $employee->id;
                        $salary_sheet_details->month                    = $month;
                        $salary_sheet_details->year                     = $year;
                        $salary_sheet_details->component_id             = $earn_ded->salary_component_id;
                        $salary_sheet_details->component_name           = $earn_ded->component_name;
                        $salary_sheet_details->component_type           = $earn_ded->component_type;
                        $salary_sheet_details->component_reference      = $earn_ded->component_reference;
                        $salary_sheet_details->actual_amount            = $earn_ded->final_amount;
                        $final_amount                                   = $earn_ded->final_amount;

                        if($adjustment_type == "Increase") {
                            $salary_sheet_details->increase_adjustment  = $adjustment_amount;
                            $final_amount                               = $final_amount + $adjustment_amount;
                        } else if ($adjustment_type == "Decrease"){ 
                            $salary_sheet_details->decrease_adjustment  = $adjustment_amount; 
                            $final_amount                               = $final_amount - $adjustment_amount;
                        }

                        $salary_sheet_details->payable_amount           = $final_amount;
                        $salary_sheet_details->save();

                        if($earn_ded->component_type == "Earnings") {
                            $total_salary = $total_salary + $final_amount;
                        }else if($earn_ded->component_type == "Deduction") {
                            $total_salary = $total_salary - $final_amount;
                        }
                    }
                }

                if($request->festival_bonus == 1) {
                    if($employee->religion == $request->religion && $employee->festival_bonus_per_festival != "") {
                        $salary_sheet_details = new SalarySheetDetails();
                        $salary_sheet_details->company_id               = $employee->company_id;
                        $salary_sheet_details->employee_id              = $employee->id;
                        $salary_sheet_details->month                    = $month;
                        $salary_sheet_details->year                     = $year;
                        $salary_sheet_details->component_id             = 0;
                        $salary_sheet_details->component_name           = "Festival Bonus";
                        $salary_sheet_details->component_type           = "Festival Bonus";
                        $salary_sheet_details->component_reference      = "Festival Bonus";
                        $salary_sheet_details->actual_amount            = $employee->festival_bonus_per_festival;

                        $salary_sheet_details->increase_adjustment      = 0;
                        $salary_sheet_details->decrease_adjustment      = 0;

                        $salary_sheet_details->payable_amount           = $employee->festival_bonus_per_festival;
                        $salary_sheet_details->save();

                        $total_salary = $total_salary + $employee->festival_bonus_per_festival;
                    }
                }

                $salary_sheet = new SalarySheet();
                $salary_sheet->company_id               = $employee->company_id;
                $salary_sheet->employee_id              = $employee->id;
                $salary_sheet->month                    = $month;
                $salary_sheet->year                     = $year;
                $salary_sheet->total_salary             = $total_salary;
                $salary_sheet->save();
            }

            return redirect('salary-sheet')->with('message','Salary generated successfully!');
        }
        return view('transactions.payroll.salary_sheet.create');
    }
}
