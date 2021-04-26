<?php

namespace App\Http\Controllers;

use App\GeneralLeave;
use Illuminate\Http\Request;
use App\AttendancePolicy;
use App\EmploymentInfo;
use App\Employee;
use App\Department;
use App\Project;
use App\Branch;
use App\ShiftType;
use App\Roster;
use App\RosterEmployee;
use App\EarningDeductionAdjustment;
use App\SalaryComponent;
use App\AttendanceRecord;
use App\Attendance;
use App\PayrollInfo;
use App\GovtHolidayDetail;
use App\EmployeeEarningDeduction;
use App\TemporaryRosterSelection;
use App\PaidLeave;
use Auth;
use DateTime;
use Carbon;
use DB;
use Carbon\CarbonPeriod;

class AttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function attendance_policy(Request $request) {
        if(roles() != "" && !in_array(64, json_decode(roles(),false))){
            return redirect('404');
        }

        if($request->start_time != "") {

            $count = AttendancePolicy::where('company_id',Auth::user()->company_id)->count();

            if($count == 0){ $policy = new AttendancePolicy(); }else { $policy = AttendancePolicy::first();}

            $policy->company_id             = Auth::user()->company_id;
            $policy->start_time             = date('h:i',strtotime($request->start_time));

            $start_time_am_or_pm            = date('A',strtotime($request->start_time));
            if($start_time_am_or_pm         == "AM") {
                $policy->start_time_meridiem = 0;
            }else {
                $policy->start_time_meridiem = 1;
            }
            $policy->end_time               = date('h:i',strtotime($request->end_time));
            $end_time_am_or_pm              = date('A',strtotime($request->end_time));
            if($end_time_am_or_pm           == "AM") {
                $policy->end_time_meridiem  = 0;
            }else {
                $policy->end_time_meridiem = 1;
            }
            $policy->late_policy            = $request->late_policy;
            $policy->late_mark              = $request->late_mark;
            $policy->late_absent_policy     = $request->late_absent_policy;
            $policy->marks_absent_for       = $request->marks_absent_for;
            $policy->use_ot_round           = $request->use_ot_round;
            $policy->ot_round               = $request->ot_round;
            $policy->time_for_ot            = $request->time_for_ot;
            $policy->save();

            return redirect('attendance-policy')->with('message','Attendance Policy Updated Successfully!');
        }
        $policy = AttendancePolicy::where('company_id',Auth::user()->company_id)->first();
        if($policy !=""){
            if($policy->start_time_meridiem == 1) {
                if(date('h',strtotime($policy->start_time)) == 12) {
                    $policy->start_time = date('H:i',strtotime($policy->start_time));
                }else {
                    $policy->start_time = date('H:i',strtotime($policy->start_time . " +12 hours"));
                }

            }else {
                if(date('h',strtotime($policy->start_time)) == 12) {
                    $policy->start_time = date('H:i',strtotime($policy->start_time. " +12 hours"));
                }else {
                    $policy->start_time = date('H:i',strtotime($policy->start_time));
                }
            }

            if($policy->end_time_meridiem == 1) {
                if(date('h',strtotime($policy->start_time)) == 12) {
                    $policy->end_time = date('H:i',strtotime($policy->end_time));
                }else {
                    $policy->end_time = date('H:i',strtotime($policy->end_time . " +12 hours"));
                }

            }else {
                if(date('h',strtotime($policy->end_time)) == 12) {
                    $policy->end_time = date('H:i',strtotime($policy->end_time . " +12 hours"));
                }else {
                    $policy->end_time = date('H:i',strtotime($policy->end_time));
                }
            }
        }
        return view('attendance_setup.attendance_policy',compact('policy'));
    }


    public function roster_index() {
        if(roles() != "" && !in_array(65, json_decode(roles(),false))){
            return redirect('404');
        }

        $rosters = Roster::where('company_id',Auth::user()->company_id)->where('data_entered',1)->orderBy('id','asc')->paginate(10);
        return view('transactions.attendance.roster.index',compact('rosters'));
    }

    public function roster_create(Request $request) {
        if(roles() != "" && !in_array(66, json_decode(roles(),false))){
            return redirect('404');
        }

        $employment_infos   = EmploymentInfo::orderBy('employment_infos.id','asc')->join('employees','employees.id','employment_infos.employee_id')->where('employees.company_id',Auth::user()->company_id)->where('duty_type','Roster');
        $departments        = Department::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $projects           = Project::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $branches           = Branch::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $shifts             = ShiftType::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();

        $department_id          = '';
        $project_id             = '';
        $branch_id              = '';
        $employee_id            = [];
        $from_date              = '';
        $to_date                = '';
        $roster_name            = '';
        $roster_id              = '';
        $all_employee           = '';
        $temporary_roster_list  = '';

        if($request->department_id != ""){
            $employment_infos   = $employment_infos->where('department_id',$request->department_id);
            $department_id      = $request->department_id;
        }

        if($request->project_id != ""){
            $employment_infos   = $employment_infos->where('project_id',$request->project_id);
            $project_id         = $request->project_id;
        }

        if($request->branch_id != ""){
            $employment_infos    = $employment_infos->where('branch_id',$request->branch_id);
            $branch_id           = $request->branch_id;
        }

        if($request->from_date != "") {
            $from_date          = $request->from_date;
        }

        if($request->to_date != "") {
            $to_date            = $request->to_date;
        }

        if($request->employee_id != "") {
            if(!in_array("All", $request->employee_id)) {
                $employee_id = $request->employee_id;
                $employment_infos = $employment_infos->whereIn('employees.employee_id',$employee_id)->get();
            }else{
                $employment_infos = $employment_infos->get();

                foreach($employment_infos as $employment_info) {
                    $employee_id[]      = $employment_info->employee_id;
                }
                $all_employee = 'All';
            }

            $roster = new Roster();
            $roster->company_id     = Auth::user()->company_id;
            $roster->roster_name    = $request->roster_name;
            $roster->department_id  = $request->department_id;
            $roster->project_id     = $request->project_id;
            $roster->branch_id      = $request->branch_id;
            $roster->employee_id    = json_encode($employee_id);
            $roster->from_date      = date('Y-m-d',strtotime($request->from_date));
            $roster->to_date        = date('Y-m-d',strtotime($request->to_date));
            $roster->save();

            $roster_id              = $roster->id;
        }

        if($request->roster_name != "") {
            $roster_name = $request->roster_name;
        }

        if($request->employee_id == "" && $request->employee_id != ['All']) {
            $employment_infos = $employment_infos->get();
        }

        if($roster_id != '') {
            $temp_roster_selection  = TemporaryRosterSelection::where('user_id',Auth::user()->id)->delete();
            foreach($employment_infos as $employment_info) {
                $roster_select                      = new TemporaryRosterSelection();
                $roster_select->user_id             = Auth::user()->id;
                $roster_select->employee_id         = $employment_info->id;
                $roster_select->string_employee_id  = $employment_info->employee_id;
                $roster_select->name                = $employment_info->name;
                $roster_select->designation         = employee_designation($employment_info->id);
                $roster_select->save();
            }

            $temporary_roster_list  = TemporaryRosterSelection::where('user_id',Auth::user()->id)->get();
        }

        return view('transactions.attendance.roster.add',
        compact('departments','projects','branches','department_id','branch_id','roster_name','all_employee',
        'project_id','employment_infos','from_date','to_date','employee_id','shifts','roster_id','temporary_roster_list'));
    }

    public function roster_store(Request $request){
        $temporary_rosters = TemporaryRosterSelection::where('user_id',Auth::user()->id)->get();
        foreach($temporary_rosters as $temporary_roster) {
            $all_employees = RosterEmployee::where('employee_id',$temporary_roster->employee_id)->whereBetween('date', [date('Y-m-d',strtotime($request->store_from_date)), date('Y-m-d',strtotime($request->store_to_date))])->count();
            if($all_employees > 0 && $all_employees !='') {
                $all_employees = RosterEmployee::where('employee_id',$temporary_roster->employee_id)->whereBetween('date', [date('Y-m-d',strtotime($request->store_from_date)), date('Y-m-d',strtotime($request->store_to_date))])->delete();
            }
        }

        foreach($temporary_rosters as $temporary_roster) {
            $formatted_from_date = new DateTime($request->store_from_date);
            $formatted_to_date   = new DateTime($request->store_to_date);
            $interval = $formatted_to_date->diff($formatted_from_date);
            $interval = $interval->format('%a');

            for($i = 0; $i <= $interval; $i++) {
                $add_roster = new RosterEmployee();
                $add_roster->company_id     = Auth::user()->company_id;
                $add_roster->roster_id      = $request->roster_id;
                $add_roster->employee_id    = $temporary_roster->employee_id;
                $add_roster->date           = date('Y-m-d',strtotime($request['date_'.$i]));
                $add_roster->shift_id       = $request['shift_id_'.$i];
                if($request['day_off_'.$i] == 1) {
                    $add_roster->day_off    = 1;
                }else{ $add_roster->day_off = 0; }
                $add_roster->save();
            }
        }

        $roster = Roster::where('id',$request->roster_id)->first();
        $roster->data_entered = 1;
        $roster->save();

        return redirect('roster')->with('message','Roster created successfully!');
    }

    public function roster_duplicate($roster_id,Request $request) {
        if(roles() != "" && !in_array(66, json_decode(roles(),false))){
            return redirect('404');
        }

        $roster             = Roster::where('id',$roster_id)->first();

        $employment_infos   = EmploymentInfo::orderBy('employment_infos.id','asc')->join('employees','employees.id','employment_infos.employee_id')->where('employees.company_id',Auth::user()->company_id)->where('duty_type','Roster')->get();
        $departments        = Department::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $projects           = Project::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $branches           = Branch::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $shifts             = ShiftType::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();

        $department_id      = $roster->department_id;
        $project_id         = $roster->project_id;
        $branch_id          = $roster->branch_id;
        $employee_id        = json_decode($roster->employee_id);
        $from_date          = $roster->from_date;
        $to_date            = $roster->to_date;
        $roster_name        = $roster->roster_name;

        return view('transactions.attendance.roster.duplicate',
        compact('departments','projects','branches','department_id','branch_id','roster_name',
        'project_id','employment_infos','from_date','to_date','employee_id','shifts','roster'));
    }

    public function roster_employee_list($roster_id){
        if(roles() != "" && !in_array(65, json_decode(roles(),false))){
            return redirect('404');
        }

        $roster_employees = RosterEmployee::where('company_id',Auth::user()->company_id)->where('roster_id',$roster_id)->groupBy('employee_id')->select('employee_id', DB::raw('count(*) as total'))->paginate(10);
        return view('transactions.attendance.roster.employee_list',compact('roster_employees'));
    }

    /*public function roster_delete($roster_id){
        $roster = Roster::find($roster_id);
        if($roster->company_id == Auth::user()->company_id){
            $roster->delete();
            $current_date = Carbon\Carbon::now()->format('Y-m-d');
            $preDataCount = RosterEmployee::where('roster_id',$roster_id)->where('date','>',$current_date)->count();
            if($preDataCount != 0 && $preDataCount != "") {
                RosterEmployee::where('roster_id',$roster_id)->where('date','>',$current_date)->delete();
            }

            return redirect('roster')->with('message','Roster Deleted Successfully!');
        }else{
            return redirect('roster')->with('message','Do not try to be too smart!');
        }
    }*/

    public function roster_inactive($roster_id){
        if(roles() != "" && !in_array(68, json_decode(roles(),false))){
            return redirect('404');
        }

        $roster = Roster::where('id',$roster_id)->first();
        $roster->status = 0;
        $roster->save();

        $current_date = Carbon\Carbon::now()->format('Y-m-d');
        $preDataCount = RosterEmployee::where('roster_id',$roster_id)->where('date','>',$current_date)->count();
        if($preDataCount != 0 && $preDataCount != "") {
            RosterEmployee::where('roster_id',$roster_id)->where('date','>',$current_date)->delete();
        }

        return redirect('roster')->with('message','Roster Inactivated Successfully!');
    }

    public function roster_search(Request $request) {
        if(roles() != "" && !in_array(65, json_decode(roles(),false))){
            return redirect('404');
        }

        $employment_infos   = EmploymentInfo::orderBy('employment_infos.id','asc')->join('employees','employees.id','employment_infos.employee_id')->where('employees.company_id',Auth::user()->company_id);
        $departments        = Department::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $projects           = Project::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $branches           = Branch::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $shifts             = ShiftType::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();

        $department_id      = '';
        $project_id         = '';
        $branch_id          = '';
        $employee_id        = [];
        $from_date          = '';
        $to_date            = '';
        $roster_name        = '';
        $roster_id          = '';
        $roster_employees   = '';

        if($request->project_id != ""){
            $employment_infos   = $employment_infos->where('project_id',$request->project_id);
            $project_id         = $request->project_id;
        }

        if($request->branch_id != ""){
            $employment_infos   = $employment_infos->where('branch_id',$request->branch_id);
            $branch_id          = $request->branch_id;
        }

        if($request->from_date != "" && $request->to_date != "") {
            $from_date          = $request->from_date;
            $to_date            = $request->to_date;
            $changed_from_date  = date('Y-m-d',strtotime($request->from_date));
            $changed_to_date    = date('Y-m-d',strtotime($request->to_date));
        }

        if($request->department_id != ""){
            $employment_infos   = $employment_infos->where('department_id',$request->department_id);
            $department_id      = $request->department_id;
        }

        if($request->employee_id != "") {
            $employee_id            = $request->employee_id;
            $increment_employee_id  = get_auto_increment_employee_id($request->employee_id);
            $roster_employees   = RosterEmployee::where('company_id',Auth::user()->company_id)->where('employee_id',$increment_employee_id)
                                ->whereBetween('date', [$changed_from_date, $changed_to_date])->orderBy('date','asc')->get();
        }

        $employment_infos = $employment_infos->where('duty_type','Roster')->get();

        return view('transactions.attendance.roster.search.index',
        compact('departments','projects','branches','department_id','branch_id','roster_name','roster_employees',
        'project_id','employment_infos','from_date','to_date','employee_id','shifts','roster_id'));
    }


    public function roster_employee_delete($roster_employee_id){
        if(roles() != "" && !in_array(68, json_decode(roles(),false))){
            return redirect('404');
        }

        $roster = RosterEmployee::find($roster_employee_id);
        $roster->delete();
        return redirect('roster-search')->with('message','Roster Deleted Successfully!');
    }

    public function delete_temporary_roster($roster_id){
        $roster = TemporaryRosterSelection::find($roster_id);
        $roster->delete();
    }

    public function roster_employee_update(Request $request,$id) {
        if(roles() != "" && !in_array(67, json_decode(roles(),false))){
            return redirect('404');
        }

        $shifts     = ShiftType::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $r_employee = RosterEmployee::where('id',$id)->first();
        if($request->date != "") {
            $r_employee->shift_id       = $request->shift_id;
            $r_employee->day_off        = $request->day_off;
            $r_employee->date           = date('Y-m-d',strtotime($request->date));
            $r_employee->save();

            return redirect('roster-search')->with('message','Roster Updated Successfully!');
        }
        return view('transactions.attendance.roster.search.update',compact('shifts','r_employee'));
    }

    public function earnings_adjustment_index() {
        if(roles() != "" && !in_array(101, json_decode(roles(),false))){
            return redirect('404');
        }

        $earnings = EarningDeductionAdjustment::where('company_id',Auth::user()->company_id)->where('earning_or_deduction','earnings')->where('year','>=',date('Y'))->orderBy('year','asc')->paginate(10);
        return view('transactions.payroll.earnings_adjustment.index',compact('earnings'));
    }

    public function earnings_adjustment_create() {
        if(roles() != "" && !in_array(102, json_decode(roles(),false))){
            return redirect('404');
        }

        $departments        = Department::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $projects           = Project::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $branches           = Branch::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $salary_components  = SalaryComponent::where('company_id',Auth::user()->company_id)->where('component_type','Earnings')->orderBy('id','asc')->get();
        $employment_infos   = EmploymentInfo::orderBy('employment_infos.id','asc')->join('employees','employees.id','employment_infos.employee_id')
                            ->where('employees.company_id',Auth::user()->company_id)->get();
        $employee_id        = [];
        return view('transactions.payroll.earnings_adjustment.create',compact('departments','projects','branches','salary_components','employment_infos','employee_id'));
    }

    public function earnings_adjustment_create_post(Request $request) {
        $formatted_from_date    = date('Y-m-d',strtotime($request->from_date));
        $formatted_to_date      = date('Y-m-d',strtotime($request->to_date));
        $period                 = CarbonPeriod::create($formatted_from_date, '1 month', $formatted_to_date);

        if(in_array("All", $request->employee_id)) {

            $employees   = EmploymentInfo::orderBy('employment_infos.id','asc')
                        ->join('employees','employees.id','employment_infos.employee_id')
                        ->where('employees.company_id',Auth::user()->company_id);

            if($request->department_id != "" && $request->department_id != 0){
                $employees    = $employees->where('department_id',$request->department_id);
            }

            if($request->project_id != "" && $request->project_id != 0){
                $employees   = $employees->where('project_id',$request->project_id);
            }

            if($request->branch_id != "" && $request->branch_id != 0){
                $employees   = $employees->where('branch_id',$request->branch_id);
            }

            if($request->component_id != "" && $request->component_id != 0){
                $is_exists    = EmployeeEarningDeduction::where('salary_component_id',$request->component_id)->get();
                $earning_employee = [];
                foreach($is_exists as $earning) {
                    $earning_employee[] = $earning->employee_id;
                }
                $employees = $employees->whereIn('employees.id',$earning_employee);
            }

            $employees = $employees->get();

            foreach($employees as $employee) {
                foreach ($period as $dt) {
                    $earning = new EarningDeductionAdjustment();
                    $earning->company_id            = Auth::user()->company_id;
                    $earning->employee_id           = $employee->id;
                    $earning->salary_component_id   = $request->component_id;
                    $earning->month                 = $dt->format("F");
                    $earning->year                  = $dt->format("Y");
                    $earning->amount                = $request->amount;
                    $earning->note                  = $request->note;
                    $earning->reference_no          = $request->reference_no;
                    $earning->earning_or_deduction  = 'earnings';
                    $earning->type                  = $request->type;
                    $earning->query_date            = date('Y-m-01',strtotime($dt));
                    $earning->status                = $request->status;
                    if($request->hasFile('attach_file')){
                        $earning->attach_file   = $request->file('attach_file')->store('earning_adjustment');
                    }
                    $earning->save();
                }
            }
            return redirect('earnings-adjustment')->with('message','Earning Adjustment Created Successfully!');

        }else{
            foreach($request->employee_id as $employee_id) {
                foreach ($period as $dt) {
                    $earning = new EarningDeductionAdjustment();
                    $earning->company_id            = Auth::user()->company_id;
                    $earning->employee_id           = $employee_id;
                    $earning->salary_component_id   = $request->component_id;
                    $earning->month                 = $dt->format("F");
                    $earning->year                  = $dt->format("Y");
                    $earning->amount                = $request->amount;
                    $earning->note                  = $request->note;
                    $earning->reference_no          = $request->reference_no;
                    $earning->earning_or_deduction  = 'earnings';
                    $earning->type                  = $request->type;
                    $earning->query_date            = date('Y-m-01',strtotime($dt));
                    $earning->status                = $request->status;
                    if($request->hasFile('attach_file')){
                        $earning->attach_file   = $request->file('attach_file')->store('earning_adjustment');
                    }
                    $earning->save();
                }
            }
            return redirect('earnings-adjustment')->with('message','Earning Adjustment Created Successfully!');
        }
    }

    public function earnings_adjustment_status($status,$earning_id) {
        if(roles() != "" && !in_array(103, json_decode(roles(),false))){
            return redirect('404');
        }

        if($status == "active") {
            $earning = EarningDeductionAdjustment::where('id',$earning_id)->first();
            $earning->status = "1";
            $earning->save();
            return redirect('earnings-adjustment')->with('message','Earning Adjustment Activated Successfully!');
        }else{
            $earning = EarningDeductionAdjustment::where('id',$earning_id)->first();
            $earning->status = "0";
            $earning->save();
            return redirect('earnings-adjustment')->with('message','Earning Adjustment Inactivated Successfully!');
        }
    }

    public function earnings_adjustment_delete($earning_id){
        if(roles() != "" && !in_array(104, json_decode(roles(),false))){
            return redirect('404');
        }

        $earning = EarningDeductionAdjustment::find($earning_id);
        $earning->delete();
        return redirect('earnings-adjustment')->with('message','Earning Adjustment Deleted Successfully!');
    }

    public function earnings_adjustment_update(Request $request,$earning_id){
        if(roles() != "" && !in_array(103, json_decode(roles(),false))){
            return redirect('404');
        }

        $earning = EarningDeductionAdjustment::where('id',$earning_id)->first();
        if($request->amount) {
            $earning->month     = $request->month;
            $earning->year      = $request->year;
            $earning->amount    = $request->amount;
            $earning->type      = $request->type;
            $earning->status    = $request->status;
            $earning->save();
            return redirect('earnings-adjustment')->with('message','Earning Adjustment Updated Successfully!');
        }
        return view('transactions.payroll.earnings_adjustment.update',compact('earning'));
    }

    public function earnings_adjustment_view($earning_id){
        if(roles() != "" && !in_array(101, json_decode(roles(),false))){
            return redirect('404');
        }

        $earning    = EarningDeductionAdjustment::where('id',$earning_id)->first();
        $print      = '';
        return view('transactions.payroll.earnings_adjustment.view',compact('earning','print'));
    }

    public function earnings_adjustment_print($earning_id){
        if(roles() != "" && !in_array(105, json_decode(roles(),false))){
            return redirect('404');
        }

        $earning    = EarningDeductionAdjustment::where('id',$earning_id)->first();
        $print      = "Print";
        return view('transactions.payroll.earnings_adjustment.view',compact('earning','print'));
    }

    //Deduction
    public function deductions_adjustment_index() {
        if(roles() != "" && !in_array(106, json_decode(roles(),false))){
            return redirect('404');
        }
        $deductions = EarningDeductionAdjustment::where('company_id',Auth::user()->company_id)->where('earning_or_deduction','deductions')->where('year','>=',date('Y'))->orderBy('year','asc')->paginate(10);
        return view('transactions.payroll.deductions_adjustment.index',compact('deductions'));
    }

    public function deductions_adjustment_create() {
        if(roles() != "" && !in_array(107, json_decode(roles(),false))){
            return redirect('404');
        }

        $employee_id        = [];
        $departments        = Department::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $projects           = Project::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $branches           = Branch::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $salary_components  = SalaryComponent::where('company_id',Auth::user()->company_id)->where('component_type','Deduction')->orderBy('id','asc')->get();
        $employment_infos   = EmploymentInfo::orderBy('employment_infos.id','asc')->join('employees','employees.id','employment_infos.employee_id')
                            ->where('employees.company_id',Auth::user()->company_id)->get();
        return view('transactions.payroll.deductions_adjustment.create',compact('departments','projects','branches','salary_components','employment_infos','employee_id'));
    }

    public function deductions_adjustment_create_post(Request $request) {
        $formatted_from_date    = date('Y-m-d',strtotime($request->from_date));
        $formatted_to_date      = date('Y-m-d',strtotime($request->to_date));
        $period                 = CarbonPeriod::create($formatted_from_date, '1 month', $formatted_to_date);

        if(in_array("All", $request->employee_id)) {

            $employees   = EmploymentInfo::orderBy('employment_infos.id','asc')
                        ->join('employees','employees.id','employment_infos.employee_id')
                        ->where('employees.company_id',Auth::user()->company_id);

            if($request->department_id != "" && $request->department_id != 0){
                $employees    = $employees->where('department_id',$request->department_id);
            }

            if($request->project_id != "" && $request->project_id != 0){
                $employees   = $employees->where('project_id',$request->project_id);
            }

            if($request->branch_id != "" && $request->branch_id != 0){
                $employees   = $employees->where('branch_id',$request->branch_id);
            }

            if($request->component_id != "" && $request->component_id != 0){
                $is_exists    = EmployeeEarningDeduction::where('salary_component_id',$request->component_id)->get();
                $earning_employee = [];
                foreach($is_exists as $earning) {
                    $earning_employee[] = $earning->employee_id;
                }
                $employees = $employees->whereIn('employees.id',$earning_employee);
            }

            $employees = $employees->get();

            foreach($employees as $employee) {
                foreach ($period as $dt) {
                    $deduction = new EarningDeductionAdjustment();
                    $deduction->company_id            = Auth::user()->company_id;
                    $deduction->employee_id           = $employee->id;
                    $deduction->salary_component_id   = $request->component_id;
                    $deduction->month                 = $dt->format("F");
                    $deduction->year                  = $dt->format("Y");
                    $deduction->amount                = $request->amount;
                    $deduction->note                  = $request->note;
                    $deduction->earning_or_deduction  = 'deductions';
                    $deduction->reference_no          = $request->reference_no;
                    $deduction->type                  = $request->type;
                    $deduction->query_date            = date('Y-m-01',strtotime($dt));
                    $deduction->status                = $request->status;
                    if($request->hasFile('attach_file')){
                        $deduction->attach_file   = $request->file('attach_file')->store('deduction_adjustment');
                    }
                    $deduction->save();
                }
            }
            return redirect('deductions-adjustment')->with('message','Deduction Adjustment Created Successfully!');

        }else{
            foreach($request->employee_id as $employee_id) {
                foreach ($period as $dt) {
                    $deduction = new EarningDeductionAdjustment();
                    $deduction->company_id            = Auth::user()->company_id;
                    $deduction->employee_id           = $employee_id;
                    $deduction->salary_component_id   = $request->component_id;
                    $deduction->month                 = $dt->format("F");
                    $deduction->year                  = $dt->format("Y");
                    $deduction->amount                = $request->amount;
                    $deduction->note                  = $request->note;
                    $deduction->earning_or_deduction  = 'deductions';
                    $deduction->reference_no          = $request->reference_no;
                    $deduction->type                  = $request->type;
                    $deduction->query_date            = date('Y-m-01',strtotime($dt));
                    $deduction->status                = $request->status;
                    if($request->hasFile('attach_file')){
                        $deduction->attach_file   = $request->file('attach_file')->store('deduction_adjustment');
                    }
                    $deduction->save();
                }
            }
            return redirect('deductions-adjustment')->with('message','Deduction Adjustment Created Successfully!');
        }
    }

    public function deductions_adjustment_delete($deduction_id) {
        if(roles() != "" && !in_array(109, json_decode(roles(),false))){
            return redirect('404');
        }

        $deduction = EarningDeductionAdjustment::find($deduction_id);
        $deduction->delete();
        return redirect('deductions-adjustment')->with('message','Deduction Adjustment Deleted Successfully!');
    }

    public function deductions_adjustment_status($status,$deduction_id) {
        if(roles() != "" && !in_array(108, json_decode(roles(),false))){
            return redirect('404');
        }

        if($status == "active") {
            $deduction = EarningDeductionAdjustment::where('id',$deduction_id)->first();
            $deduction->status = "1";
            $deduction->save();
            return redirect('deductions-adjustment')->with('message','Deduction Adjustment Activated Successfully!');
        }else{
            $deduction = EarningDeductionAdjustment::where('id',$deduction_id)->first();
            $deduction->status = "0";
            $deduction->save();
            return redirect('deductions-adjustment')->with('message','Deduction Adjustment Inactivated Successfully!');
        }
    }

    public function deductions_adjustment_view($deduction_id){
        if(roles() != "" && !in_array(106, json_decode(roles(),false))){
            return redirect('404');
        }

        $deduction  = EarningDeductionAdjustment::where('id',$deduction_id)->first();
        $print      = '';
        return view('transactions.payroll.deductions_adjustment.view',compact('deduction','print'));
    }

    public function deductions_adjustment_print($deduction_id){
        if(roles() != "" && !in_array(110, json_decode(roles(),false))){
            return redirect('404');
        }

        $deduction  = EarningDeductionAdjustment::where('id',$deduction_id)->first();
        $print      = "Print";
        return view('transactions.payroll.deductions_adjustment.view',compact('deduction','print'));
    }

    public function deductions_adjustment_update(Request $request,$deduction_id){
        if(roles() != "" && !in_array(108, json_decode(roles(),false))){
            return redirect('404');
        }

        $deduction = EarningDeductionAdjustment::where('id',$deduction_id)->first();
        if($request->amount) {
            $deduction->month     = $request->month;
            $deduction->year      = $request->year;
            $deduction->amount    = $request->amount;
            $deduction->type      = $request->type;
            $deduction->status    = $request->status;
            $deduction->save();
            return redirect('deductions-adjustment')->with('message','Deduction Adjustment Updated Successfully!');
        }
        return view('transactions.payroll.deductions_adjustment.update',compact('deduction'));
    }

    public function manual_log_index(Request $request) {
        if(roles() != "" && !in_array(69, json_decode(roles(),false))){
            return redirect('404');
        }

        if($request->date != ""){
            $date         = date('Y-m-d',strtotime($request->date));
        }else {
            $date = date('Y-m-d');
        }
        $attendances = Attendance::where('company_id',Auth::user()->company_id)->where('date',$date)->where('in_time','!=',null)->orderBy('id','asc')->paginate(10);
        return view('transactions.attendance.manual_log_entry.index',compact('attendances','date'));
    }

    public function manual_log_add() {
        if(roles() != "" && !in_array(70, json_decode(roles(),false))){
            return redirect('404');
        }

        $employment_infos   = EmploymentInfo::orderBy('employment_infos.id','asc')->join('employees','employees.id','employment_infos.employee_id')->where('employees.company_id',Auth::user()->company_id)->get();
        $departments        = Department::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $projects           = Project::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $branches           = Branch::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();

        return view('transactions.attendance.manual_log_entry.add',compact('departments','projects','branches','employment_infos'));
    }

    public function manual_log_add_post(Request $request) {

        $company_id = Auth::user()->company_id;
        $attendance_policy = AttendancePolicy::where('company_id',$company_id)->first();

        $count = Attendance::where('company_id',$company_id)->where('date',date('Y-m-d',strtotime($request->date)))->count();
        if($count == 0) {
            $is_govt_holiday = GovtHolidayDetail::where('company_id',$company_id)->where('date',date('Y-m-d',strtotime($request->date)))->count();

            $employees = Employee::where('company_id',$company_id)
                            ->join('employment_infos','employees.id','employment_infos.employee_id')
                            ->get();

            foreach($employees as $employee) {
                $attendance = new Attendance();
                $attendance->company_id     = $employee->company_id;
                $attendance->employee_id    = $employee->id;
                $attendance->date           = date('Y-m-d',strtotime($request->date));

                $is_weekly_holiday = 0;

                $is_in_paid_leave = PaidLeave::where('employee_id',$employee->id)->where('date',date('Y-m-d',strtotime($request->date)))->count();
                $is_in_general_leave = GeneralLeave::where('employee_id',$employee->id)->where('date',date('Y-m-d'))->count();

                if($employee->duty_type == "Non-Roster") {
                    if(date("l") == $employee->weekend_1 || date("l") == $employee->weekend_2) {
                        $is_weekly_holiday = 1;
                    }

                    if($attendance_policy->start_time != "" && $attendance_policy->end_time != "") {
                        if($attendance_policy->start_time_meridiem == 0) {
                            $start_time_meridiem = "AM";
                        }else {
                            $start_time_meridiem = "PM";
                        }

                        if($attendance_policy->end_time_meridiem == 0) {
                            $end_time_meridiem = "AM";
                        }else {
                            $end_time_meridiem = "PM";
                        }

                        $get_actual_in_time     = date('H:i',strtotime($attendance_policy->start_time.' '.$start_time_meridiem));
                        $get_actual_out_time    = date('H:i',strtotime($attendance_policy->end_time.' '.$end_time_meridiem));
                        $total_working_hour     = round(abs(strtotime($get_actual_out_time) - strtotime($get_actual_in_time)) / 60);

                        $attendance->actual_in_time_date    = date('Y-m-d',strtotime($request->date));
                        $attendance->actual_in_time         = $get_actual_in_time;
                        $actual_in_datetime                 = $attendance->actual_in_time_date.' '.$attendance->actual_in_time;

                        $attendance->actual_out_time_date   = date("Y-m-d", strtotime($actual_in_datetime . "+".$total_working_hour." minutes"));
                        $attendance->actual_out_time        = $get_actual_out_time;
                        $attendance->roster_employee        = 0;
                    }
                }

                else {
                    $roster = RosterEmployee::where('employee_id',$employee->id)->where('date',date('Y-m-d',strtotime($request->date)))->first();
                    if($roster != "") {
                        if($roster->day_off == 1) {
                            $is_weekly_holiday = 1;
                        }

                        $shift = ShiftType::where('id',$roster->shift_id)->first();
                        if($shift != "") {
                            if($shift->start_time_meridiem == 0) {
                                $start_time_meridiem = "AM";
                            }else {
                                $start_time_meridiem = "PM";
                            }

                            if($shift->end_time_meridiem == 0) {
                                $end_time_meridiem = "AM";
                            }else {
                                $end_time_meridiem = "PM";
                            }

                            $get_actual_in_time     = date('H:i',strtotime($shift->start_time.' '.$start_time_meridiem));
                            $get_actual_out_time    = date('H:i',strtotime($shift->end_time.' '.$end_time_meridiem));
                            $total_working_hour     = round(abs(strtotime($get_actual_out_time) - strtotime($get_actual_in_time)) / 60);

                            $attendance->actual_in_time_date    = date('Y-m-d');
                            $attendance->actual_in_time         = $get_actual_in_time;
                            $actual_in_datetime                 = $attendance->actual_in_time_date.' '.$attendance->actual_in_time;

                            $attendance->actual_out_time_date   = date("Y-m-d", strtotime($actual_in_datetime . "+".$total_working_hour." minutes"));
                            $attendance->actual_out_time        = $get_actual_out_time;
                            $attendance->roster_employee        = 1;
                        }
                    }

                }

                $attendance->status = "ABSENT"; $attendance->readable_status = "Absent";
                if($is_weekly_holiday > 0) { $attendance->status = "WEEKLY_HOLIDAY"; $attendance->readable_status = "Day Off"; }
                if($is_govt_holiday > 0) { $attendance->status = "GOVT_HOLIDAY"; $attendance->readable_status = "Govt Holiday"; }
                if($is_in_paid_leave > 0) { $attendance->status = "PAID_LEAVE"; $attendance->readable_status = "Leave";}
                if($is_in_general_leave > 0) { $attendance->readable_status = "Leave";}

                $attendance->save();
            }
        }

        $employee_id    = get_auto_increment_employee_id($request->employee_id);
        $formatted_date = date('Y-m-d',strtotime($request->date));

        $policy         = AttendancePolicy::where('company_id',Auth::user()->company_id)->first();
        $payroll_info   = PayrollInfo::where('employee_id',$employee_id)->first();

        $attendance = Attendance::where('company_id',Auth::user()->company_id)->where('employee_id',$employee_id)->where('date',$formatted_date)->first();

        // WORK IN HOLIDAY
        /*if($attendance->status == "GOVT_HOLIDAY" || $attendance->status == "WEEKLY_HOLIDAY" || $attendance->status == "PAID_LEAVE") {
            $attendance->work_in_holiday = 1;
        }*/

        if($attendance->status == "GOVT_HOLIDAY") {
            $attendance->work_in_govt_holiday = 1;
        }

        if($attendance->status == "WEEKLY_HOLIDAY" || $attendance->status == "PAID_LEAVE") {
            $attendance->work_in_leave_day = 1;
        }

        /*
        if($attendance->readable_status == "Govt Holiday" || $attendance->readable_status == "Day Off" || $attendance->readable_status == "Leave") {
            $attendance->late = 0;
            $attendance->readable_status = "OK";
        }
        */

        $attendance->status = "PRESENT"; $readable_status = "OK";

        $in_time        = date('H:i:s',strtotime($request->in_time));
        $actual_in_time = date('H:i:s',strtotime($attendance->actual_in_time));

        $attendance->in_time_date = date('Y-m-d',strtotime($request->date));
        $attendance->in_time = $in_time;

        // IF LATE
        if($attendance->readable_status != "Govt Holiday" && $attendance->readable_status != "Day Off" && $attendance->readable_status != "Leave") {
            if ($in_time > $actual_in_time) {
                $late_calculation = round(abs(strtotime($in_time) - strtotime($actual_in_time)) / 60);

                // LATE ALLOWED TIME
                if ($policy->late_policy == 1) {
                    if ($late_calculation > $policy->late_mark) {
                        $attendance->late_over_allowed_time = 1;
                        $attendance->late = $late_calculation;
                        $readable_status = "Late";
                    }
                } else {
                    $attendance->late_over_allowed_time = 1;
                    $attendance->late = $late_calculation;
                    $readable_status = "Late";
                }

                // DAY ABSENT FOR LATE
                if ($policy->late_absent_policy == 1) {
                    $late_days_for_count_absent = $policy->marks_absent_for;

                    $first_day_of_month = date('Y-m-01', strtotime($formatted_date));
                    $current_date = $formatted_date;

                    $data_of_late_days_till_today = Attendance::where('employee_id', $employee_id)
                        ->whereBetween('date', [$first_day_of_month, $current_date . " 23:59:59"])
                        ->where('late_over_allowed_time', 1)
                        ->where('punishment_processed', 0)
                        ->get();
                    $late_days_till_today = count($data_of_late_days_till_today);

                    if ($late_days_till_today >= ($late_days_for_count_absent - 1)) {
                        $attendance->status = "ABSENT";
                        $attendance->day_absent_for_late = 1;
                        $attendance->punishment_processed = 1;

                        foreach ($data_of_late_days_till_today as $row) {
                            Attendance::where('id', $row->id)->update(['punishment_processed' => 1]);
                        }
                    }

                }
            }
        }

        $attendance->readable_status = $readable_status;
        $attendance->save();

        $in_time            = date('H:i:s',strtotime($request->in_time));
        $in_datetime        = date('Y-m-d H:i',strtotime($attendance->in_time_date.' '.$in_time));
        $out_time           = date('H:i:s',strtotime($request->out_time));

        $actual_out_date    = date('Y-m-d',strtotime($attendance->actual_out_time_date));
        $actual_out_time    = date('H:i:s',strtotime($attendance->actual_out_time));
        $actual_out_datetime = date('Y-m-d H:i',strtotime($actual_out_date.' '.$actual_out_time));

        if($request->out_time_logic == "same_day") {
            $out_date = date('Y-m-d',strtotime($request->date));
        }else if($request->out_time_logic == "next_day") {
            $out_date = date('Y-m-d', strtotime($request->date . ' +1 day'));
        }

        $attendance->out_time_date = $out_date;
        $attendance->out_time = $out_time;

        $out_datetime = date('Y-m-d H:i',strtotime($attendance->out_time_date.' '.$attendance->out_time));

        // EARLY LEAVE
        if($out_datetime < $actual_out_datetime) {
            $attendance->early_leave = round(abs(strtotime($actual_out_datetime) - strtotime($out_datetime)) / 60);
        }

        // TOTAL WORKING HOUR
        $attendance->total_working_hour = round(abs(strtotime($out_datetime) - strtotime($in_datetime)) / 60);

        // NORMAL OVERTIME CALCULATION
        if($payroll_info->ot_allowed == 1) {
            $ot_considering_time = $policy->time_for_ot;

            if($out_datetime > $actual_out_datetime) {
                $today_over_time = round(abs(strtotime($out_datetime) - strtotime($actual_out_datetime)) / 60);
            }else {
                $today_over_time = 0;
            }

            if($today_over_time > $ot_considering_time) {
                $is_round_slab_allowed = $policy->use_ot_round;
                if($is_round_slab_allowed == 1) {
                    $round_slab_value = $policy->ot_round;

                    if($today_over_time > 60) {
                        $extra_time = ($today_over_time % 60);
                    }else{
                        $extra_time = $today_over_time;
                    }

                    if($extra_time >= $round_slab_value) {
                        $attendance->over_time = ($today_over_time - $extra_time) + 60;
                        $attendance->over_time_round_slab = $round_slab_value;
                    }
                    else {
                        $attendance->over_time = $today_over_time;
                    }
                }
                else{
                    $attendance->over_time = $today_over_time;
                }
            }

            // OVERTIME WORK IN HOLIDAY
            /*if($payroll_info->mark_overtime == 1) {
                if($attendance->work_in_holiday == 1) {
                    $attendance->over_time = round(abs(strtotime($out_time) - strtotime($in_time)) / 60);
                }
            }*/

            if($payroll_info->mark_overtime_if_work_in_holiday == 1) {
                if($attendance->work_in_govt_holiday == 1) {
                    $attendance->over_time = $attendance->total_working_hour;
                }
            }

            if($payroll_info->mark_overtime_if_work_in_leave_day == 1) {
                if($attendance->work_in_leave_day == 1) {
                    $attendance->over_time = $attendance->total_working_hour;
                }
            }
        }

        $attendance->note = $request->note;

        $attendance->save();

        return redirect('manual-log-entry')->with('message','Log Manually Added Successfully!');
    }

    public function manual_log_update($attendance_id) {
        if(roles() != "" && !in_array(71, json_decode(roles(),false))){
            return redirect('404');
        }

        $attendance = Attendance::where('id',$attendance_id)->first();
        return view('transactions.attendance.manual_log_entry.update',compact('attendance'));
    }

    public function manual_log_update_post(Request $request,$attendance_id) {
        $attendance     = Attendance::where('id',$attendance_id)->first();
        $employee_id    = $attendance->employee_id;
        $formatted_date = date('Y-m-d',strtotime($attendance->date));

        $policy         = AttendancePolicy::where('company_id',Auth::user()->company_id)->first();
        $payroll_info   = PayrollInfo::where('employee_id',$employee_id)->first();

        // WORK IN HOLIDAY
        /*if($attendance->status == "GOVT_HOLIDAY" || $attendance->status == "WEEKLY_HOLIDAY" || $attendance->status == "PAID_LEAVE") {
            $attendance->work_in_holiday = 1;
        }else{
            $attendance->work_in_holiday = 0;
        }*/

        if($attendance->status == "GOVT_HOLIDAY") {
            $attendance->work_in_govt_holiday = 1;
        }else{
            $attendance->work_in_govt_holiday = 0;
        }

        if($attendance->status == "WEEKLY_HOLIDAY" || $attendance->status == "PAID_LEAVE") {
            $attendance->work_in_leave_day = 1;
        }else{
            $attendance->work_in_leave_day = 0;
        }

        $attendance->status                 = "PRESENT";
        //$attendance->in_time              = 0;

        /*$attendance->out_time             = 0;
        $attendance->late                   = 0;
        $attendance->over_time              = 0;
        $attendance->over_time_round_slab   = 0;
        $attendance->total_working_hour     = 0;*/

        $in_time        = date('H:i:s',strtotime($request->in_time));
        $actual_in_time = date('H:i:s',strtotime($attendance->actual_in_time));

        $attendance->in_time = $in_time;

        // IF LATE
        if($in_time > $actual_in_time) {
            $attendance->late = round(abs(strtotime($in_time) - strtotime($actual_in_time)) / 60);

            // LATE ALLOWED TIME
            if($policy->late_policy == 1) {
                if($attendance->late > $policy->late_mark) {
                    $attendance->late_over_allowed_time = 1;
                }
                else{
                    $attendance->late_over_allowed_time = 0;
                }
            }
            else {
                $attendance->late_over_allowed_time = 1;
            }

            // DAY ABSENT FOR LATE
            if($policy->late_absent_policy == 1) {
                $late_days_for_count_absent = $policy->marks_absent_for;

                $first_day_of_month = date('Y-m-01',strtotime($formatted_date));
                $current_date       = $formatted_date;

                $data_of_late_days_till_today = Attendance::where('employee_id',$employee_id)
                                    ->whereBetween('date', [$first_day_of_month, $current_date." 23:59:59"])
                                    ->where('late_over_allowed_time',1)
                                    ->where('punishment_processed',0)
                                    ->get();
                $late_days_till_today = count($data_of_late_days_till_today);

                if($late_days_till_today >= ($late_days_for_count_absent - 1)) {
                    $attendance->status = "ABSENT";
                    $attendance->day_absent_for_late    = 1;
                    $attendance->punishment_processed   = 1;

                    foreach($data_of_late_days_till_today as $row) {
                        Attendance::where('id',$row->id)->update(['punishment_processed' => 1]);
                    }
                }else{
                    $attendance->status                 = "PRESENT";
                    $attendance->day_absent_for_late    = 0;
                    $attendance->punishment_processed   = 0;

                    $data_of_late_days_before_today = Attendance::where('employee_id',$employee_id)
                                    ->whereBetween('date', [$first_day_of_month, $current_date." 23:59:59"])
                                    ->where('late_over_allowed_time',1)
                                    ->where('punishment_processed',1)
                                    ->orderBy('date','desc')
                                    ->limit($late_days_for_count_absent)
                                    ->get();

                    foreach($data_of_late_days_before_today as $row) {
                        Attendance::where('id',$row->id)->update(['punishment_processed' => 0]);
                    }
                }

            }
        }else{
            $attendance->late_over_allowed_time = 0;
            $attendance->status                 = "PRESENT";
            $attendance->day_absent_for_late    = 0;
            $attendance->punishment_processed   = 0;
            $attendance->late                   = 0;
        }

        $attendance->save();

        $in_time            = date('H:i:s',strtotime($request->in_time));
        $out_time           = date('H:i:s',strtotime($request->out_time));
        $actual_out_time    = date('H:i:s',strtotime($attendance->actual_out_time));

        $attendance->out_time = $out_time;

        // EARLY LEAVE
        if($out_time < $actual_out_time) {
            $attendance->early_leave = round(abs(strtotime($actual_out_time) - strtotime($out_time)) / 60);
        }else{
            $attendance->early_leave = 0;
        }

        // TOTAL WORKING HOUR
        $attendance->total_working_hour = round(abs(strtotime($out_time) - strtotime($in_time)) / 60);

        // NORMAL OVERTIME CALCULATION
        if($payroll_info->ot_allowed == 1) {
            $ot_considering_time = $policy->time_for_ot;

            if($out_time > $actual_out_time) {
                $today_over_time = round(abs(strtotime($out_time) - strtotime($actual_out_time)) / 60);
            }else {
                $today_over_time                    = 0;

                $attendance->over_time              = 0;
                $attendance->over_time_round_slab   = 0;
            }

            if($today_over_time > $ot_considering_time) {
                $is_round_slab_allowed = $policy->use_ot_round;
                if($is_round_slab_allowed == 1) {
                    $round_slab_value = $policy->ot_round;

                    if($today_over_time > 60) {
                        $extra_time = ($today_over_time % 60);
                    }else{
                        $extra_time = $today_over_time;
                    }

                    if($extra_time >= $round_slab_value) {
                        $attendance->over_time = ($today_over_time - $extra_time) + 60;
                        $attendance->over_time_round_slab = $round_slab_value;
                    }
                    else {
                        $attendance->over_time = $today_over_time;
                        $attendance->over_time_round_slab = 0;
                    }
                }
                else{
                    $attendance->over_time = $today_over_time;
                    $attendance->over_time_round_slab = 0;
                }
            }

            // OVERTIME WORK IN HOLIDAY
            /*if($policy->mark_overtime == 1) {
                if($attendance->work_in_holiday == 1) {
                    $attendance->over_time = round(abs(strtotime($out_time) - strtotime($in_time)) / 60);
                }
            }*/

            if($payroll_info->mark_overtime_if_work_in_holiday == 1) {
                if($attendance->work_in_govt_holiday == 1) {
                    $attendance->over_time = round(abs(strtotime($out_time) - strtotime($in_time)) / 60);
                }
            }

            if($payroll_info->mark_overtime_if_work_in_leave_day == 1) {
                if($attendance->work_in_leave_day == 1) {
                    $attendance->over_time = round(abs(strtotime($out_time) - strtotime($in_time)) / 60);
                }
            }
        }else{
            $attendance->over_time              = 0;
            $attendance->over_time_round_slab   = 0;
        }

        $attendance->note = $request->note;

        $attendance->save();

        return redirect('manual-log-entry')->with('message','Log Manually Updated Successfully!');
    }
}
