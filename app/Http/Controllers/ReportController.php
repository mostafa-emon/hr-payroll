<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EmploymentInfo;
use App\Employee;
use App\Department;
use App\Designation;
use App\Vertical;
use App\Section;
use App\JobLevel;
use App\SalaryComponent;
use App\ProvidentFund;
use App\Currency;
use App\SalaryTransferLetter;
use App\PayrollBank;
use App\SalaryTransferLetterDetail;
use App\SalarySheetDetails;
use App\DepositSalaryTax;
use App\DepositSalaryTaxDetail;
use App\Audit;
use Auth;
use Excel;
use Carbon;
use DB;
use DateTime;
use DateInterval;
use DatePeriod;
use App\Exports\EarningAdjustmentReport;
use App\Exports\DeductionAdjustmentReport;
use App\Exports\PfDetailReport;
use App\Exports\PfSummaryReport;
use App\Exports\SalarySheetReport;
use App\Exports\SalaryCertificate;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //Employee List
    public function employee_list_report(Request $request) {
        if(roles() != "" && !in_array(38, json_decode(roles(),false))){
            return redirect('404');
        }

        $employment_infos       = EmploymentInfo::select('employment_infos.*','employees.id','employees.employee_id as string_employee_id','employees.name','employees.gender','employees.blood_group','employees.date_of_birth','employees.religion','employees.phone_1','employees.nid_number')
                                ->join('employees','employees.id','employment_infos.employee_id')
                                ->where('employees.company_id',Auth::user()->company_id)
                                ->where('current_status','Active')
                                ->orderBy('department_id','asc');

        $departments            = Department::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $designations           = Designation::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();

        $department_id          = '';
        $designation_id         = '';
        $religion               = '';
        $gender                 = '';
        $duty_type              = '';
        $blood_group            = '';
        $employees              = [];
        $original_employee_id   = '';

        if($request->original_employee_id != ""){
            $employment_infos   = $employment_infos->where('employees.employee_id',$request->original_employee_id);
            $original_employee_id = $request->original_employee_id;
        }else{
            if($request->department_id != ""){
                $employment_infos   = $employment_infos->where('department_id',$request->department_id);
                $department_id      = $request->department_id;
            }

            if($request->designation_id != ""){
                $employment_infos   = $employment_infos->where('designation_id',$request->designation_id);
                $designation_id     = $request->designation_id;
            }



            if($request->religion != ""){
                $employment_infos   = $employment_infos->where('religion',$request->religion);
                $religion           = $request->religion;
            }

            if($request->gender != ""){
                $employment_infos   = $employment_infos->where('gender',$request->gender);
                $gender             = $request->gender;
            }

            if($request->blood_group != ""){
                $employment_infos   = $employment_infos->where('blood_group',$request->blood_group);
                if($request->blood_group == "AB+") {
                    $blood_group        = 'AB Positive';

                }elseif($request->blood_group == "AB-") {
                    $blood_group        = 'AB Negative';

                }elseif($request->blood_group == "A+") {
                    $blood_group        = 'A Positive';

                }elseif($request->blood_group == "A-") {
                    $blood_group        = 'A Negative';

                }elseif($request->blood_group == "B+") {
                    $blood_group        = 'B Positive';

                }elseif($request->blood_group == "B-") {
                    $blood_group        = 'B Negative';

                }elseif($request->blood_group == "O+") {
                    $blood_group        = 'O Positive';
                    
                }elseif($request->blood_group == "O-") {
                    $blood_group        = 'O Negative';
                }
            }

            if($request->duty_type != ""){
                $employment_infos   = $employment_infos->where('duty_type',$request->duty_type);
                $duty_type          = $request->duty_type;
            }
        }

        if($request->job            == "1"){
            $employees              = $employment_infos->get();
        }

        $excel_link = "export/employee-list-report?department_id=".$department_id."&designation_id=".$designation_id.
        "&religion=".$religion."&gender=".$gender."&blood_group=".$blood_group."&duty_type=".$duty_type.
        "&original_employee_id=".$original_employee_id;

        return view('reports.employee_list',
        compact('departments', 'designations','department_id','designation_id',
        'religion','gender','blood_group','duty_type','employees','original_employee_id','excel_link'));
    }

    public function export_employee_list_report(){
        return Excel::download(new EmployeeListReport(), 'Employee List.xlsx');
    }

    //Inactive Employee List
    public function inactive_employee_list_report(Request $request) {
        if(roles() != "" && !in_array(39, json_decode(roles(),false))){
            return redirect('404');
        }

        $employment_infos       = EmploymentInfo::select('employment_infos.*','employees.id','employees.employee_id as string_employee_id','employees.name','employees.gender','employees.blood_group','employees.date_of_birth','employees.religion','employees.phone_1','employees.nid_number')
                                ->join('employees','employees.id','employment_infos.employee_id')
                                ->where('employees.company_id',Auth::user()->company_id)
                                ->where('current_status','Inactive')
                                ->orderBy('department_id','asc');

        $departments            = Department::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $designations           = Designation::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();

        $department_id          = '';
        $designation_id         = '';
        $religion               = '';
        $gender                 = '';
        $duty_type              = '';
        $blood_group            = '';
        $employees              = [];
        $original_employee_id   = '';

        if($request->original_employee_id != ""){
            $employment_infos   = $employment_infos->where('employees.employee_id',$request->original_employee_id);
            $original_employee_id = $request->original_employee_id;
        }else{
            if($request->department_id != ""){
                $employment_infos   = $employment_infos->where('department_id',$request->department_id);
                $department_id      = $request->department_id;
            }

            if($request->designation_id != ""){
                $employment_infos   = $employment_infos->where('designation_id',$request->designation_id);
                $designation_id     = $request->designation_id;
            }



            if($request->religion != ""){
                $employment_infos   = $employment_infos->where('religion',$request->religion);
                $religion           = $request->religion;
            }

            if($request->gender != ""){
                $employment_infos   = $employment_infos->where('gender',$request->gender);
                $gender             = $request->gender;
            }

            if($request->blood_group != ""){
                $employment_infos   = $employment_infos->where('blood_group',$request->blood_group);
                if($request->blood_group == "AB+") {
                    $blood_group        = 'AB Positive';

                }elseif($request->blood_group == "AB-") {
                    $blood_group        = 'AB Negative';

                }elseif($request->blood_group == "A+") {
                    $blood_group        = 'A Positive';

                }elseif($request->blood_group == "A-") {
                    $blood_group        = 'A Negative';

                }elseif($request->blood_group == "B+") {
                    $blood_group        = 'B Positive';

                }elseif($request->blood_group == "B-") {
                    $blood_group        = 'B Negative';

                }elseif($request->blood_group == "O+") {
                    $blood_group        = 'O Positive';
                    
                }elseif($request->blood_group == "O-") {
                    $blood_group        = 'O Negative';
                }
            }

            if($request->duty_type != ""){
                $employment_infos   = $employment_infos->where('duty_type',$request->duty_type);
                $duty_type          = $request->duty_type;
            }
        }

        if($request->job            == "1"){
            $employees              = $employment_infos->get();
        }

        $excel_link = "export/inactive-employee-list-report?department_id=".$department_id."&designation_id=".$designation_id.
        "&religion=".$religion."&gender=".$gender."&blood_group=".$blood_group."&duty_type=".$duty_type.
        "&original_employee_id=".$original_employee_id;

        return view('reports.inactive_employee_list',
        compact('departments', 'designations','department_id','designation_id',
        'religion','gender','blood_group','duty_type','employees','original_employee_id','excel_link'));
    }

    public function export_inactive_employee_list_report(){
        return Excel::download(new InactiveEmployeeListReport(), 'Inactive Employee List.xlsx');
    }
    

    //Payroll

    //Earning Adjustment Report
    public function earning_adjustment_report(Request $request) {
        if(roles() != "" && !in_array(147, json_decode(roles(),false))){
            return redirect('404');
        }

        $employment_infos   = EmploymentInfo::select('earning_deduction_adjustments.*','employment_infos.*','employees.id','employees.employee_id as string_employee_id','employees.name','employees.gender','employees.blood_group','employees.date_of_birth','employees.religion','employees.phone_1','employees.nid_number')
                            ->join('employees','employees.id','employment_infos.employee_id')
                            ->join('earning_deduction_adjustments','earning_deduction_adjustments.employee_id','employment_infos.employee_id')
                            ->where('employees.company_id',Auth::user()->company_id)
                            ->where('earning_deduction_adjustments.status',1)
                            ->where('earning_deduction_adjustments.earning_or_deduction','earnings')
                            ->orderBy('earning_deduction_adjustments.salary_component_id','asc');

        $departments        = Department::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $designations       = Designation::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $salary_components  = SalaryComponent::where('company_id',Auth::user()->company_id)->where('component_type','Earnings')->orderBy('id','asc')->get();

        $department_id      = '';
        $designation_id     = '';
        $employee_id        = '';
        $employees          = [];
        $select_employees   = [];
        $from_date          = '';
        $to_date            = '';
        $component_id       = '';
        $period             = [];

        if($request->department_id != ""){
            $employment_infos   = $employment_infos->where('department_id',$request->department_id);
            $department_id      = $request->department_id;
        }

        if($request->designation_id != ""){
            $employment_infos   = $employment_infos->where('designation_id',$request->designation_id);
            $designation_id     = $request->designation_id;
        }


        
        if($request->component_id != ""){
            $employment_infos   = $employment_infos->where('earning_deduction_adjustments.salary_component_id',$request->component_id);
            $component_id       = $request->component_id;
        }

        if($request->employee_id != ""){
            $employment_infos   = $employment_infos->where('earning_deduction_adjustments.employee_id',$request->employee_id);
            $employee_id        = $request->employee_id;
        }

        if($request->from_date != null){
            $from_date = date('Y-m-01',strtotime($request->from_date ));
        }
        if($request->to_date != null){
            $to_date = date('Y-m-t',strtotime($request->to_date ));
        }

        if($from_date != null && $to_date != null) {
            $employment_infos   = $employment_infos->whereBetween('earning_deduction_adjustments.query_date',[$from_date,$to_date]);

            $start    = (new DateTime($from_date))->modify('first day of this month');
            $end      = (new DateTime($to_date))->modify('first day of next month');
            $interval = DateInterval::createFromDateString('1 month');
            $period   = new DatePeriod($start, $interval, $end);
        }

        if($request->job            == "1"){
            $employees              = $employment_infos->groupBy('earning_deduction_adjustments.salary_component_id','earning_deduction_adjustments.employee_id')->get();
        }

        if($request->employee_id == "") {
            $select_employees = EmploymentInfo::select('employment_infos.*','employees.id','employees.employee_id as string_employee_id','employees.name')
                                ->join('employees','employees.id','employment_infos.employee_id')
                                ->where('employees.company_id',Auth::user()->company_id)
                                ->orderBy('department_id','asc')->get();


            $employment_infos = $employment_infos->get();
        }

        $excel_link = "export/earning-adjustment-report?department_id=".$department_id."&designation_id=".$designation_id."&component_id=".$component_id."&employee_id=".$employee_id."&from_date=".$from_date.
        "&to_date=".$to_date;

        return view('reports.earning_adjustment',
        compact('departments','designations','department_id','employees','from_date','select_employees',
        'employment_infos','employee_id','designation_id','to_date','salary_components','period','excel_link'));
    }

    public function export_earning_adjustment_report(){
        return Excel::download(new EarningAdjustmentReport(), 'Earning Adjustment Report.xlsx');
    }

    //Deduction Adjustment Report
    public function deduction_adjustment_report(Request $request) {
        if(roles() != "" && !in_array(148, json_decode(roles(),false))){
            return redirect('404');
        }
        
        $employment_infos   = EmploymentInfo::select('earning_deduction_adjustments.*','employment_infos.*','employees.id','employees.employee_id as string_employee_id','employees.name','employees.gender','employees.blood_group','employees.date_of_birth','employees.religion','employees.phone_1','employees.nid_number')
                            ->join('employees','employees.id','employment_infos.employee_id')
                            ->join('earning_deduction_adjustments','earning_deduction_adjustments.employee_id','employment_infos.employee_id')
                            ->where('employees.company_id',Auth::user()->company_id)
                            ->where('earning_deduction_adjustments.status',1)
                            ->where('earning_deduction_adjustments.earning_or_deduction','deductions')
                            ->orderBy('earning_deduction_adjustments.salary_component_id','asc');

        $departments        = Department::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $designations       = Designation::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $salary_components  = SalaryComponent::where('company_id',Auth::user()->company_id)->where('component_type','Deduction')->orderBy('id','asc')->get();

        $department_id      = '';
        $designation_id     = '';
        $employee_id        = '';
        $employees          = [];
        $select_employees   = [];
        $from_date          = '';
        $to_date            = '';
        $component_id       = '';
        $period             = [];

        if($request->department_id != ""){
            $employment_infos   = $employment_infos->where('department_id',$request->department_id);
            $department_id      = $request->department_id;
        }

        if($request->designation_id != ""){
            $employment_infos   = $employment_infos->where('designation_id',$request->designation_id);
            $designation_id     = $request->designation_id;
        }


        
        if($request->component_id != ""){
            $employment_infos   = $employment_infos->where('earning_deduction_adjustments.salary_component_id',$request->component_id);
            $component_id       = $request->component_id;
        }

        if($request->employee_id != ""){
            $employment_infos   = $employment_infos->where('earning_deduction_adjustments.employee_id',$request->employee_id);
            $employee_id        = $request->employee_id;
        }

        if($request->from_date != null){
            $from_date = date('Y-m-01',strtotime($request->from_date ));
        }
        if($request->to_date != null){
            $to_date = date('Y-m-t',strtotime($request->to_date ));
        }

        if($from_date != null && $to_date != null) {
            $employment_infos   = $employment_infos->whereBetween('earning_deduction_adjustments.query_date',[$from_date,$to_date]);

            $start    = (new DateTime($from_date))->modify('first day of this month');
            $end      = (new DateTime($to_date))->modify('first day of next month');
            $interval = DateInterval::createFromDateString('1 month');
            $period   = new DatePeriod($start, $interval, $end);
        }

        if($request->job            == "1"){
            $employees              = $employment_infos->groupBy('earning_deduction_adjustments.salary_component_id','earning_deduction_adjustments.employee_id')->get();
        }

        if($request->employee_id == "") {
            $select_employees = EmploymentInfo::select('employment_infos.*','employees.id','employees.employee_id as string_employee_id','employees.name')
                                ->join('employees','employees.id','employment_infos.employee_id')
                                ->where('employees.company_id',Auth::user()->company_id)
                                ->orderBy('department_id','asc')->get();


            $employment_infos = $employment_infos->get();
        }

        $excel_link = "export/deduction-adjustment-report?department_id=".$department_id."&designation_id=".$designation_id."&component_id=".$component_id."&employee_id=".$employee_id."&from_date=".$from_date.
        "&to_date=".$to_date;

        return view('reports.deduction_adjustment',
        compact('departments','designations','department_id','employees','from_date','select_employees',
        'employment_infos','employee_id','designation_id','to_date','salary_components','period','excel_link'));
    }

    public function export_deduction_adjustment_report(){
        return Excel::download(new DeductionAdjustmentReport(), 'Deduction Adjustment Report.xlsx');
    }

    //PF Detail Report
    public function pf_detail_report(Request $request) {
        if(roles() != "" && !in_array(150, json_decode(roles(),false))){
            return redirect('404');
        }

        $employment_infos   = ProvidentFund::select('employment_infos.*','provident_funds.*','employees.id','employees.employee_id as string_employee_id','employees.name')
                            ->join('employees','employees.id','provident_funds.employee_id')
                            ->join('employment_infos','employment_infos.employee_id','provident_funds.employee_id')
                            ->where('employees.company_id',Auth::user()->company_id)
                            ->orderBy('provident_funds.id','asc');

        $departments        = Department::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $designations       = Designation::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();

        $last_week          = Carbon\Carbon::now()->subWeek()->format('Y-m-d');
        $current_date       = Carbon\Carbon::now()->format('Y-m-d');

        $department_id          = '';
        $designation_id         = '';
        $employee_id            = '';
        $employees              = [];
        $select_employees       = [];
        $from_date              = '';
        $to_date                = '';
        $original_employee_id   = '';
        $employee_selection     = '';
        $selected_employee_id   = '';
        $show_previous_balance  = '';

        if($request->original_employee_id != ""){
            $employment_infos   = $employment_infos->where('employees.employee_id',$request->original_employee_id);
            $original_employee_id = $request->original_employee_id;
        }else{
            if($request->department_id != ""){
                $employment_infos   = $employment_infos->where('department_id',$request->department_id);
                $department_id      = $request->department_id;
            }
    
            if($request->designation_id != ""){
                $employment_infos   = $employment_infos->where('designation_id',$request->designation_id);
                $designation_id     = $request->designation_id;
            }
        }

        if($request->show_previous_balance != ""){
            $show_previous_balance  = $request->show_previous_balance;
        }

        if($request->from_date != null){
            $from_date = date('Y-m-01',strtotime($request->from_date ));
        }
        if($request->to_date != null){
            $to_date = date('Y-m-t',strtotime($request->to_date ));
        }

        if($from_date != null && $to_date != null) {
            $employment_infos   = $employment_infos->whereBetween('provident_funds.query_date',[$from_date,$to_date]);
        }

        if($request->original_employee_id != "") {
            $employee_id = $request->original_employee_id;
        }elseif($request->employee_id != "") {
            $employee_id = $request->employee_id;
        }

        if($employee_id != "") {
            $employee_selection     = Employee::where('company_id',Auth::user()->company_id)->where('employee_id',$employee_id)->first();
            $selected_employee_id   = $employee_selection->id;

            $employees              = $employment_infos->where('provident_funds.employee_id',$employee_selection->id)->groupBy('provident_funds.query_date')->get();
        }

        if($request->employee_id == "") {
            $select_employees = EmploymentInfo::select('employment_infos.*','employees.id','employees.employee_id as string_employee_id','employees.name')
                                ->join('employees','employees.id','employment_infos.employee_id')
                                ->where('employees.company_id',Auth::user()->company_id)
                                ->orderBy('department_id','asc')->get();


            $employment_infos = $employment_infos->get();
        }

        $excel_link = "export/pf-detail-report?from_date=".$from_date."&to_date=".$to_date."&employee_id=".$selected_employee_id."&show_previous_balance=".$show_previous_balance;

        return view('reports.pf_detail',
        compact('departments','designations','department_id','employees','from_date','select_employees','show_previous_balance',
        'employment_infos','employee_id','designation_id','to_date','original_employee_id','employee_selection','excel_link'));
    }

    public function export_pf_detail_report(){
        return Excel::download(new PfDetailReport(), 'PF Detail Report Individual.xlsx');
    }

    //PF Summary Report
    public function pf_summary_report(Request $request) {
        if(roles() != "" && !in_array(149, json_decode(roles(),false))){
            return redirect('404');
        }

        $employment_infos   = ProvidentFund::select('employment_infos.*','provident_funds.id as provident_fund_id','provident_funds.employee_id','provident_funds.type','provident_funds.month','provident_funds.year','provident_funds.amount','provident_funds.query_date','provident_funds.status','employees.id','employees.employee_id as string_employee_id','employees.name')
                            ->join('employees','employees.id','provident_funds.employee_id')
                            ->join('employment_infos','employment_infos.employee_id','provident_funds.employee_id')
                            ->where('employees.company_id',Auth::user()->company_id)
                            ->orderBy('provident_funds.query_date','asc');

        $departments        = Department::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $designations       = Designation::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();

        $last_week          = Carbon\Carbon::now()->subWeek()->format('Y-m-d');
        $current_date       = Carbon\Carbon::now()->format('Y-m-d');

        $department_id          = '';
        $designation_id         = '';
        $employee_id            = [];
        $all_employee           = '';
        $remark                 = '';
        $employees              = [];
        $remark                 = '';
        $selected_employee_id   = '';
        $from_date              = '';
        $to_date                = '';
        $select_employees       = [];
        $selected_provident_fund_id = '';
        $show_previous_balance  = '';
        $show_current_period    = '';
        $show_closing_balance   = '';

        if($request->show_previous_balance != ""){
            $show_previous_balance  = $request->show_previous_balance;
        }

        if($request->show_current_period != ""){
            $show_current_period    = $request->show_current_period;
        }

        if($request->show_closing_balance != ""){
            $show_closing_balance   = $request->show_closing_balance;
        }

        if($request->department_id != ""){
            $employment_infos   = $employment_infos->where('department_id',$request->department_id);
            $department_id      = $request->department_id;
        }

        if($request->designation_id != ""){
            $employment_infos   = $employment_infos->where('designation_id',$request->designation_id);
            $designation_id     = $request->designation_id;
        }



        if($request->from_date != null){
            $from_date = date('Y-m-01',strtotime($request->from_date ));
        }
        if($request->to_date != null){
            $to_date = date('Y-m-t',strtotime($request->to_date ));
        }

        if($request->employee_id != "") {
            if(!in_array("All", $request->employee_id)) {
                $employee_id    = $request->employee_id;

                $employment_infos = $employment_infos->whereIn('employees.employee_id',$employee_id)->get();

                $provident_fund_id  = [];
                foreach($employment_infos as $provident_fund) {
                    $provident_fund_id[] = $provident_fund->provident_fund_id;
                }
                
                $selected_provident_fund_id = implode(" ",$provident_fund_id);

            }else{
                $employees      = $employment_infos;

                $employment_infos = $employment_infos->get();

                $provident_fund_id  = [];
                foreach($employment_infos as $provident_fund) {
                    $provident_fund_id[] = $provident_fund->provident_fund_id;
                }

                $all_employee = 'All';
                
                $selected_provident_fund_id = implode(" ",$provident_fund_id);
            }


            $employees = ProvidentFund::whereIn('id',$provident_fund_id)->groupBy('employee_id')->get();
        }

        if($request->employee_id == "" && $request->employee_id != ['All']) {
            $select_employees = EmploymentInfo::select('employment_infos.*','employees.id','employees.employee_id as string_employee_id','employees.name')
                                ->join('employees','employees.id','employment_infos.employee_id')
                                ->where('employees.company_id',Auth::user()->company_id)
                                ->orderBy('department_id','asc')->get();

            $employment_infos = $employment_infos->get();
        }

        $excel_link = "export/pf-summary-report?from_date=".$from_date."&to_date=".$to_date."&provident_fund_id=".$selected_provident_fund_id."&show_previous_balance=".$show_previous_balance."&show_current_period=".$show_current_period."&show_closing_balance=".$show_closing_balance;

        return view('reports.pf_summary',
        compact('departments','designations','department_id','employees','from_date','select_employees','show_closing_balance',
        'all_employee','employment_infos','employee_id','designation_id','remark','to_date','show_previous_balance','show_current_period','excel_link'));
    }

    public function export_pf_summary_report(){
        return Excel::download(new PfSummaryReport(), 'PF Summary Report All.xlsx');
    }

    //Salary Sheet Report
    public function salary_sheet_report(Request $request) {
        if(roles() != "" && !in_array(151, json_decode(roles(),false))){
            return redirect('404');
        }

        $employment_infos       = EmploymentInfo::orderBy('employment_infos.department_id','asc')
                                ->select('employees.name','employees.employee_id as original_employee_id','employment_infos.*','salary_sheets.*','payroll_infos.currency_id')
                                ->join('payroll_infos','payroll_infos.employee_id','employment_infos.employee_id')
                                ->join('employees','employees.id','employment_infos.employee_id')
                                ->join('salary_sheets','salary_sheets.employee_id','employment_infos.employee_id')
                                ->where('employees.company_id',Auth::user()->company_id);

        $departments            = Department::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $designations           = Designation::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $currencies             = Currency::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();


        $department_id          = '';
        $designation_id         = '';
        $currency_id            = '';
        $month                  = '';
        $year                   = '';
        $hide_detail_btn        = '';

        if($request->date != null){
            $month              = date('F',strtotime($request->date));
            $year               = date('Y',strtotime($request->date));
            $employment_infos   = $employment_infos->where('month',$month)->where('year',$year);
        }

        if($request->department_id != ""){
            $employment_infos   = $employment_infos->where('department_id',$request->department_id);
            $department_id      = $request->department_id;
        }

        if($request->designation_id != ""){
            $employment_infos   = $employment_infos->where('designation_id',$request->designation_id);
            $designation_id     = $request->designation_id;
        }



        if($request->currency_id != ""){
            $employment_infos   = $employment_infos->where('currency_id',$request->currency_id);
            $currency_id        = $request->currency_id;
        }

        if($request->job            == "1"){
            $employment_infos   = $employment_infos->get();
        }else{
            $employment_infos       = [];
        }

        $excel_link = "export/salary-sheet-report?month=".$month."&year=".$year."&department_id=".$department_id."&designation_id=".$designation_id."&currency_id=".$currency_id;

        return view('reports.salary_sheet',compact('departments','designations','designation_id','hide_detail_btn',
        'currencies','department_id','month','currency_id','employment_infos','year','excel_link'));
    }

    public function export_salary_sheet_report(){
        return Excel::download(new SalarySheetReport(), 'Salary Sheet Report.xlsx');
    }

    //Payslip Report
    public function payslip_report(Request $request) {
        if(roles() != "" && !in_array(152, json_decode(roles(),false))){
            return redirect('404');
        }

        $employment_infos       = EmploymentInfo::orderBy('employment_infos.department_id','asc')
                                ->select('employees.name','employees.employee_id as original_employee_id','employment_infos.*','salary_sheets.*','payroll_infos.currency_id')
                                ->join('payroll_infos','payroll_infos.employee_id','employment_infos.employee_id')
                                ->join('employees','employees.id','employment_infos.employee_id')
                                ->join('salary_sheets','salary_sheets.employee_id','employment_infos.employee_id')
                                ->where('employees.company_id',Auth::user()->company_id);

        $departments            = Department::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $designations           = Designation::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $currencies             = Currency::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();


        $department_id          = '';
        $designation_id         = '';
        $currency_id            = '';
        $month                  = '';
        $year                   = '';
        $hide_detail_btn        = '';

        if($request->date != null){
            $month              = date('F',strtotime($request->date));
            $year               = date('Y',strtotime($request->date));
            $employment_infos   = $employment_infos->where('month',$month)->where('year',$year);
        }

        if($request->department_id != ""){
            $employment_infos   = $employment_infos->where('department_id',$request->department_id);
            $department_id      = $request->department_id;
        }

        if($request->designation_id != ""){
            $employment_infos   = $employment_infos->where('designation_id',$request->designation_id);
            $designation_id     = $request->designation_id;
        }



        if($request->currency_id != ""){
            $employment_infos   = $employment_infos->where('currency_id',$request->currency_id);
            $currency_id        = $request->currency_id;
        }

        if($request->job            == "1"){
            $employment_infos   = $employment_infos->get();
        }else{
            $employment_infos       = [];
        }

        return view('reports.payslip',compact('departments','designations','designation_id','hide_detail_btn',
        'currencies','department_id','month','currency_id','employment_infos','year'));
    }

    //Email Payslip Report
    public function email_payslip_report(Request $request) {
        if(roles() != "" && !in_array(153, json_decode(roles(),false))){
            return redirect('404');
        }

        $employment_infos       = EmploymentInfo::orderBy('employment_infos.department_id','asc')
                                ->select('employees.name','employees.employee_id as original_employee_id','employment_infos.*','salary_sheets.*','payroll_infos.currency_id')
                                ->join('payroll_infos','payroll_infos.employee_id','employment_infos.employee_id')
                                ->join('employees','employees.id','employment_infos.employee_id')
                                ->join('salary_sheets','salary_sheets.employee_id','employment_infos.employee_id')
                                ->where('employees.company_id',Auth::user()->company_id);

        $departments            = Department::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $designations           = Designation::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $currencies             = Currency::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();


        $department_id          = '';
        $designation_id         = '';
        $currency_id            = '';
        $month                  = '';
        $year                   = '';
        $hide_detail_btn        = '';

        if($request->date != null){
            $month              = date('F',strtotime($request->date));
            $year               = date('Y',strtotime($request->date));
            $employment_infos   = $employment_infos->where('month',$month)->where('year',$year);
        }

        if($request->department_id != ""){
            $employment_infos   = $employment_infos->where('department_id',$request->department_id);
            $department_id      = $request->department_id;
        }

        if($request->designation_id != ""){
            $employment_infos   = $employment_infos->where('designation_id',$request->designation_id);
            $designation_id     = $request->designation_id;
        }



        if($request->currency_id != ""){
            $employment_infos   = $employment_infos->where('currency_id',$request->currency_id);
            $currency_id        = $request->currency_id;
        }

        if($request->job            == "1"){
            $employment_infos   = $employment_infos->get();
        }else{
            $employment_infos       = [];
        }

        return view('reports.email_payslip',compact('departments','designations','designation_id','hide_detail_btn',
        'currencies','department_id','month','currency_id','employment_infos','year'));
    }

    // Salary Transfer Letter Report
    public function salary_transfer_letter_report(Request $request) {
        if(roles() != "" && !in_array(154, json_decode(roles(),false))){
            return redirect('404');
        }

        $currency_id            = '';
        $bank_id                = '';
        $month                  = '';
        $formatted_month        = '';
        $formatted_year         = '';

        $transfer_letters       = SalaryTransferLetter::where('company_id',Auth::user()->company_id)->orderBy('id','desc');
        $banks                  = PayrollBank::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $currencies             = Currency::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();

        if($request->currency_id != ""){
            $transfer_letters   = $transfer_letters->where('currency_id',$request->currency_id);
            $currency_id        = $request->currency_id;
        }

        if($request->bank_id != ""){
            $transfer_letters   = $transfer_letters->where('bank_id',$request->bank_id);
            $bank_id            = $request->bank_id;
        }

        if($request->month != ""){
            $formatted_month    = date('F', strtotime($request->month));
            $formatted_year     = date('Y', strtotime($request->month));
            $month              = $request->month;

            $transfer_letters   = $transfer_letters->where('month',$formatted_month);
            $transfer_letters   = $transfer_letters->where('year',$formatted_year);
        }

        $transfer_letters   = $transfer_letters->paginate(10);

        return view('reports.salary_transfer_letter',compact('transfer_letters','banks','currencies','currency_id','bank_id','month'));
    }
    
    public function salary_transfer_letter_reprint($letter_id) {
        $salary_format              = SalaryTransferLetter::where('id',$letter_id)->first();
        $employees                  = SalaryTransferLetterDetail::where('letter_id',$letter_id)->get();
        return view('reports.salary_transfer_letter_print',compact('salary_format','employees'));
    }


    ////////////////////////////////////////////
    ////////////////////////////////////////////
    ////////////////////////////////////////////
    ////////////////////////////////////////////
    ////////////////////////////////////////////
    ////////////////////////////////////////////
    ////////////////////////////////////////////
    ////////////////////////////////////////////
    ////////////////////////////////////////////
    ////////////////////////////////////////////
    ////////////////////////////////////////////
    ////////////////////////////////////////////
    ////////////////////////////////////////////
    ////////////////////////////////////////////
    ////////////////////////////////////////////
    ////////////////////////////////////////////
    ////////////////////////////////////////////
    ////////////////////////////////////////////
    ////////////////////////////////////////////
    ////////////////////////////////////////////
    ////////////////////////////////////////////
    ////////////////////////////////////////////
    ////////////////////////////////////////////
    ////////////////////////////////////////////
    ////////////////////////////////////////////
    ////////////////////////////////////////////
    ////////////////////////////////////////////
    ////////////////////////////////////////////
    ////////////////////////////////////////////
    ////////////////////////////////////////////
    ////////////////////////////////////////////
    ////////////////////////////////////////////
    ////////////////////////////////////////////
    ////////////////////////////////////////////
    ////////////////////////////////////////////
    ////////////////////////////////////////////
    ////////////////////////////////////////////
    ////////////////////////////////////////////
    ////////////////////////////////////////////
    ////////////////////////////////////////////

    //Salary Certificate
    public function salary_certificate(Request $request) {
        if(roles() != "" && !in_array(155, json_decode(roles(),false))){
            return redirect('404');
        }

        $employment_infos   = SalarySheetDetails::orderBy('salary_sheet_details.id','asc')
                            ->select('employment_infos.*','salary_sheet_details.*','employees.id','employees.employee_id as string_employee_id','employees.name')
                            ->join('employees','employees.id','salary_sheet_details.employee_id')
                            ->join('employment_infos','employment_infos.employee_id','salary_sheet_details.employee_id')
                            ->where('employees.company_id',Auth::user()->company_id)
                            ->where('component_type','!=','Deduction');

        $departments        = Department::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $designations       = Designation::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();

        $last_week      = Carbon\Carbon::now()->subWeek()->format('Y-m-d');
        $current_date   = Carbon\Carbon::now()->format('Y-m-d');

        $department_id          = '';
        $designation_id         = '';
        $employee_id            = '';
        $employees              = [];
        $select_employees       = [];
        $selected_attendance_id = '';
        $from_date              = '';
        $to_date                = '';
        $original_employee_id   = '';
        $employee_selection     = '';
        $selected_employee_id   = '';
        $deposit_taxes          = [];

        if($request->original_employee_id != ""){
            $employment_infos   = $employment_infos->where('employees.employee_id',$request->original_employee_id);
            $original_employee_id = $request->original_employee_id;
        }else{
            if($request->department_id != ""){
                $employment_infos   = $employment_infos->where('department_id',$request->department_id);
                $department_id      = $request->department_id;
            }

            if($request->designation_id != ""){
                $employment_infos   = $employment_infos->where('designation_id',$request->designation_id);
                $designation_id     = $request->designation_id;
            }


        }

        if($request->from_date != null){
            $from_date = date('Y-m-01',strtotime($request->from_date ));
        }
        if($request->to_date != null){
            $to_date = date('Y-m-t',strtotime($request->to_date ));
        }

        if($from_date != null && $to_date != null) {
            $employment_infos   = $employment_infos->whereBetween('query_date',[$from_date,$to_date]);
        }

        if($request->original_employee_id != "") {
            $employee_id = $request->original_employee_id;
        }elseif($request->employee_id != "") {
            $employee_id = $request->employee_id;
        }

        if($employee_id != "") {
            $employee_selection = Employee::where('company_id',Auth::user()->company_id)->where('employee_id',$employee_id)->first();

            $selected_employee_id = $employee_selection->id;

            $employees = $employment_infos->where('employees.employee_id',$employee_id)->groupBy('salary_sheet_details.component_id')->get();

            $deposit_taxes = DepositSalaryTax::orderBy('deposit_salary_taxes.id','asc')
                            ->select('deposit_salary_taxes.id','deposit_salary_taxes.company_id','deposit_salary_taxes.challan_no','deposit_salary_taxes.chalan_date','deposit_salary_taxes.bank_name','deposit_salary_tax_details.*')
                            ->join('deposit_salary_tax_details','deposit_salary_tax_details.tax_id','deposit_salary_taxes.id')
                            ->where('deposit_salary_taxes.company_id',Auth::user()->company_id)
                            ->where('employee_id',$selected_employee_id)
                            ->whereBetween('query_date',[$from_date,$to_date])
                            ->where('status','Approved')->get();

        }

        if($request->employee_id == "") {
            $select_employees = EmploymentInfo::select('employment_infos.*','employees.id','employees.employee_id as string_employee_id','employees.name')
                                ->join('employees','employees.id','employment_infos.employee_id')
                                ->where('employees.company_id',Auth::user()->company_id)
                                ->orderBy('department_id','asc')->get();


            $employment_infos = $employment_infos->get();
        }

        $excel_link = "export/salary-certificate?employee_id=".$selected_employee_id."&from_date=".$from_date."&to_date=".$to_date;

        return view('reports.salary_certificate',
        compact('departments','designations', 'department_id', 'employees','from_date','employee_selection','select_employees',
        'employment_infos','employee_id','designation_id','to_date','original_employee_id','deposit_taxes','excel_link'));
    }

    public function export_salary_certificate(){
        return Excel::download(new SalaryCertificate(), 'Salary Certificate.xlsx');
    }

    public function audit_trail_report(Request $request) {
        if(roles() != "" && !in_array(158, json_decode(roles(),false))){
            return redirect('404');
        }

        $audits         = Audit::select('audits.*','users.name as user_name')
                        ->join('users','users.id','audits.user_id')
                        ->orderBy('audits.created_at','desc')
                        ->where('users.company_id', Auth::user()->company_id);

        $last_week      = Carbon\Carbon::now()->subWeek()->format('Y-m-d');
        $current_date   = Carbon\Carbon::now()->format('Y-m-d');

        $from_date      = '';
        $to_date        = '';
        $changes_made   = '';

        if($request->from_date != null){
            $from_date = date('Y-m-d',strtotime($request->from_date ));
        }else{
            $from_date = date('Y-m-d',strtotime($last_week ));
        }
        if($request->to_date != null){
            $to_date = date('Y-m-d',strtotime($request->to_date ));
        }else{
            $to_date = date('Y-m-d',strtotime($current_date ));
        }

        if($request->changes_made != "") {
            $changes_made = $request->changes_made;

            if($request->changes_made == "Company") {
                $audits = $audits->where('auditable_type','App\Company');

            }elseif($request->changes_made == "Department") {
                $audits = $audits->where('auditable_type','App\Department');

            }elseif($request->changes_made == "Designation") {
                $audits = $audits->where('auditable_type','App\Designation');

            }elseif($request->changes_made == "Currency") {
                $audits = $audits->where('auditable_type','App\Currency');

            }elseif($request->changes_made == "Employee") {
                $audits = $audits->where('auditable_type','App\Employee')
                        ->orWhere('auditable_type','App\EmploymentInfo')
                        ->orWhere('auditable_type','App\EmployeeEarningDeduction')
                        ->orWhere('auditable_type','App\PayrollInfo')
                        ->orWhere('auditable_type','App\LeaveInfo');

            }elseif($request->changes_made == "User") {
                $audits = $audits->where('auditable_type','App\User');

            }elseif($request->changes_made == "Leave Type") {
                $audits = $audits->where('auditable_type','App\LeaveType');

            }elseif($request->changes_made == "Shift") {
                $audits = $audits->where('auditable_type','App\ShiftType');

            }elseif($request->changes_made == "Govt Holiday") {
                $audits = $audits->where('auditable_type','App\GovtHoliday');

            }elseif($request->changes_made == "Attendance Policy") {
                $audits = $audits->where('auditable_type','App\AttendancePolicy');

            }elseif($request->changes_made == "Salary Component") {
                $audits = $audits->where('auditable_type','App\SalaryComponent');

            }elseif($request->changes_made == "Salary Transfer Letter Format") {
                $audits = $audits->where('auditable_type','App\SalaryTransferLetterFormat');

            }elseif($request->changes_made == "OT Transfer Letter Format") {
                $audits = $audits->where('auditable_type','App\OtTransferLetterFormat');

                $audits = $audits->where('auditable_type','App\PayrollBank');

            }elseif($request->changes_made == "Leave Request") {
                $audits = $audits->where('auditable_type','App\LeaveRequest');

            }elseif($request->changes_made == "Leave Balance Transfer") {
                $audits = $audits->where('auditable_type','App\LeaveBalance');

            }elseif($request->changes_made == "Roster") {
                $audits = $audits->where('auditable_type','App\Roster')
                        ->orWhere('auditable_type','App\RosterEmployee');

            }elseif($request->changes_made == "Manual Log Entry") {
                $audits = $audits->where('auditable_type','App\Attendance');

            }elseif($request->changes_made == "Earnings Deductions Adjustment") {
                $audits = $audits->where('auditable_type','App\EarningDeductionAdjustment');

            }elseif($request->changes_made == "Absent Deduction") {
                $audits = $audits->where('auditable_type','App\AbsentDeduction');

            }elseif($request->changes_made == "Create Salary Sheet") {
                $audits = $audits->where('auditable_type','App\SalarySheet');

            }elseif($request->changes_made == "Create Salary Transfer Letter") {
                $audits = $audits->where('auditable_type','App\SalaryTransferLetter');

            }elseif($request->changes_made == "Create OT Transfer Letter") {
                $audits = $audits->where('auditable_type','App\OTTransferLetter');

            }elseif($request->changes_made == "PF") {
                $audits = $audits->where('auditable_type','App\ProvidentFund');

            }elseif($request->changes_made == "Deposit Salary Tax") {
                $audits = $audits->where('auditable_type','App\DepositSalaryTax');

            }elseif($request->changes_made == "Gratuity") {
                $audits = $audits->where('auditable_type','App\Gratuity');

            }elseif($request->changes_made == "General Settings") {
                $audits = $audits->where('auditable_type','App\GeneralSetting');

            }elseif($request->changes_made == "SMS Setting") {
                $audits = $audits->where('auditable_type','App\SmsSetting');

            }elseif($request->changes_made == "SMTP Setting") {
                $audits = $audits->where('auditable_type','App\Email');
            }
        }

        if($from_date != null && $to_date != null) {
            $datetime1 = new DateTime($request->from_date);
            $datetime2 = new DateTime($request->to_date);
            $interval = $datetime1->diff($datetime2);
            $days = $interval->format('%a');
            if($days > 30) {
                return redirect('audit-trail-report')->with('error_message','Date Range cannot greater than 1 month');
            }

            $audits = $audits->whereBetween('audits.created_at', [$from_date, $to_date.' 23:59'])->get();
        }else{
            $audits = [];
        }

        return view('reports.audit_trail',compact('from_date','to_date','audits','changes_made'));
    }
}
