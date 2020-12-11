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
use Auth;
use DateTime;

class AttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $policies = AttendancePolicy::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->paginate(10);
        return view('attendance_setup.attendance_policy.index',compact('policies'));
    }

    public function add(Request $request) {
        if($request->start_time != "") {
            $policy = new AttendancePolicy;
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
            $policy->clear_log_data         = $request->clear_log_data;
            $policy->save();
            return redirect('attendance-policy')->with('message','Attendance Policy Added Successfully!');
        }
        return view('attendance_setup.attendance_policy.add');
    }

    public function update(Request $request,$id) {
        $policy = AttendancePolicy::where('id',$id)->first();
        if($policy->company_id == Auth::user()->company_id) {
            if($request->start_time != "") {
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
                $policy->clear_log_data         = $request->clear_log_data;
                $policy->save();
                return redirect('attendance-policy')->with('message','Attendance Policy Updated Successfully!');
            }
            return view('attendance_setup.attendance_policy.update',compact('policy'));
        }else{
            return redirect('attendance-policy')->with('message','Do not try to be too smart!');
        }
    }

    public function delete($id) {
        $policy = AttendancePolicy::find($id);
        if($policy->company_id == Auth::user()->company_id){
            $policy->delete();
            return redirect('attendance-policy')->with('message','Attendance Policy Deleted Successfully!');
        }else{
            return redirect('attendance-policy')->with('message','Do not try to be too smart!');
        }
    }

    public function roster_create(Request $request) {
        $employment_infos   = EmploymentInfo::orderBy('employment_infos.id','asc')->join('employees','employees.id','employment_infos.employee_id');
        $departments        = Department::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $projects           = Project::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $branches           = Branch::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $shifts             = ShiftType::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();

        $department_id      = '';
        $project_id         = '';
        $branch_id          = '';
        $employee_id        = [];
        $applicable_for     = '';
        $from_date          = '';
        $to_date            = '';

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
            $employee_id = $request->employee_id;
        }

        $employment_infos = $employment_infos->get();

        return view('transactions.attendance.roster',
        compact('departments','projects','branches','department_id','branch_id',
        'project_id','employment_infos','from_date','to_date','employee_id','shifts'));
    }

    public function roster_store(Request $request){
        foreach(explode(',',$request->store_employee_id) as $row) {
            $formatted_from_date = new DateTime($request->store_from_date);
            $formatted_to_date   = new DateTime($request->store_to_date);
            $interval = $formatted_to_date->diff($formatted_from_date);
            $interval = $interval->format('%a');

            for($i = 0; $i <= $interval; $i++) {
                $roster = new Roster();
                $roster->employee_id    = get_auto_increment_employee_id($row);
                $roster->date           = date('Y-m-d',strtotime($request['date_'.$i]));
                $roster->shift_id       = $request['shift_id_'.$i];
                if($request['day_off_'.$i] == 1) {
                    $roster->day_off    = 1;
                }else{ $roster->day_off = 0; }
                $roster->save();
            }
        }
        return redirect('create-roster')->with('message','Roster created successfully!');
    }
}
