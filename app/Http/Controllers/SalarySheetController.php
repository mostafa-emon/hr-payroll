<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\SalarySheet;
use App\SalarySheetDetails;
use App\Employee;
use App\EmployeeEarningDeduction;
use App\EarningDeductionAdjustment;
use App\Designation;
use App\ProvidentFund;
use App\IncomeTax;
use DB;
use App\EmploymentInfo;
use App\Department;
use App\Project;
use App\Branch;
use App\Currency;
use App\SalaryComponent;
use App\Company;
use App\Attendance;
use App\LeaveRequest;
use App\MailPaySlip;
use App\Email;
use App\SheetRevenueStamp;
use Config;
use Illuminate\Support\Facades\Mail;
use PDF;
use Redirect;

class SalarySheetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $sheet_count = SalarySheet::where('company_id',Auth::user()->company_id)->count();
        if($sheet_count > 0) {
            $sheets = SalarySheet::where('company_id',Auth::user()->company_id)
                ->select('month','year',DB::raw('SUM(total_salary) as total_salary'),DB::raw('count(salary_sheets.id) as total_employee'))
                ->groupBy('month', 'year')
                ->orderBy('id','desc')
                ->get();
        } else {
            $sheets = [];
        }
        
        return view('transactions.payroll.salary_sheet.index',compact('sheets'));
    }

    public function add(Request $request){
        
        if($request->confirmation_check == "1") {

            $month = date('F',strtotime($request->salary_month));
            $year  = date('Y',strtotime($request->salary_month));

            MailPaySlip::where('company_id',Auth::user()->company_id)->where('month',$month)->where('year',$year)->delete();
            SheetRevenueStamp::where('company_id',Auth::user()->company_id)->where('month',$month)->where('year',$year)->delete();
            SalarySheet::where('company_id',Auth::user()->company_id)->where('month',$month)->where('year',$year)->delete();
            SalarySheetDetails::where('company_id',Auth::user()->company_id)->where('month',$month)->where('year',$year)->delete();
            ProvidentFund::where('company_id',Auth::user()->company_id)->where('type','Employee Portion')->where('month',$month)->where('year',$year)->delete();
            IncomeTax::where('company_id',Auth::user()->company_id)->where('month',$month)->where('year',$year)->delete();

            $stamp                  = new SheetRevenueStamp();
            $stamp->company_id      = Auth::user()->company_id;
            $stamp->month           = $month;
            $stamp->year            = $year;
            $stamp->status          = $request->revenue_stamp;
            $stamp->company_portion = $request->company_portion;
            $stamp->save();

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
                        $salary_sheet_details->query_date               = date('Y-m-01',strtotime($request->salary_month));
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
                            $pf->query_date        = date('Y-m-01',strtotime($request->salary_month));
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
                            $income_tax->query_date        = date('Y-m-01',strtotime($request->salary_month));
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
                        $salary_sheet_details->query_date               = date('Y-m-01',strtotime($request->salary_month));
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

    public function details(Request $request,$month,$year) {
        $employment_infos       = EmploymentInfo::orderBy('employment_infos.id','asc')
                                ->select('employees.name','employees.employee_id as original_employee_id','employment_infos.*','salary_sheets.*','payroll_infos.currency_id')
                                ->join('payroll_infos','payroll_infos.employee_id','employment_infos.employee_id')
                                ->join('employees','employees.id','employment_infos.employee_id')
                                ->join('salary_sheets','salary_sheets.employee_id','employment_infos.employee_id')
                                ->where('employees.company_id',Auth::user()->company_id)->where('month',$month)->where('year',$year);

        $departments            = Department::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $projects               = Project::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $branches               = Branch::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $currencies             = Currency::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();


        $department_id          = '';
        $project_id             = '';
        $branch_id              = '';
        $currency_id            = '';

        if($request->department_id != ""){
            $employment_infos   = $employment_infos->where('department_id',$request->department_id);
            $department_id      = $request->department_id;
        }

        if($request->project_id != ""){
            $employment_infos   = $employment_infos->where('project_id',$request->project_id);
            $project_id         = $request->project_id;
        }

        if($request->branch_id != ""){
            $employment_infos   = $employment_infos->where('branch_id',$request->branch_id);
            $branch_id          = $request->branch_id;
        }

        if($request->currency_id != ""){
            $employment_infos   = $employment_infos->where('currency_id',$request->currency_id);
            $currency_id        = $request->currency_id;
        }

        $employment_infos   = $employment_infos->get();

        return view('transactions.payroll.salary_sheet.details',compact('departments','projects','branches',
        'currencies','department_id','project_id','branch_id','month','currency_id','employment_infos','year'));
    }
    
    public function single_employee_details($employee_id,$month,$year) {
        $earning_details    = SalarySheetDetails::where('company_id',Auth::user()->company_id)->where('employee_id',$employee_id)->where('month',$month)->where('year',$year)->where('component_type','Earnings')->orderBy('id','asc')->get();
        $deduction_details  = SalarySheetDetails::where('company_id',Auth::user()->company_id)->where('employee_id',$employee_id)->where('month',$month)->where('year',$year)->where('component_type','Deduction')->orderBy('id','asc')->get();
        $festival_details   = SalarySheetDetails::where('company_id',Auth::user()->company_id)->where('employee_id',$employee_id)->where('month',$month)->where('year',$year)->where('component_type','Festival Bonus')->first();
        return view('transactions.payroll.salary_sheet.sheet_details',compact('earning_details','deduction_details','festival_details','employee_id'));
    }

    public function print_salary_sheet(Request $request) {
        $month = $request->month; $year = $request->year;

        $revenue_stamp  = SheetRevenueStamp::where('company_id',Auth::user()->company_id)->where('month',$month)->where('year',$year)->first();
        
        $employment_infos       = EmploymentInfo::select('employees.name','employees.employee_id as original_employee_id','employment_infos.*','salary_sheets.*','payroll_infos.currency_id')
                                ->join('payroll_infos','payroll_infos.employee_id','employment_infos.employee_id')
                                ->join('employees','employees.id','employment_infos.employee_id')
                                ->join('salary_sheets','salary_sheets.employee_id','employment_infos.employee_id')
                                ->where('employees.company_id',Auth::user()->company_id)
                                ->where('month',$request->month)
                                ->where('year',$request->year);

        $department = ""; $project = ""; $branch = ""; $currency = ""; $designation = "";

        if($request->department_id != ""){
            $employment_infos   = $employment_infos->where('department_id',$request->department_id);
            $department_id      = $request->department_id;
            $department         = Department::where('id',$department_id)->first()->name;
        }

        if($request->designation_id != ""){
            $employment_infos   = $employment_infos->where('designation_id',$request->designation_id);
            $designation_id     = $request->designation_id;
            $designation        = Designation::where('id',$designation_id)->first()->name;
        }

        if($request->project_id != ""){
            $employment_infos   = $employment_infos->where('project_id',$request->project_id);
            $project_id         = $request->project_id;
            $project            = Project::where('id',$project_id)->first()->name;
        }

        if($request->branch_id != ""){
            $employment_infos   = $employment_infos->where('branch_id',$request->branch_id);
            $branch_id          = $request->branch_id;
            $branch             = Branch::where('id',$branch_id)->first()->name;
        }

        if($request->currency_id != ""){
            $employment_infos   = $employment_infos->where('currency_id',$request->currency_id);
            $currency_id        = $request->currency_id;
            $currency           = Currency::where('id',$currency_id)->first()->currency_name;
        }
        $employment_infos       = $employment_infos->get()->toArray();
        $employee_ids           = array_column($employment_infos,'employee_id');

        // Manage Earning Components
        $earning_comps       = [];
        $earning_components = SalaryComponent::where('component_type','Earnings')
                            ->where('component_reference','!=','Gratuity')
                            ->where('component_reference','!=','PF Company Portion')
                            ->get();
        
        foreach($earning_components as $key => $row) {
            $count = SalarySheetDetails::where('month',$request->month)->where('year',$request->year)->where('component_id',$row->id)->whereIn('employee_id',$employee_ids)->count();
            if($count > 0) {
                $earning_comps[$key]['component_id']    = $row['id'];
                $earning_comps[$key]['component_name']  = $row['component_name'];
            }
        }
        $festival_bonus = SalarySheetDetails::where('month',$request->month)->where('year',$request->year)->where('component_id',0)->whereIn('employee_id',$employee_ids)->count();
        if($festival_bonus > 0) {
            $key = $key + 1;
            $earning_comps[$key]['component_id']    = 0;
            $earning_comps[$key]['component_name']  = "Festival Bonus";
        }

        // Manage Deduction Components
        $deduction_comps        = [];
        $deduction_components   = SalaryComponent::where('component_type','Deduction')->get();
        
        foreach($deduction_components as $key => $row) {
            $count = SalarySheetDetails::where('month',$request->month)->where('year',$request->year)->where('component_id',$row->id)->whereIn('employee_id',$employee_ids)->count();
            if($count > 0) {
                $deduction_comps[$key]['component_id']      = $row['id'];
                $deduction_comps[$key]['component_name']    = $row['component_name'];
            }
        }
        
        return view('transactions.payroll.salary_sheet.print_salary_sheet',compact('month','year','employee_ids','employment_infos','earning_comps','deduction_comps','department','project','branch','currency','revenue_stamp','designation'));
    }

    public function mail_pay_slip($request_month,$request_year){
        $email_setup = Email::where('company_id',Auth::user()->company_id)->first();
        
        if($email_setup == "") {
            return redirect('salary-sheet')->with('error','Please complete your mail setup first!');
        }else{
            Config::set('mail.driver', $email_setup->mail_driver);
            Config::set('mail.host', $email_setup->host_name);
            Config::set('mail.port', $email_setup->port_name);
            Config::set('mail.username', $email_setup->user_name);
            Config::set('mail.password', $email_setup->password);
            Config::set('mail.encryption', $email_setup->encryption);
            Config::set('mail.from.address', $email_setup->from_address);
            Config::set('mail.from.name', $email_setup->from_name);


            $month  = date('M-Y', strtotime($request_month."-".$request_year));

            $company_info = Company::where('id',Auth::user()->company_id)->first();

            $employees = Employee::where('company_id',Auth::user()->company_id)
                        ->select('employees.name','employees.email_address','employees.employee_id as original_employee_id','employment_infos.*')
                        ->join('employment_infos','employment_infos.employee_id','employees.id')
                        ->get();
            
            foreach($employees as $employee) {
                $month_first_date   = date('Y-m-d', strtotime("01-".$month));
                $month_last_date    = date('Y-m-d', strtotime("31-".$month));
                $total_days         = date('t', strtotime($month));

                // GET ATTENDANCE DATA

                $total_present_days = Attendance::where('company_id',Auth::user()->company_id)->where('employee_id',$employee->id)->whereBetween('date', [$month_first_date, $month_last_date])->where('status','PRESENT')->count();
                $total_day_off      = Attendance::where('company_id',Auth::user()->company_id)->where('employee_id',$employee->id)->whereBetween('date', [$month_first_date, $month_last_date])->where('status','WEEKLY_HOLIDAY')->count();
                $total_holidays     = Attendance::where('company_id',Auth::user()->company_id)->where('employee_id',$employee->id)->whereBetween('date', [$month_first_date, $month_last_date])->where('status','GOVT_HOLIDAY')->count();
                $total_late_days    = Attendance::where('company_id',Auth::user()->company_id)->where('employee_id',$employee->id)->whereBetween('date', [$month_first_date, $month_last_date])->where('late','>','0')->count();
                $total_absent_days  = Attendance::where('company_id',Auth::user()->company_id)->where('employee_id',$employee->id)->whereBetween('date', [$month_first_date, $month_last_date])->where('status','ABSENT')->count();
                $net_payable_days   = $total_days - $total_absent_days;

                $total_approved_leave_days  = 0;

                $approved_leave_requests    = LeaveRequest::where('company_id',Auth::user()->company_id)->where('employee_id',$employee->id)
                                            ->whereBetween('start_date', [$month_first_date, $month_last_date])
                                            ->whereBetween('end_date', [$month_first_date, $month_last_date])
                                            ->where('status','Approved')
                                            ->get();

                foreach($approved_leave_requests as $leave) {
                    $total_approved_leave_days = $total_approved_leave_days + $leave->leave_days;
                }

                $total_work_in_leave_days  = Attendance::where('company_id',Auth::user()->company_id)->where('employee_id',$employee->id)->whereBetween('date', [$month_first_date, $month_last_date])->where('work_in_leave_day',1)->count();

                $total_leave_days   = $total_approved_leave_days - $total_work_in_leave_days;

                $data["email"]          = $employee->email_address;
                $data["client_name"]    = $employee->name;
                $data["subject"]        = 'Pay Slip of '.$month;
                $data["body"]           = 'Pay Slip of '.$month;

                // GET SALARY DATA
                $pay_slip_data = []; 
                $earning_components = SalarySheetDetails::where('employee_id',$employee->id)
                            ->where('month',$request_month)
                            ->where('year',$request_year)
                            ->where('component_type','!=','Deduction')
                            ->get();    
                $total_earning = 0;
                foreach($earning_components as $row) {
                    $total_earning = $total_earning + $row->payable_amount;
                }

                $deduction_components = SalarySheetDetails::where('employee_id',$employee->id)
                            ->where('month',$request_month)
                            ->where('year',$request_year)
                            ->where('component_type','Deduction')
                            ->get();  
                $total_deduction = 0;
                foreach($deduction_components as $row) {
                    $total_deduction = $total_deduction + $row->payable_amount;
                }
                            
                $count_earning_components = count($earning_components);
                
                for($i = 0; $i < $count_earning_components; $i++) {
                    $pay_slip_data[$i]['earning_component'] = $earning_components[$i]['component_name'];
                    $pay_slip_data[$i]['earning_amount']    = $earning_components[$i]['payable_amount'];

                    if(isset($deduction_components[$i])) {
                        $pay_slip_data[$i]['deduction_component']   = $deduction_components[$i]['component_name'];
                        $pay_slip_data[$i]['deduction_amount']      = $deduction_components[$i]['payable_amount'];
                    }else {
                        $pay_slip_data[$i]['deduction_component']   = "";
                        $pay_slip_data[$i]['deduction_amount']      = "";
                    }
                }
                $company_pf = ProvidentFund::where('employee_id',$employee->id)->where('month',$request_month)
                            ->where('year',$request_year)->where('type','Company Portion')->where('status',0)->first();
                if($company_pf != "") {
                    $company_pf = $company_pf->amount;
                }else {
                    $company_pf = 0;
                }

                $pdf = PDF::loadView('transactions.payroll.salary_sheet.email.pay_slip',compact('company_info','month',
                        'employee','total_present_days','total_day_off','total_work_in_leave_days','total_leave_days',
                        'total_holidays','total_late_days','total_absent_days','net_payable_days','pay_slip_data','total_earning','total_deduction','company_pf'));
                
                try{
                    Mail::send('transactions.payroll.salary_sheet.email.body', compact('data'), function($message)use($data,$pdf) {
                    $message->to($data["email"], $data["client_name"])
                        ->subject($data["subject"])
                        ->attachData($pdf->output(), "PaySlip.pdf");
                    });

                    $error      =   "";
                    $message    =   "Message sent Succesfully!";
                    $status     =   "1";
                }catch(Swift_SwiftException $Ste){
                    $this->serverstatuscode = "0";
                    $this->serverstatusdes = $Ste->getMessage();

                    $error      =   $Ste->getMessage();
                    $message    =   "Error sending mail!";
                    $status     =   "0";
                }
            }

            $pay_slip = MailPaySlip::where('company_id',Auth::user()->company_id)->where('month',$request_month)->where('year',$request_year)->count();
            if($pay_slip == 0) {
                $slip = new MailPaySlip();
                $slip->company_id   = Auth::user()->company_id;
                $slip->month        = $request_month;
                $slip->year         = $request_year;
                $slip->save();
            }
        }

        return redirect('salary-sheet')->with('message','Pay Slip Mailed Successfully!');
    }

    public function single_employee_details_print($employee_id,$request_month,$request_year){

        $month  = date('M-Y', strtotime($request_month."-".$request_year));

        $company_info = Company::where('id',Auth::user()->company_id)->first();

        $employee       = Employee::where('id',$employee_id)->first();
        $employment_info = EmploymentInfo::where('employee_id',$employee_id)->first();

        $month_first_date   = date('Y-m-d', strtotime("01-".$month));
        $month_last_date    = date('Y-m-d', strtotime("31-".$month));
        $total_days         = date('t', strtotime($month));

        // GET ATTENDANCE DATA

        $total_present_days = Attendance::where('company_id',Auth::user()->company_id)->where('employee_id',$employee->id)->whereBetween('date', [$month_first_date, $month_last_date])->where('status','PRESENT')->count();
        $total_day_off      = Attendance::where('company_id',Auth::user()->company_id)->where('employee_id',$employee->id)->whereBetween('date', [$month_first_date, $month_last_date])->where('status','WEEKLY_HOLIDAY')->count();
        $total_holidays     = Attendance::where('company_id',Auth::user()->company_id)->where('employee_id',$employee->id)->whereBetween('date', [$month_first_date, $month_last_date])->where('status','GOVT_HOLIDAY')->count();
        $total_late_days    = Attendance::where('company_id',Auth::user()->company_id)->where('employee_id',$employee->id)->whereBetween('date', [$month_first_date, $month_last_date])->where('late','>','0')->count();
        $total_absent_days  = Attendance::where('company_id',Auth::user()->company_id)->where('employee_id',$employee->id)->whereBetween('date', [$month_first_date, $month_last_date])->where('status','ABSENT')->count();
        $net_payable_days   = $total_days - $total_absent_days;

        $total_approved_leave_days  = 0;

        $approved_leave_requests    = LeaveRequest::where('company_id',Auth::user()->company_id)->where('employee_id',$employee->id)
                                    ->whereBetween('start_date', [$month_first_date, $month_last_date])
                                    ->whereBetween('end_date', [$month_first_date, $month_last_date])
                                    ->where('status','Approved')
                                    ->get();

        foreach($approved_leave_requests as $leave) {
            $total_approved_leave_days = $total_approved_leave_days + $leave->leave_days;
        }

        $total_work_in_leave_days  = Attendance::where('company_id',Auth::user()->company_id)->where('employee_id',$employee->id)->whereBetween('date', [$month_first_date, $month_last_date])->where('work_in_leave_day',1)->count();

        $total_leave_days   = $total_approved_leave_days - $total_work_in_leave_days;

        // GET SALARY DATA
        $pay_slip_data = []; 
        $earning_components = SalarySheetDetails::where('employee_id',$employee->id)
                    ->where('month',$request_month)
                    ->where('year',$request_year)
                    ->where('component_type','!=','Deduction')
                    ->get();    
        $total_earning = 0;
        foreach($earning_components as $row) {
            $total_earning = $total_earning + $row->payable_amount;
        }

        $deduction_components = SalarySheetDetails::where('employee_id',$employee->id)
                    ->where('month',$request_month)
                    ->where('year',$request_year)
                    ->where('component_type','Deduction')
                    ->get();  
        $total_deduction = 0;
        foreach($deduction_components as $row) {
            $total_deduction = $total_deduction + $row->payable_amount;
        }
                    
        $count_earning_components = count($earning_components);
        
        for($i = 0; $i < $count_earning_components; $i++) {
            $pay_slip_data[$i]['earning_component'] = $earning_components[$i]['component_name'];
            $pay_slip_data[$i]['earning_amount']    = $earning_components[$i]['payable_amount'];

            if(isset($deduction_components[$i])) {
                $pay_slip_data[$i]['deduction_component']   = $deduction_components[$i]['component_name'];
                $pay_slip_data[$i]['deduction_amount']      = $deduction_components[$i]['payable_amount'];
            }else {
                $pay_slip_data[$i]['deduction_component']   = "";
                $pay_slip_data[$i]['deduction_amount']      = "";
            }
        }
        $company_pf = ProvidentFund::where('employee_id',$employee->id)->where('month',$request_month)
                    ->where('year',$request_year)->where('type','Company Portion')->where('status',0)->first();
        if($company_pf != "") {
            $company_pf = $company_pf->amount;
        }else {
            $company_pf = 0;
        }

        return view('transactions.payroll.salary_sheet.print_pay_slip',compact('company_info','month','employee','total_present_days',
                'total_day_off','total_work_in_leave_days','total_leave_days','employment_info','total_holidays','total_late_days',
                'total_absent_days','net_payable_days','pay_slip_data','total_earning','total_deduction','company_pf'));
    }

    public function single_employee_details_mail($employee_id,$request_month,$request_year){
        $email_setup = Email::where('company_id',Auth::user()->company_id)->first();
        
        if($email_setup == "") {
            return redirect('salary-sheet')->with('error','Please complete your mail setup first!');
        }else{
            Config::set('mail.driver', $email_setup->mail_driver);
            Config::set('mail.host', $email_setup->host_name);
            Config::set('mail.port', $email_setup->port_name);
            Config::set('mail.username', $email_setup->user_name);
            Config::set('mail.password', $email_setup->password);
            Config::set('mail.encryption', $email_setup->encryption);
            Config::set('mail.from.address', $email_setup->from_address);
            Config::set('mail.from.name', $email_setup->from_name);


            $month  = date('M-Y', strtotime($request_month."-".$request_year));

            $company_info       = Company::where('id',Auth::user()->company_id)->first();

            $employee           = Employee::where('id',$employee_id)->first();
            $employment_info    = EmploymentInfo::where('employee_id',$employee_id)->first();
            
            $month_first_date   = date('Y-m-d', strtotime("01-".$month));
            $month_last_date    = date('Y-m-d', strtotime("31-".$month));
            $total_days         = date('t', strtotime($month));

            // GET ATTENDANCE DATA

            $total_present_days = Attendance::where('company_id',Auth::user()->company_id)->where('employee_id',$employee->id)->whereBetween('date', [$month_first_date, $month_last_date])->where('status','PRESENT')->count();
            $total_day_off      = Attendance::where('company_id',Auth::user()->company_id)->where('employee_id',$employee->id)->whereBetween('date', [$month_first_date, $month_last_date])->where('status','WEEKLY_HOLIDAY')->count();
            $total_holidays     = Attendance::where('company_id',Auth::user()->company_id)->where('employee_id',$employee->id)->whereBetween('date', [$month_first_date, $month_last_date])->where('status','GOVT_HOLIDAY')->count();
            $total_late_days    = Attendance::where('company_id',Auth::user()->company_id)->where('employee_id',$employee->id)->whereBetween('date', [$month_first_date, $month_last_date])->where('late','>','0')->count();
            $total_absent_days  = Attendance::where('company_id',Auth::user()->company_id)->where('employee_id',$employee->id)->whereBetween('date', [$month_first_date, $month_last_date])->where('status','ABSENT')->count();
            $net_payable_days   = $total_days - $total_absent_days;

            $total_approved_leave_days  = 0;

            $approved_leave_requests    = LeaveRequest::where('company_id',Auth::user()->company_id)->where('employee_id',$employee->id)
                                        ->whereBetween('start_date', [$month_first_date, $month_last_date])
                                        ->whereBetween('end_date', [$month_first_date, $month_last_date])
                                        ->where('status','Approved')
                                        ->get();

            foreach($approved_leave_requests as $leave) {
                $total_approved_leave_days = $total_approved_leave_days + $leave->leave_days;
            }

            $total_work_in_leave_days  = Attendance::where('company_id',Auth::user()->company_id)->where('employee_id',$employee->id)->whereBetween('date', [$month_first_date, $month_last_date])->where('work_in_leave_day',1)->count();

            $total_leave_days   = $total_approved_leave_days - $total_work_in_leave_days;

            $data["email"]          = $employee->email_address;
            $data["client_name"]    = $employee->name;
            $data["subject"]        = 'Pay Slip of '.$month;
            $data["body"]           = 'Pay Slip of '.$month;

            // GET SALARY DATA
            $pay_slip_data = []; 
            $earning_components = SalarySheetDetails::where('employee_id',$employee->id)
                        ->where('month',$request_month)
                        ->where('year',$request_year)
                        ->where('component_type','!=','Deduction')
                        ->get();    
            $total_earning = 0;
            foreach($earning_components as $row) {
                $total_earning = $total_earning + $row->payable_amount;
            }

            $deduction_components = SalarySheetDetails::where('employee_id',$employee->id)
                        ->where('month',$request_month)
                        ->where('year',$request_year)
                        ->where('component_type','Deduction')
                        ->get();  
            $total_deduction = 0;
            foreach($deduction_components as $row) {
                $total_deduction = $total_deduction + $row->payable_amount;
            }
                        
            $count_earning_components = count($earning_components);
            
            for($i = 0; $i < $count_earning_components; $i++) {
                $pay_slip_data[$i]['earning_component'] = $earning_components[$i]['component_name'];
                $pay_slip_data[$i]['earning_amount']    = $earning_components[$i]['payable_amount'];

                if(isset($deduction_components[$i])) {
                    $pay_slip_data[$i]['deduction_component']   = $deduction_components[$i]['component_name'];
                    $pay_slip_data[$i]['deduction_amount']      = $deduction_components[$i]['payable_amount'];
                }else {
                    $pay_slip_data[$i]['deduction_component']   = "";
                    $pay_slip_data[$i]['deduction_amount']      = "";
                }
            }
            $company_pf = ProvidentFund::where('employee_id',$employee->id)->where('month',$request_month)
                        ->where('year',$request_year)->where('type','Company Portion')->where('status',0)->first();
            if($company_pf != "") {
                $company_pf = $company_pf->amount;
            }else {
                $company_pf = 0;
            }

            $pdf = PDF::loadView('transactions.payroll.salary_sheet.email.mail_pay_slip',compact('company_info','month',
                    'employee','total_present_days','total_day_off','total_work_in_leave_days','total_leave_days','employment_info',
                    'total_holidays','total_late_days','total_absent_days','net_payable_days','pay_slip_data','total_earning','total_deduction','company_pf'));
            
            try{
                Mail::send('transactions.payroll.salary_sheet.email.body', compact('data'), function($message)use($data,$pdf) {
                $message->to($data["email"], $data["client_name"])
                    ->subject($data["subject"])
                    ->attachData($pdf->output(), "PaySlip.pdf");
                });

                $error      =   "";
                $message    =   "Message sent Succesfully!";
                $status     =   "1";
            }catch(Swift_SwiftException $Ste){
                $this->serverstatuscode = "0";
                $this->serverstatusdes = $Ste->getMessage();

                $error      =   $Ste->getMessage();
                $message    =   "Error sending mail!";
                $status     =   "0";
            }

            /*$pay_slip = MailPaySlip::where('company_id',Auth::user()->company_id)->where('month',$request_month)->where('year',$request_year)->count();
            if($pay_slip == 0) {
                $slip = new MailPaySlip();
                $slip->company_id   = Auth::user()->company_id;
                $slip->month        = $request_month;
                $slip->year         = $request_year;
                $slip->save();
            }*/
        }

        return back()->with('message','Pay Slip Mailed Successfully!');
    }
}
