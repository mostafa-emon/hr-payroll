<?php

namespace App\Http\Controllers;

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
use App\EarningAdjustment;
use App\DeductionAdjustment;
use App\SalaryComponent;
use App\AttendanceRecord;
use App\Attendance;
use App\PayrollInfo;
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
        if($request->start_time != "") {

            $count = AttendancePolicy::where('company_id',Auth::user()->company_id)->count();

            if($count == 0){ $policy = new AttendancePolicy(); } 
            else { $policy = AttendancePolicy::first(); }

            $policy->company_id             = Auth::user()->company_id;
            $policy->start_time             = $request->start_time;
            $policy->start_time_meridiem    = $request->start_time_meridiem;
            $policy->end_time               = $request->end_time;
            $policy->end_time_meridiem      = $request->end_time_meridiem;
            $policy->late_policy            = $request->late_policy;
            $policy->late_mark              = $request->late_mark;
            $policy->late_absent_policy     = $request->late_absent_policy;
            $policy->marks_absent_for       = $request->marks_absent_for;
            $policy->use_ot_round           = $request->use_ot_round;
            $policy->ot_round               = $request->ot_round;
            $policy->time_for_ot            = $request->time_for_ot;
            $policy->mark_overtime          = $request->mark_overtime;
            $policy->save();

            return redirect('attendance-policy')->with('message','Attendance Policy Updated Successfully!');
        }
        $policy = AttendancePolicy::where('company_id',Auth::user()->company_id)->first();
        return view('attendance_setup.attendance_policy',compact('policy'));
    }


    public function roster_index() {
        $rosters = Roster::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->paginate(10);
        return view('transactions.attendance.roster.index',compact('rosters'));
    }

    public function roster_create(Request $request) {
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

        if($request->department_id != ""){
            $employment_infos   = $employment_infos->where('department_id',$request->department_id);
            $department_id      = $request->department_id;

            $roster = new Roster();
            $roster->company_id     = Auth::user()->company_id;
            $roster->roster_name    = $request->roster_name;
            $roster->department_id  = $request->department_id;
            $roster->project_id     = $request->project_id;
            $roster->branch_id      = $request->branch_id;
            $roster->employee_id    = json_encode($request->employee_id);
            $roster->from_date      = date('Y-m-d',strtotime($request->from_date));
            $roster->to_date        = date('Y-m-d',strtotime($request->to_date));
            $roster->save();

            $roster_id              = $roster->id;
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
            $employee_id = $request->employee_id;
        }
        
        if($request->roster_name != "") {
            $roster_name = $request->roster_name;
        }

        $employment_infos = $employment_infos->get();

        return view('transactions.attendance.roster.add',
        compact('departments','projects','branches','department_id','branch_id','roster_name',
        'project_id','employment_infos','from_date','to_date','employee_id','shifts','roster_id'));
    }

    public function roster_store(Request $request){
        foreach(explode(',',$request->store_employee_id) as $row) {
            $all_employees = RosterEmployee::where('employee_id',get_auto_increment_employee_id($row))->whereBetween('date', [date('Y-m-d',strtotime($request->store_from_date)), date('Y-m-d',strtotime($request->store_to_date))])->count();
            if($all_employees > 0 && $all_employees !='') {
                $all_employees = RosterEmployee::where('employee_id',get_auto_increment_employee_id($row))->whereBetween('date', [date('Y-m-d',strtotime($request->store_from_date)), date('Y-m-d',strtotime($request->store_to_date))])->delete();
            }
        }

        foreach(explode(',',$request->store_employee_id) as $row) {
            $formatted_from_date = new DateTime($request->store_from_date);
            $formatted_to_date   = new DateTime($request->store_to_date);
            $interval = $formatted_to_date->diff($formatted_from_date);
            $interval = $interval->format('%a');

            for($i = 0; $i <= $interval; $i++) {
                $add_roster = new RosterEmployee();
                $add_roster->company_id     = Auth::user()->company_id;
                $add_roster->roster_id      = $request->roster_id;
                $add_roster->employee_id    = get_auto_increment_employee_id($row);
                $add_roster->date           = date('Y-m-d',strtotime($request['date_'.$i]));
                $add_roster->shift_id       = $request['shift_id_'.$i];
                if($request['day_off_'.$i] == 1) {
                    $add_roster->day_off    = 1;
                }else{ $add_roster->day_off = 0; }
                $add_roster->save();
            }
        }
        return redirect('roster')->with('message','Roster created successfully!');
    }

    public function roster_duplicate($roster_id,Request $request) {
        $roster             = Roster::where('id',$roster_id)->first();

        $employment_infos   = EmploymentInfo::orderBy('employment_infos.id','asc')->join('employees','employees.id','employment_infos.employee_id')->where('employees.company_id',Auth::user()->company_id)->get();
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
        $roster_employees = RosterEmployee::where('company_id',Auth::user()->company_id)->where('roster_id',$roster_id)->groupBy('employee_id')->select('employee_id', DB::raw('count(*) as total'))->paginate(10);
        return view('transactions.attendance.roster.employee_list',compact('roster_employees'));
    }

    public function roster_delete($roster_id){
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
    }

    public function roster_search(Request $request) {
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

        $employment_infos = $employment_infos->get();

        return view('transactions.attendance.roster.search.index',
        compact('departments','projects','branches','department_id','branch_id','roster_name','roster_employees',
        'project_id','employment_infos','from_date','to_date','employee_id','shifts','roster_id'));
    }


    public function roster_employee_delete($roster_employee_id){
        $roster = RosterEmployee::find($roster_employee_id);
        $roster->delete();
        return redirect('roster-search')->with('message','Roster Deleted Successfully!');
    }

    public function roster_employee_update(Request $request,$id) {
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
        $earnings = EarningAdjustment::where('company_id',Auth::user()->company_id)->where('year','>=',date('Y'))->orderBy('year','asc')->paginate(10);
        return view('transactions.payroll.earnings_adjustment.index',compact('earnings'));
    }

    public function earnings_adjustment_create() {
        $departments        = Department::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $projects           = Project::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $branches           = Branch::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $salary_components  = SalaryComponent::where('company_id',Auth::user()->company_id)->where('component_type','Earnings')->orderBy('id','asc')->get();
        return view('transactions.payroll.earnings_adjustment.create',compact('departments','projects','branches','salary_components'));
    }

    public function earnings_adjustment_create_post(Request $request) {
        $formatted_from_date    = date('Y-m-d',strtotime($request->from_date));
        $formatted_to_date      = date('Y-m-d',strtotime($request->to_date));
        $period                 = CarbonPeriod::create($formatted_from_date, '1 month', $formatted_to_date);

        foreach($request->employee_id as $employee_id) {
            foreach ($period as $dt) {
                $earning = new EarningAdjustment();
                $earning->company_id            = Auth::user()->company_id;
                $earning->employee_id           = $employee_id;
                $earning->salary_component_id   = $request->component_id;
                $earning->month                 = $dt->format("F");
                $earning->year                  = $dt->format("Y");
                $earning->amount                = $request->amount;
                $earning->note                  = $request->note;
                $earning->reference_no          = $request->reference_no;
                $earning->type                  = $request->type;
                $earning->status                = $request->status;
                if($request->hasFile('attach_file')){
                    $earning->attach_file   = $request->file('attach_file')->store('earning_adjustment');
                }
                $earning->save();
            }
        }
        return redirect('earnings-adjustment')->with('message','Earning Adjustment Created Successfully!');
    }

    public function earnings_adjustment_status($status,$earning_id) {
        if($status == "active") {
            $earning = EarningAdjustment::where('id',$earning_id)->first();
            $earning->status = "1";
            $earning->save();
            return redirect('earnings-adjustment')->with('message','Earning Adjustment Activated Successfully!');
        }else{
            $earning = EarningAdjustment::where('id',$earning_id)->first();
            $earning->status = "0";
            $earning->save();
            return redirect('earnings-adjustment')->with('message','Earning Adjustment Inactivated Successfully!');
        }
    }

    public function earnings_adjustment_delete($earning_id){
        $earning = EarningAdjustment::find($earning_id);
        $earning->delete();
        return redirect('earnings-adjustment')->with('message','Earning Adjustment Deleted Successfully!');
    }

    public function earnings_adjustment_update(Request $request,$earning_id){
        $earning = EarningAdjustment::where('id',$earning_id)->first();
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
        $earning    = EarningAdjustment::where('id',$earning_id)->first();
        $print      = '';
        return view('transactions.payroll.earnings_adjustment.view',compact('earning','print'));
    }

    public function earnings_adjustment_print($earning_id){
        $earning    = EarningAdjustment::where('id',$earning_id)->first();
        $print      = "Print";
        return view('transactions.payroll.earnings_adjustment.view',compact('earning','print'));
    }

    //Deduction
    public function deductions_adjustment_index() {
        $deductions = DeductionAdjustment::where('company_id',Auth::user()->company_id)->where('year','>=',date('Y'))->orderBy('year','asc')->paginate(10);
        return view('transactions.payroll.deductions_adjustment.index',compact('deductions'));
    }

    public function deductions_adjustment_create() {
        $departments        = Department::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $projects           = Project::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $branches           = Branch::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $salary_components  = SalaryComponent::where('company_id',Auth::user()->company_id)->where('component_type','Deduction')->orderBy('id','asc')->get();
        return view('transactions.payroll.deductions_adjustment.create',compact('departments','projects','branches','salary_components'));
    }

    public function deductions_adjustment_create_post(Request $request) {
        $formatted_from_date    = date('Y-m-d',strtotime($request->from_date));
        $formatted_to_date      = date('Y-m-d',strtotime($request->to_date));
        $period                 = CarbonPeriod::create($formatted_from_date, '1 month', $formatted_to_date);

        foreach($request->employee_id as $employee_id) {
            foreach ($period as $dt) {
                $deduction = new DeductionAdjustment();
                $deduction->company_id            = Auth::user()->company_id;
                $deduction->employee_id           = $employee_id;
                $deduction->salary_component_id   = $request->component_id;
                $deduction->month                 = $dt->format("F");
                $deduction->year                  = $dt->format("Y");
                $deduction->amount                = $request->amount;
                $deduction->note                  = $request->note;
                $deduction->reference_no          = $request->reference_no;
                $deduction->type                  = $request->type;
                $deduction->status                = $request->status;
                if($request->hasFile('attach_file')){
                    $deduction->attach_file   = $request->file('attach_file')->store('deduction_adjustment');
                }
                $deduction->save();
            }
        }
        return redirect('deductions-adjustment')->with('message','Deduction Adjustment Created Successfully!');
    }

    public function deductions_adjustment_delete($deduction_id) {
        $deduction = DeductionAdjustment::find($deduction_id);
        $deduction->delete();
        return redirect('deductions-adjustment')->with('message','Deduction Adjustment Deleted Successfully!');
    }

    public function deductions_adjustment_status($status,$deduction_id) {
        if($status == "active") {
            $deduction = DeductionAdjustment::where('id',$deduction_id)->first();
            $deduction->status = "1";
            $deduction->save();
            return redirect('deductions-adjustment')->with('message','Deduction Adjustment Activated Successfully!');
        }else{
            $deduction = DeductionAdjustment::where('id',$deduction_id)->first();
            $deduction->status = "0";
            $deduction->save();
            return redirect('deductions-adjustment')->with('message','Deduction Adjustment Inactivated Successfully!');
        }
    }

    public function deductions_adjustment_view($deduction_id){
        $deduction  = DeductionAdjustment::where('id',$deduction_id)->first();
        $print      = '';
        return view('transactions.payroll.deductions_adjustment.view',compact('deduction','print'));
    }

    public function deductions_adjustment_print($deduction_id){
        $deduction  = DeductionAdjustment::where('id',$deduction_id)->first();
        $print      = "Print";
        return view('transactions.payroll.deductions_adjustment.view',compact('deduction','print'));
    }

    public function deductions_adjustment_update(Request $request,$deduction_id){
        $deduction = DeductionAdjustment::where('id',$deduction_id)->first();
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

    public function manual_log_index() {
        $todays_date = date('Y-m-d');
        $attendances = Attendance::where('company_id',Auth::user()->company_id)->where('date',$todays_date)->orderBy('id','asc')->paginate(10);
        return view('transactions.attendance.manual_log_entry.index',compact('attendances'));
    }

    public function manual_log_add() {
        $employment_infos   = EmploymentInfo::orderBy('employment_infos.id','asc')->join('employees','employees.id','employment_infos.employee_id')->where('employees.company_id',Auth::user()->company_id)->get();
        $departments        = Department::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $projects           = Project::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $branches           = Branch::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();

        return view('transactions.attendance.manual_log_entry.add',compact('departments','projects','branches','employment_infos'));
    }

    public function manual_log_add_post(Request $request) {
        $employee_id    = get_auto_increment_employee_id($request->employee_id);
        $formatted_date = date('Y-m-d',strtotime($request->date));

        $policy         = AttendancePolicy::where('company_id',Auth::user()->company_id)->first();
        $payroll_info   = PayrollInfo::where('employee_id',$employee_id)->first();
        
        $attendance = Attendance::where('company_id',Auth::user()->company_id)->where('employee_id',$employee_id)->where('date',$formatted_date)->first();
        $attendance->status = "PRESENT";

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
                }

            }
        }

        // WORK IN HOLIDAY
        if($attendance->attendance_status == "GOVT_HOLIDAY" || $attendance->attendance_status == "WEEKLY_HOLIDAY" || $attendance->attendance_status == "PAID_LEAVE") {
            $attendance->work_in_holiday = 1;
        }

        $attendance->save();
        
        $in_time            = date('H:i:s',strtotime($request->in_time));
        $out_time           = date('H:i:s',strtotime($request->out_time));
        $actual_out_time    = date('H:i:s',strtotime($attendance->actual_out_time));

        $attendance->out_time = $out_time;

        // EARLY LEAVE
        if($out_time < $actual_out_time) {
            $attendance->early_leave = round(abs(strtotime($actual_out_time) - strtotime($out_time)) / 60);
        }

        // TOTAL WORKING HOUR
        $attendance->total_working_hour = round(abs(strtotime($out_time) - strtotime($in_time)) / 60);

        // NORMAL OVERTIME CALCULATION
        if($payroll_info->ot_allowed == 1) {
            $ot_considering_time = $policy->time_for_ot;

            if($out_time > $actual_out_time) {
                $today_over_time = round(abs(strtotime($out_time) - strtotime($actual_out_time)) / 60);
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
            if($policy->mark_overtime == 1) {
                if($attendance->work_in_holiday == 1) {
                    $attendance->over_time = round(abs(strtotime($out_time) - strtotime($in_time)) / 60);
                }
            }
        }
        
        $attendance->save();
        
        return redirect('manual-log-entry')->with('message','Log Manually Added Successfully!'); 
    }
}