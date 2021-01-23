<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\SalarySheet;
use App\SalarySheetDetails;
use App\Employee;
use App\EmployeeEarningDeduction;
use App\EarningDeductionAdjustment;
use App\ProvidentFund;
use App\IncomeTax;
use DB;

class SalarySheetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $sheets = SalarySheet::where('company_id',Auth::user()->company_id)
                ->select('month','year',DB::raw('SUM(total_salary) as total_salary'),DB::raw('count(salary_sheets.id) as total_employee'))
                ->groupBy('month', 'year')
                ->orderBy('id','desc')
                ->get();
        return view('transactions.payroll.salary_sheet.index',compact('sheets'));
    }

    public function add(Request $request){
        
        if($request->confirmation_check == "1") {

            $month = date('F',strtotime($request->salary_month));
            $year  = date('Y',strtotime($request->salary_month));

            SalarySheet::where('company_id',Auth::user()->company_id)->where('month',$month)->where('year',$year)->delete();
            SalarySheetDetails::where('company_id',Auth::user()->company_id)->where('month',$month)->where('year',$year)->delete();
            ProvidentFund::where('company_id',Auth::user()->company_id)->where('type','Employee Portion')->where('month',$month)->where('year',$year)->delete();
            IncomeTax::where('company_id',Auth::user()->company_id)->where('month',$month)->where('year',$year)->delete();

            $employees = Employee::where('company_id',Auth::user()->company_id)
                        ->join('payroll_infos','employees.id','payroll_infos.employee_id')
                        ->select('employees.*','payroll_infos.festival_bonus_per_festival','payroll_infos.currency_id')
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

                        if($earn_ded->component_reference == "PF Employee Portion") {
                            $pf = new ProvidentFund();
                            $pf->company_id        = $employee->company_id;
                            $pf->employee_id       = $employee->id;
                            $pf->currency_id       = $employee->currency_id;
                            $pf->type              = "Employee Portion";
                            $pf->month             = $month;
                            $pf->year              = $year;
                            $pf->amount            = $final_amount;
                            $pf->status            = 0;
                            $pf->save();
                        }

                        if($earn_ded->component_reference == "Income Tax") {
                            $income_tax = new IncomeTax();
                            $income_tax->company_id        = $employee->company_id;
                            $income_tax->employee_id       = $employee->id;
                            $income_tax->currency_id       = $employee->currency_id;
                            $income_tax->month             = $month;
                            $income_tax->year              = $year;
                            $income_tax->amount            = $final_amount;
                            $income_tax->status            = 0;
                            $income_tax->save();
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
