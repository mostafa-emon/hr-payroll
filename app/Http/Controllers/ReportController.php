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
use Carbon;
use App\Exports\DailyAttendanceReport;
use App\Exports\AttendanceSummaryReportAll;
use App\Exports\AttendanceSummaryReportSingle;
use App\Exports\AttendanceLateReportSingle;
use App\Exports\DailyLateReport;
use App\Exports\DailyAbsentReport;
use App\Exports\AttendanceAbsentReportSingle;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //Daily Attendance Report
    public function daily_attendance_report(Request $request) {
        $employment_infos   = Attendance::select('employment_infos.*','attendances.id as attendance_id','attendances.employee_id','attendances.date','attendances.actual_in_time','attendances.actual_out_time','attendances.roster_employee','attendances.in_time','attendances.out_time','attendances.late','attendances.over_time','attendances.total_working_hour','attendances.status','attendances.note','employees.id','employees.employee_id as string_employee_id','employees.name')
                            ->join('employees','employees.id','attendances.employee_id')
                            ->join('employment_infos','employment_infos.employee_id','attendances.employee_id')
                            ->where('employees.company_id',Auth::user()->company_id)
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
        $select_employees       = [];
        $remark                 = '';
        $selected_employee_id   = '';
        $selected_attendance_id = '';
        $date                   = date('Y-m-d');

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

        if($request->date != "") {
            $date               = date('Y-m-d',strtotime($request->date));
            $employment_infos   = $employment_infos->where('date',$date);
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
                            $general_leave = GeneralLeave::where('employee_id',$employment_info->employee_id)->where('date',$date)->first();
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
                                $general_leave = GeneralLeave::where('employee_id',$employment_info->employee_id)->where('date',$date)->first();
                                if($general_leave == "") {
                                    if($employment_info->roster_employee == 1) {
                                        $roster = RosterEmployee::where('employee_id',$employment_info->employee_id)->where('date',$date)->first();
                                        if($roster != "") {
                                            if($roster->day_off == 0) {
                                                $employee_id[] = $employment_info->string_employee_id;
                                            }
                                        }else{
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
                                $roster = RosterEmployee::where('employee_id',$employment_info->employee_id)->where('date',$date)->first();
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

                $attendance_id  = [];
                foreach($employees as $attendance) {
                    $attendance_id[] = $attendance->attendance_id;
                }   
                
                $selected_employee_id   = implode(" ",$employee_id);
                $selected_attendance_id = implode(" ",$attendance_id);

            }else{
                $employees      = $employment_infos;

                $employment_infos = $employment_infos->get();

                if($request->remark != "") {
                    if($request->remark == "Leave") {
                        $employee_id = [];
                        foreach($employment_infos as $employment_info) {
                            $general_leave = GeneralLeave::where('employee_id',$employment_info->employee_id)->where('date',$date)->first();
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
                                $general_leave = GeneralLeave::where('employee_id',$employment_info->employee_id)->where('date',$date)->first();
                                if($general_leave == "") {
                                    if($employment_info->roster_employee == 1) {
                                        $roster = RosterEmployee::where('employee_id',$employment_info->employee_id)->where('date',$date)->first();
                                        if($roster != "") {
                                            if($roster->day_off == 0) {
                                                $employee_id[] = $employment_info->string_employee_id;
                                            }
                                        }else{
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
                                $roster = RosterEmployee::where('employee_id',$employment_info->employee_id)->where('date',$date)->first();
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

                $attendance_id  = [];
                foreach($employees as $attendance) {
                    $attendance_id[] = $attendance->attendance_id;
                }   
                
                $selected_employee_id   = implode(" ",$employee_id);
                $selected_attendance_id = implode(" ",$attendance_id);
            }
        }

        if($request->employee_id == "" && $request->employee_id != ['All']) {
            $select_employees = EmploymentInfo::select('employment_infos.*','employees.id','employees.employee_id as string_employee_id','employees.name')
                                ->join('employees','employees.id','employment_infos.employee_id')
                                ->where('employees.company_id',Auth::user()->company_id)
                                ->orderBy('department_id','asc')->get();

            $employment_infos = $employment_infos->get();
        }

        $excel_link = "export/daily-attendance-report?attendance_id=".$selected_attendance_id."&remark=".$remark."&date=".$date;

        return view('reports.daily_attendance',
        compact('departments','projects','branches','designations','department_id','branch_id','employees','date',
        'all_employee','project_id','employment_infos','employee_id','designation_id','remark','excel_link','select_employees'));
    }

    public function export_daily_attendance_report(){
        return Excel::download(new DailyAttendanceReport(), 'Daily Attendance Report.xlsx');
    }

    //Attendance Summary Report Single
    public function attendance_summary_report_single(Request $request) {
        $employment_infos   = Attendance::orderBy('employment_infos.id','asc')
                            ->select('employment_infos.*','attendances.id as attendance_id','attendances.employee_id','attendances.date','attendances.actual_in_time','attendances.actual_out_time','attendances.roster_employee','attendances.in_time','attendances.out_time','attendances.late','attendances.over_time','attendances.total_working_hour','attendances.status','attendances.note','employees.id','employees.employee_id as string_employee_id','employees.name')
                            ->join('employees','employees.id','attendances.employee_id')
                            ->join('employment_infos','employment_infos.employee_id','attendances.employee_id')
                            ->where('employees.company_id',Auth::user()->company_id);

        $departments        = Department::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $designations       = Designation::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $projects           = Project::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $branches           = Branch::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();

        $last_week      = Carbon\Carbon::now()->subWeek()->format('Y-m-d');
        $current_date   = Carbon\Carbon::now()->format('Y-m-d');

        $department_id          = '';
        $designation_id         = '';
        $project_id             = '';
        $branch_id              = '';
        $employee_id            = '';
        $all_employee           = '';
        $remark                 = '';
        $employees              = [];
        $select_employees       = [];
        $remark                 = '';
        $selected_attendance_id = '';
        $from_date              = '';
        $to_date                = '';
        $original_employee_id   = '';
        $employee_selection     = '';
        $selected_employee_id   = '';

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
    
            if($request->project_id != ""){
                $employment_infos   = $employment_infos->where('project_id',$request->project_id);
                $project_id         = $request->project_id;
            }
    
            if($request->branch_id != ""){
                $employment_infos   = $employment_infos->where('branch_id',$request->branch_id);
                $branch_id          = $request->branch_id;
            }
        }

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

        if($from_date != null && $to_date != null) {
            $employment_infos   = $employment_infos->whereBetween('date',[$from_date,$to_date]);
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

        if($request->original_employee_id != "") {
            $employee_id = $request->original_employee_id;
        }elseif($request->employee_id != "") {
            $employee_id = $request->employee_id;
        }

        if($employee_id != "") {
            $employee_selection = Employee::where('company_id',Auth::user()->company_id)->where('employee_id',$employee_id)->first();

            $selected_employee_id = $employee_selection->id;

            $employees      = $employment_infos;

            $employment_infos = $employment_infos->where('employees.employee_id',$employee_id)->get();

            $attendance_id = [];
            foreach($employment_infos as $employment_info) {
                $attendance_id[] = $employment_info->attendance_id;
            }
            if($request->remark != "") {

                if($request->remark == "Leave") {
                    $attendance_id = [];
                    foreach($employment_infos as $employment_info) {
                        $general_leave = GeneralLeave::where('employee_id',$employment_info->employee_id)->where('date',$employment_info->date)->first();
                        if($general_leave != "") {
                            $attendance_id[] = $employment_info->attendance_id;
                        }elseif($employment_info->status == "PAID_LEAVE"){
                            $attendance_id[] = $employment_info->attendance_id;
                        }
                    }
                    $remark             = "Leave";

                }elseif($request->remark == "Absent") {
                    $attendance_id = [];
                    foreach($employment_infos as $employment_info) {
                        if($employment_info->status == "ABSENT") {
                            
                            $general_leave = GeneralLeave::where('employee_id',$employment_info->employee_id)->where('date',$employment_info->date)->first();
                            if($general_leave == "") {
                                if($employment_info->roster_employee == 1) {
                                    $roster = RosterEmployee::where('employee_id',$employment_info->employee_id)->where('date',$employment_info->date)->first();
                                    if($roster != "") {
                                        if($roster->day_off == 0) {
                                            $attendance_id[] = $employment_info->attendance_id;
                                        }
                                    }else{
                                        $attendance_id[] = $employment_info->attendance_id;
                                    }
                                }else{
                                    $attendance_id[] = $employment_info->attendance_id;
                                }
                            }
                        }
                    }
                    $remark             = "Absent";

                }elseif($request->remark == "Day Off") {
                    $attendance_id = [];
                    foreach($employment_infos as $employment_info) {
                        if($employment_info->roster_employee == 0) {
                            if($employment_info->status == "WEEKLY_HOLIDAY") {
                                $attendance_id[] = $employment_info->attendance_id;
                            }
                        }else{
                            $roster = RosterEmployee::where('employee_id',$employment_info->employee_id)->where('date',$employment_info->date)->first();
                            if($roster != "") {
                                if($roster->day_off == 1) {
                                    $attendance_id[] = $employment_info->attendance_id;
                                }
                            }
                        }
                    }
                    $remark             = "Day Off";
                }
            }
            $employees      = $employees->whereIn('attendances.id',$attendance_id)->get();

            $selected_attendance_id = implode(" ",$attendance_id);

        }

        if($request->employee_id == "") {
            $select_employees = EmploymentInfo::select('employment_infos.*','employees.id','employees.employee_id as string_employee_id','employees.name')
                                ->join('employees','employees.id','employment_infos.employee_id')
                                ->where('employees.company_id',Auth::user()->company_id)
                                ->orderBy('department_id','asc')->get();


            $employment_infos = $employment_infos->get();
        }

        $excel_link = "export/attendance-summary-report-single?attendance_id=".$selected_attendance_id."&employee_id="
        .$selected_employee_id."&remark=".$remark."&from_date=".$from_date."&to_date=".$to_date;

        return view('reports.attendance_summary_single',
        compact('departments','projects','branches','designations','department_id','branch_id','employees','from_date','employee_selection','select_employees',
        'all_employee','project_id','employment_infos','employee_id','designation_id','remark','to_date','original_employee_id','excel_link'));
    }

    public function export_attendance_summary_report_single(){
        return Excel::download(new AttendanceSummaryReportSingle(), 'Attendance Summary Report.xlsx');
    }

    //Attendance Summary Report All Employee
    public function attendance_summary_report_all(Request $request) {
        $employment_infos   = EmploymentInfo::select('attendances.employee_id')
                            ->join('employees','employees.id','employment_infos.employee_id')
                            ->join('attendances','attendances.employee_id','employment_infos.employee_id')
                            ->where('employees.company_id',Auth::user()->company_id)
                            ->orderBy('department_id','asc');

        $departments        = Department::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $designations       = Designation::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $projects           = Project::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $branches           = Branch::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();

        $last_week          = Carbon\Carbon::now()->subWeek()->format('Y-m-d');
        $current_date       = Carbon\Carbon::now()->format('Y-m-d');

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
        $from_date              = '';
        $to_date                = '';

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

        if($request->employee_id != "") {
            $employment_infos   = $employment_infos->whereBetween('date',[$from_date,$to_date]);
        }

        if($request->employee_id != "") {
            $employees = $employment_infos->groupBy('attendances.employee_id')->get();
        }

        $excel_link = "export/attendance-summary-report-all?department_id=".$department_id."&project_id=".$project_id."&branch_id=".$branch_id.
        "&designation_id=".$designation_id."&from_date=".$from_date."&to_date=".$to_date."&employee_id=".$request->employee_id;

        return view('reports.attendance_summary_all',
        compact('departments','projects','branches','designations','department_id','branch_id','employees','from_date',
        'all_employee','project_id','employment_infos','employee_id','designation_id','excel_link','remark','to_date'));
    }

    public function export_attendance_summary_report_all(){
        return Excel::download(new AttendanceSummaryReportAll(), 'Attendance Summary Report.xlsx');
    }

    public function attendance_late_report_single(Request $request) {
        $employment_infos   = Attendance::orderBy('employment_infos.id','asc')
                            ->select('employment_infos.*','attendances.id as attendance_id','attendances.employee_id','attendances.date','attendances.actual_in_time','attendances.actual_out_time','attendances.roster_employee','attendances.in_time','attendances.out_time','attendances.late','attendances.over_time','attendances.total_working_hour','attendances.status','attendances.note','employees.id','employees.employee_id as string_employee_id','employees.name')
                            ->join('employees','employees.id','attendances.employee_id')
                            ->join('employment_infos','employment_infos.employee_id','attendances.employee_id')
                            ->where('employees.company_id',Auth::user()->company_id)
                            ->where('status','PRESENT')->where('late','>',0);

        $departments        = Department::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $designations       = Designation::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $projects           = Project::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $branches           = Branch::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();

        $last_week          = Carbon\Carbon::now()->subWeek()->format('Y-m-d');
        $current_date       = Carbon\Carbon::now()->format('Y-m-d');

        $department_id          = '';
        $designation_id         = '';
        $project_id             = '';
        $branch_id              = '';
        $employee_id            = '';
        $all_employee           = '';
        $remark                 = '';
        $employees              = [];
        $select_employees       = [];
        $remark                 = '';
        $selected_attendance_id = '';
        $from_date              = '';
        $to_date                = '';
        $original_employee_id   = '';
        $employee_selection     = '';
        $selected_employee_id   = '';

        if($request->original_employee_id != ""){
            $employment_infos       = $employment_infos->where('employees.employee_id',$request->original_employee_id);
            $original_employee_id   = $request->original_employee_id;
        }else{
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
        }

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

        if($from_date != null && $to_date != null) {
            $employment_infos   = $employment_infos->whereBetween('date',[$from_date,$to_date]);
        }

        if($request->original_employee_id != "") {
            $employee_id = $request->original_employee_id;
        }elseif($request->employee_id != "") {
            $employee_id = $request->employee_id;
        }

        if($employee_id != "") {
            $employee_selection = Employee::where('company_id',Auth::user()->company_id)->where('employee_id',$employee_id)->first();

            $selected_employee_id = $employee_selection->id;

            $employees      = $employment_infos;

            $employment_infos = $employment_infos->where('employees.employee_id',$employee_id)->get();

            $attendance_id = [];
            foreach($employment_infos as $employment_info) {
                $attendance_id[] = $employment_info->attendance_id;
            }
            $employees      = $employees->whereIn('attendances.id',$attendance_id)->get();

            $selected_attendance_id = implode(" ",$attendance_id);

        }

        if($request->employee_id == "") {
            $select_employees = EmploymentInfo::select('employment_infos.*','employees.id','employees.employee_id as string_employee_id','employees.name')
                                ->join('employees','employees.id','employment_infos.employee_id')
                                ->where('employees.company_id',Auth::user()->company_id)
                                ->orderBy('department_id','asc')->get();


            $employment_infos = $employment_infos->get();
        }

        $excel_link = "export/attendance-late-report-single?attendance_id=".$selected_attendance_id."&employee_id="
        .$selected_employee_id."&remark=".$remark."&from_date=".$from_date."&to_date=".$to_date;

        return view('reports.attendance_late_single',
        compact('departments','projects','branches','designations','department_id','branch_id','employees','from_date','employee_selection','select_employees',
        'all_employee','project_id','employment_infos','employee_id','designation_id','remark','to_date','original_employee_id','excel_link'));
    }

    public function export_attendance_late_report_single(){
        return Excel::download(new AttendanceLateReportSingle(), 'Late Report-Individual.xlsx');
    }

    public function daily_late_report(Request $request) {
        $employment_infos   = Attendance::select('employment_infos.*','attendances.id as attendance_id','attendances.employee_id','attendances.date','attendances.actual_in_time','attendances.actual_out_time','attendances.roster_employee','attendances.in_time','attendances.out_time','attendances.late','attendances.over_time','attendances.total_working_hour','attendances.status','attendances.note','employees.id','employees.employee_id as string_employee_id','employees.name')
                            ->join('employees','employees.id','attendances.employee_id')
                            ->join('employment_infos','employment_infos.employee_id','attendances.employee_id')
                            ->where('employees.company_id',Auth::user()->company_id)
                            ->orderBy('department_id','asc')
                            ->where('status','PRESENT')->where('late','>',0);

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
        $select_employees       = [];
        $remark                 = '';
        $selected_employee_id   = '';
        $selected_attendance_id = '';
        $date                   = date('Y-m-d');

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

        if($request->date != "") {
            $date               = date('Y-m-d',strtotime($request->date));
            $employment_infos   = $employment_infos->where('date',$date);
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
                $employees      = $employees->whereIn('employees.employee_id',$employee_id)->get();

                $attendance_id  = [];
                foreach($employees as $attendance) {
                    $attendance_id[] = $attendance->attendance_id;
                }   
                
                $selected_employee_id   = implode(" ",$employee_id);
                $selected_attendance_id = implode(" ",$attendance_id);

            }else{
                $employees      = $employment_infos;

                $employment_infos = $employment_infos->get();

                foreach($employment_infos as $employment_info) {
                    $employee_id[]      = $employment_info->string_employee_id;
                }
                
                $all_employee = 'All';

                $employees      = $employees->whereIn('employees.employee_id',$employee_id)->get();

                $attendance_id  = [];
                foreach($employees as $attendance) {
                    $attendance_id[] = $attendance->attendance_id;
                }   
                
                $selected_employee_id   = implode(" ",$employee_id);
                $selected_attendance_id = implode(" ",$attendance_id);
            }
        }

        if($request->employee_id == "" && $request->employee_id != ['All']) {
            $select_employees = EmploymentInfo::select('employment_infos.*','employees.id','employees.employee_id as string_employee_id','employees.name')
                                ->join('employees','employees.id','employment_infos.employee_id')
                                ->where('employees.company_id',Auth::user()->company_id)
                                ->orderBy('department_id','asc')->get();

            $employment_infos = $employment_infos->get();
        }

        $excel_link = "export/daily-late-report?attendance_id=".$selected_attendance_id."&remark=".$remark."&date=".$date;

        return view('reports.daily_late',
        compact('departments','projects','branches','designations','department_id','branch_id','employees','date',
        'all_employee','project_id','employment_infos','employee_id','designation_id','remark','excel_link','select_employees'));
    }

    public function export_daily_late_report(){
        return Excel::download(new DailyLateReport(), 'Daily Late Report.xlsx');
    }

    public function daily_absent_report(Request $request) {
        $employment_infos   = Attendance::select('employment_infos.*','attendances.id as attendance_id','attendances.employee_id','attendances.date','attendances.actual_in_time','attendances.actual_out_time','attendances.roster_employee','attendances.in_time','attendances.out_time','attendances.late','attendances.over_time','attendances.total_working_hour','attendances.status','attendances.note','employees.id','employees.employee_id as string_employee_id','employees.name')
                            ->join('employees','employees.id','attendances.employee_id')
                            ->join('employment_infos','employment_infos.employee_id','attendances.employee_id')
                            ->where('employees.company_id',Auth::user()->company_id)
                            ->where('status','ABSENT')
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
        $select_employees       = [];
        $remark                 = '';
        $selected_employee_id   = '';
        $selected_attendance_id = '';
        $date                   = date('Y-m-d');

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

        if($request->date != "") {
            $date               = date('Y-m-d',strtotime($request->date));
            $employment_infos   = $employment_infos->where('date',$date);
        }

        if($request->employee_id != "") {
            if(!in_array("All", $request->employee_id)) {
                $employee_id = $request->employee_id;

                $employees      = $employment_infos;

                $employment_infos = $employment_infos->whereIn('employees.employee_id',$employee_id)->get();

                $employee_id = [];
                foreach($employment_infos as $employment_info) {
                    if($employment_info->status == "ABSENT") {
                        $general_leave = GeneralLeave::where('employee_id',$employment_info->employee_id)->where('date',$date)->first();
                        if($general_leave == "") {
                            if($employment_info->roster_employee == 1) {
                                $roster = RosterEmployee::where('employee_id',$employment_info->employee_id)->where('date',$date)->first();
                                if($roster != "") {
                                    if($roster->day_off == 0) {
                                        $employee_id[] = $employment_info->string_employee_id;
                                    }
                                }else{
                                    $employee_id[] = $employment_info->string_employee_id;
                                }
                            }else{
                                $employee_id[] = $employment_info->string_employee_id;
                            }
                        }
                    }
                }

                $employees      = $employees->whereIn('employees.employee_id',$employee_id)->get();

                $attendance_id  = [];
                foreach($employees as $attendance) {
                    $attendance_id[] = $attendance->attendance_id;
                }   
                
                $selected_employee_id   = implode(" ",$employee_id);
                $selected_attendance_id = implode(" ",$attendance_id);

            }else{
                $employees      = $employment_infos;

                $employment_infos = $employment_infos->get();

                $employee_id = [];
                foreach($employment_infos as $employment_info) {
                    if($employment_info->status == "ABSENT") {
                        $general_leave = GeneralLeave::where('employee_id',$employment_info->employee_id)->where('date',$date)->first();
                        if($general_leave == "") {
                            if($employment_info->roster_employee == 1) {
                                $roster = RosterEmployee::where('employee_id',$employment_info->employee_id)->where('date',$date)->first();
                                if($roster != "") {
                                    if($roster->day_off == 0) {
                                        $employee_id[] = $employment_info->string_employee_id;
                                    }
                                }else{
                                    $employee_id[] = $employment_info->string_employee_id;
                                }
                            }else{
                                $employee_id[] = $employment_info->string_employee_id;
                            }
                        }
                    }
                }
                $all_employee = 'All';

                $employees      = $employees->whereIn('employees.employee_id',$employee_id)->get();

                $attendance_id  = [];
                foreach($employees as $attendance) {
                    $attendance_id[] = $attendance->attendance_id;
                }
                
                $selected_employee_id   = implode(" ",$employee_id);
                $selected_attendance_id = implode(" ",$attendance_id);

            }
        }

        if($request->employee_id == "" && $request->employee_id != ['All']) {
            $select_employees = EmploymentInfo::select('employment_infos.*','employees.id','employees.employee_id as string_employee_id','employees.name')
                                ->join('employees','employees.id','employment_infos.employee_id')
                                ->where('employees.company_id',Auth::user()->company_id)
                                ->orderBy('department_id','asc')->get();

            $employment_infos = $employment_infos->get();
        }

        $excel_link = "export/daily-absent-report?attendance_id=".$selected_attendance_id."&remark=".$remark."&date=".$date;

        return view('reports.daily_absent',
        compact('departments','projects','branches','designations','department_id','branch_id','employees','date',
        'all_employee','project_id','employment_infos','employee_id','designation_id','remark','excel_link','select_employees'));
    }

    public function export_daily_absent_report(){
        return Excel::download(new DailyAbsentReport(), 'Daily Absent Report.xlsx');
    }

    public function attendance_absent_report_single(Request $request) {
        $employment_infos   = Attendance::orderBy('employment_infos.id','asc')
                            ->select('employment_infos.*','attendances.id as attendance_id','attendances.employee_id','attendances.date','attendances.actual_in_time','attendances.actual_out_time','attendances.roster_employee','attendances.in_time','attendances.out_time','attendances.late','attendances.over_time','attendances.total_working_hour','attendances.status','attendances.note','employees.id','employees.employee_id as string_employee_id','employees.name')
                            ->join('employees','employees.id','attendances.employee_id')
                            ->join('employment_infos','employment_infos.employee_id','attendances.employee_id')
                            ->where('employees.company_id',Auth::user()->company_id)
                            ->where('status','ABSENT');

        $departments        = Department::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $designations       = Designation::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $projects           = Project::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $branches           = Branch::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();

        $last_week      = Carbon\Carbon::now()->subWeek()->format('Y-m-d');
        $current_date   = Carbon\Carbon::now()->format('Y-m-d');

        $department_id          = '';
        $designation_id         = '';
        $project_id             = '';
        $branch_id              = '';
        $employee_id            = '';
        $all_employee           = '';
        $remark                 = '';
        $employees              = [];
        $select_employees       = [];
        $remark                 = '';
        $selected_attendance_id = '';
        $from_date              = '';
        $to_date                = '';
        $original_employee_id   = '';
        $employee_selection     = '';
        $selected_employee_id   = '';

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

            if($request->project_id != ""){
                $employment_infos   = $employment_infos->where('project_id',$request->project_id);
                $project_id         = $request->project_id;
            }

            if($request->branch_id != ""){
                $employment_infos   = $employment_infos->where('branch_id',$request->branch_id);
                $branch_id          = $request->branch_id;
            }
        }

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

        if($from_date != null && $to_date != null) {
            $employment_infos   = $employment_infos->whereBetween('date',[$from_date,$to_date]);
        }

        if($request->original_employee_id != "") {
            $employee_id = $request->original_employee_id;
        }elseif($request->employee_id != "") {
            $employee_id = $request->employee_id;
        }

        if($employee_id != "") {
            $employee_selection = Employee::where('company_id',Auth::user()->company_id)->where('employee_id',$employee_id)->first();

            $selected_employee_id = $employee_selection->id;

            $employees      = $employment_infos;

            $employment_infos = $employment_infos->where('employees.employee_id',$employee_id)->get();

            $attendance_id = [];
            foreach($employment_infos as $employment_info) {
                $attendance_id[] = $employment_info->attendance_id;
            }

                $attendance_id = [];
                foreach($employment_infos as $employment_info) {
                    if($employment_info->status == "ABSENT") {
                        
                        $general_leave = GeneralLeave::where('employee_id',$employment_info->employee_id)->where('date',$employment_info->date)->first();
                        if($general_leave == "") {
                            if($employment_info->roster_employee == 1) {
                                $roster = RosterEmployee::where('employee_id',$employment_info->employee_id)->where('date',$employment_info->date)->first();
                                if($roster != "") {
                                    if($roster->day_off == 0) {
                                        $attendance_id[] = $employment_info->attendance_id;
                                    }
                                }else{
                                    $attendance_id[] = $employment_info->attendance_id;
                                }
                            }else{
                                $attendance_id[] = $employment_info->attendance_id;
                            }
                        }
                    }
                }

            $employees      = $employees->whereIn('attendances.id',$attendance_id)->get();

            $selected_attendance_id = implode(" ",$attendance_id);

        }

        if($request->employee_id == "") {
            $select_employees = EmploymentInfo::select('employment_infos.*','employees.id','employees.employee_id as string_employee_id','employees.name')
                                ->join('employees','employees.id','employment_infos.employee_id')
                                ->where('employees.company_id',Auth::user()->company_id)
                                ->orderBy('department_id','asc')->get();


            $employment_infos = $employment_infos->get();
        }

        $excel_link = "export/attendance-absent-report-single?attendance_id=".$selected_attendance_id."&employee_id="
        .$selected_employee_id."&remark=".$remark."&from_date=".$from_date."&to_date=".$to_date;

        return view('reports.attendance_absent_single',
        compact('departments','projects','branches','designations','department_id','branch_id','employees','from_date','employee_selection','select_employees',
        'all_employee','project_id','employment_infos','employee_id','designation_id','remark','to_date','original_employee_id','excel_link'));
    }

    public function export_attendance_absent_report_single(){
        return Excel::download(new AttendanceAbsentReportSingle(), 'Absent Report Single.xlsx');
    }


            


    


    

//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////
}
