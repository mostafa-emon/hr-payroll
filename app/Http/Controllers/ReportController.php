<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EmploymentInfo;
use App\Employee;
use App\Department;
use App\Designation;
use App\Project;
use App\Branch;
use App\Attendance;
use App\GeneralLeave;
use App\RosterEmployee;
use Auth;
use Excel;
use App\Exports\DailyAttendanceReport;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function daily_attendance_report(Request $request) {
        $employment_infos   = EmploymentInfo::orderBy('employment_infos.id','asc')
                            ->select('employment_infos.*','attendances.*','employees.id','employees.employee_id as string_employee_id','employees.name')
                            ->join('employees','employees.id','employment_infos.employee_id')
                            ->join('attendances','attendances.employee_id','employment_infos.employee_id')
                            ->where('employees.company_id',Auth::user()->company_id)
                            ->where('date',date('Y-m-d'))
                            ->orderBy('department_id','asc');

        $departments        = Department::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $designations       = Designation::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $projects           = Project::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $branches           = Branch::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();

        $department_id          = '';
        $designation_id         = '';
        $project_id             = '';
        $branch_id              = '';
        $employee_id            = [];
        $all_employee           = '';
        $remark                 = '';
        $employees              = [];
        $remark                 = '';
        $selected_employee_id   = '';

        if($request->department_id != ""){
            $employment_infos   = $employment_infos->where('department_id',$request->department_id);
            $department_id      = $request->department_id;
        }

        if($request->designation_id != ""){
            $employment_infos   = $employment_infos->where('designation_id',$request->designation_id);
            $designation_id     = $request->designation_id;
        }

        if($request->project_id != ""){
            $employment_infos   = $employment_infos->where('project_id',$request->project_id);
            $project_id         = $request->project_id;
        }

        if($request->branch_id != ""){
            $employment_infos   = $employment_infos->where('branch_id',$request->branch_id);
            $branch_id          = $request->branch_id;
        }

        if($request->remark != "") {
            $remark             = $request->remark;
            if($request->remark == "OK") {
                $employment_infos   = $employment_infos->where('status','PRESENT')->where('late',0);
                $remark             = "OK";
            }
            elseif($request->remark == "Late") {
                $employment_infos   = $employment_infos->where('status','PRESENT')->where('late','>',0);
                $remark             = "Late";
            }
            elseif($request->remark == "Govt Holiday") {
                $employment_infos   = $employment_infos->where('status','GOVT_HOLIDAY');
                $remark             = "Govt Holiday";
            }
        }

        if($request->employee_id != "") {
            if(!in_array("All", $request->employee_id)) {
                $employee_id = $request->employee_id;

                $employees      = $employment_infos;

                $employment_infos = $employment_infos->whereIn('employees.employee_id',$employee_id)->get();
                if($request->remark != "") {

                    if($request->remark == "Leave") {
                        $employee_id = [];
                        foreach($employment_infos as $employment_info) {
                            $general_leave = GeneralLeave::where('employee_id',$employment_info->employee_id)->where('date',date('Y-m-d'))->first();
                            if($general_leave != "") {
                                $employee_id[] = $employment_info->string_employee_id;
                            }elseif($employment_info->status == "PAID_LEAVE"){
                                $employee_id[] = $employment_info->string_employee_id;
                            }
                        }
                        $remark             = "Leave";

                    }elseif($request->remark == "Absent") {
                        $employee_id = [];
                        foreach($employment_infos as $employment_info) {
                            if($employment_info->status == "ABSENT") {
                                if($employment_info->roster_employee == 0) {
                                    $general_leave = GeneralLeave::where('employee_id',$employment_info->employee_id)->where('date',date('Y-m-d'))->first();
                                    if($general_leave == "") {
                                        $employee_id[] = $employment_info->string_employee_id;
                                    }
                                }else{
                                    $roster = RosterEmployee::where('employee_id',$employment_info->employee_id)->where('date',date('Y-m-d'))->first();
                                    if($roster != "") {
                                        if($roster->day_off == 0) {
                                            $employee_id[] = $employment_info->string_employee_id;
                                        }
                                    }else{
                                        $employee_id[] = $employment_info->string_employee_id;
                                    }
                                }
                            }
                        }
                        $remark             = "Absent";

                    }elseif($request->remark == "Day Off") {
                        $employee_id = [];
                        foreach($employment_infos as $employment_info) {
                            if($employment_info->roster_employee == 0) {
                                if($employment_info->status == "WEEKLY_HOLIDAY") {
                                    $employee_id[] = $employment_info->string_employee_id;
                                }
                            }else{
                                $roster = RosterEmployee::where('employee_id',$employment_info->employee_id)->where('date',date('Y-m-d'))->first();
                                if($roster != "") {
                                    if($roster->day_off == 1) {
                                        $employee_id[] = $employment_info->string_employee_id;
                                    }
                                }
                            }
                        }
                        $remark             = "Day Off";
                    }
                }
                $employees      = $employees->whereIn('employees.employee_id',$employee_id)->get();

                $selected_employee_id = implode(" ",$employee_id);

            }else{
                $employees      = $employment_infos;

                $employment_infos = $employment_infos->get();

                if($request->remark != "") {
                    if($request->remark == "Leave") {
                        $employee_id = [];
                        foreach($employment_infos as $employment_info) {
                            $general_leave = GeneralLeave::where('employee_id',$employment_info->employee_id)->where('date',date('Y-m-d'))->first();
                            if($general_leave != "") {
                                $employee_id[] = $employment_info->string_employee_id;
                            }elseif($employment_info->status == "PAID_LEAVE"){
                                $employee_id[] = $employment_info->string_employee_id;
                            }
                        }
                        $remark             = "Leave";

                    }elseif($request->remark == "Absent") {
                        $employee_id = [];
                        foreach($employment_infos as $employment_info) {
                            if($employment_info->status == "ABSENT") {
                                if($employment_info->roster_employee == 0) {
                                    $general_leave = GeneralLeave::where('employee_id',$employment_info->employee_id)->where('date',date('Y-m-d'))->first();
                                    if($general_leave == "") {
                                        $employee_id[] = $employment_info->string_employee_id;
                                    }
                                }else{
                                    $roster = RosterEmployee::where('employee_id',$employment_info->employee_id)->where('date',date('Y-m-d'))->first();
                                    if($roster != "") {
                                        if($roster->day_off == 0) {
                                            $employee_id[] = $employment_info->string_employee_id;
                                        }
                                    }else{
                                        $employee_id[] = $employment_info->string_employee_id;
                                    }
                                }
                            }
                        }
                        $remark             = "Absent";

                    }elseif($request->remark == "Day Off") {
                        $employee_id = [];
                        foreach($employment_infos as $employment_info) {
                            if($employment_info->roster_employee == 0) {
                                if($employment_info->status == "WEEKLY_HOLIDAY") {
                                    $employee_id[] = $employment_info->string_employee_id;
                                }
                            }else{
                                $roster = RosterEmployee::where('employee_id',$employment_info->employee_id)->where('date',date('Y-m-d'))->first();
                                if($roster != "") {
                                    if($roster->day_off == 1) {
                                        $employee_id[] = $employment_info->string_employee_id;
                                    }
                                }
                            }
                        }
                        $remark             = "Day Off";

                    }else{
                        foreach($employment_infos as $employment_info) {
                            $employee_id[]      = $employment_info->string_employee_id;
                        }
                    }
                }else{
                    foreach($employment_infos as $employment_info) {
                        $employee_id[]      = $employment_info->string_employee_id;
                    }
                }
                $all_employee = 'All';

                $employees      = $employees->whereIn('employees.employee_id',$employee_id)->get();
                
                $selected_employee_id = implode(" ",$employee_id);
            }
        }

        if($request->employee_id == "" && $request->employee_id != ['All']) {
            $employment_infos = $employment_infos->get();
        }

        $excel_link = "export/daily-attendance-report?employee_id=".$selected_employee_id."&remark=".$remark;

        return view('reports.daily_attendance',
        compact('departments','projects','branches','designations','department_id','branch_id','employees',
        'all_employee','project_id','employment_infos','employee_id','designation_id','remark','excel_link'));
    }

    public function export_daily_attendance_report(){
        return Excel::download(new DailyAttendanceReport(), 'Daily Attendance Report.xlsx');
    }
}
