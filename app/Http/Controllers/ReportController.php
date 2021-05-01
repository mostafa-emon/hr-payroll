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
use App\LeaveRequest;
use App\SalaryComponent;
use App\LeaveType;
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
use App\Exports\DailyAttendanceReport;
use App\Exports\AttendanceSummaryReportAll;
use App\Exports\AttendanceSummaryReportSingle;
use App\Exports\AttendanceLateReportSingle;
use App\Exports\DailyLateReport;
use App\Exports\DailyAbsentReport;
use App\Exports\AttendanceAbsentReportSingle;
use App\Exports\OTSummaryReport;
use App\Exports\OTReportSingle;
use App\Exports\EmployeeListReport;
use App\Exports\InactiveEmployeeListReport;
use App\Exports\LeaveReportSingle;
use App\Exports\RejectedLeaveReport;
use App\Exports\LeaveReportAll;
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

    //Daily Attendance Report
    public function daily_attendance_report(Request $request) {
        if(roles() != "" && !in_array(73, json_decode(roles(),false))){
            return redirect('404');
        }

        $employment_infos   = Attendance::select('employment_infos.*','attendances.id as attendance_id','attendances.employee_id','attendances.date','attendances.actual_in_time','attendances.actual_out_time','attendances.roster_employee','attendances.in_time','attendances.out_time','attendances.late','attendances.over_time','attendances.total_working_hour','attendances.status','attendances.readable_status','attendances.note','employees.id','employees.employee_id as string_employee_id','employees.name')
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
                $employment_infos   = $employment_infos->where('readable_status','OK');
                $remark             = "OK";
            }
            elseif($request->remark == "Late") {
                $employment_infos   = $employment_infos->where('readable_status','Late');
                $remark             = "Late";
            }
            elseif($request->remark == "Govt Holiday") {
                $employment_infos   = $employment_infos->where('readable_status','Govt Holiday');
                $remark             = "Govt Holiday";
            }
            elseif($request->remark == "Leave") {
                $employment_infos   = $employment_infos->where('readable_status','Leave');
                $remark             = "Leave";
            }
            elseif($request->remark == "Absent") {
                $employment_infos   = $employment_infos->where('readable_status','Absent');
                $remark             = "Absent";
            }
            elseif($request->remark == "Day Off") {
                $employment_infos   = $employment_infos->where('readable_status','Day Off');
                $remark             = "Day Off";
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
        if(roles() != "" && !in_array(75, json_decode(roles(),false))){
            return redirect('404');
        }

        $employment_infos   = Attendance::orderBy('employment_infos.id','asc')
                            ->select('employment_infos.*','attendances.id as attendance_id','attendances.employee_id','attendances.date','attendances.actual_in_time','attendances.actual_out_time','attendances.roster_employee','attendances.in_time','attendances.out_time','attendances.late','attendances.over_time','attendances.total_working_hour','attendances.status','attendances.readable_status','attendances.note','employees.id','employees.employee_id as string_employee_id','employees.name')
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
                $employment_infos   = $employment_infos->where('readable_status','OK');
                $remark             = "OK";
            }
            elseif($request->remark == "Late") {
                $employment_infos   = $employment_infos->where('readable_status','Late');
                $remark             = "Late";
            }
            elseif($request->remark == "Govt Holiday") {
                $employment_infos   = $employment_infos->where('readable_status','Govt Holiday');
                $remark             = "Govt Holiday";
            }
            elseif($request->remark == "Leave") {
                $employment_infos   = $employment_infos->where('readable_status','Leave');
                $remark             = "Leave";
            }
            elseif($request->remark == "Absent") {
                $employment_infos   = $employment_infos->where('readable_status','Absent');
                $remark             = "Absent";
            }
            elseif($request->remark == "Day Off") {
                $employment_infos   = $employment_infos->where('readable_status','Day Off');
                $remark             = "Day Off";
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
        if(roles() != "" && !in_array(74, json_decode(roles(),false))){
            return redirect('404');
        }

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

    //Late Report Individual
    public function attendance_late_report_single(Request $request) {
        if(roles() != "" && !in_array(77, json_decode(roles(),false))){
            return redirect('404');
        }

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

    //Daily Late Report
    public function daily_late_report(Request $request) {
        if(roles() != "" && !in_array(76, json_decode(roles(),false))){
            return redirect('404');
        }

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
                $employment_infos   = $employment_infos->where('readable_status','OK');
                $remark             = "OK";
            }
            elseif($request->remark == "Late") {
                $employment_infos   = $employment_infos->where('readable_status','Late');
                $remark             = "Late";
            }
            elseif($request->remark == "Govt Holiday") {
                $employment_infos   = $employment_infos->where('readable_status','Govt Holiday');
                $remark             = "Govt Holiday";
            }
            elseif($request->remark == "Leave") {
                $employment_infos   = $employment_infos->where('readable_status','Leave');
                $remark             = "Leave";
            }
            elseif($request->remark == "Absent") {
                $employment_infos   = $employment_infos->where('readable_status','Absent');
                $remark             = "Absent";
            }
            elseif($request->remark == "Day Off") {
                $employment_infos   = $employment_infos->where('readable_status','Day Off');
                $remark             = "Day Off";
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

    //Daily Absent Report
    public function daily_absent_report(Request $request) {
        if(roles() != "" && !in_array(78, json_decode(roles(),false))){
            return redirect('404');
        }

        $employment_infos   = Attendance::select('employment_infos.*','attendances.id as attendance_id','attendances.employee_id','attendances.date','attendances.actual_in_time','attendances.actual_out_time','attendances.roster_employee','attendances.in_time','attendances.out_time','attendances.late','attendances.over_time','attendances.total_working_hour','attendances.status','attendances.readable_status','attendances.note','employees.id','employees.employee_id as string_employee_id','employees.name')
                            ->join('employees','employees.id','attendances.employee_id')
                            ->join('employment_infos','employment_infos.employee_id','attendances.employee_id')
                            ->where('employees.company_id',Auth::user()->company_id)
                            ->where('readable_status','Absent')
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
                    $employee_id[] = $employment_info->string_employee_id;
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
                    $employee_id[] = $employment_info->string_employee_id;
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

    //Absent Report Single
    public function attendance_absent_report_single(Request $request) {
        if(roles() != "" && !in_array(79, json_decode(roles(),false))){
            return redirect('404');
        }

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

    //OT Summary Report
    public function ot_summary_report(Request $request) {
        if(roles() != "" && !in_array(80, json_decode(roles(),false))){
            return redirect('404');
        }

        $employment_infos   = EmploymentInfo::select('attendances.id as attendance_id','attendances.employee_id','attendances.date','attendances.actual_in_time','attendances.actual_out_time','attendances.roster_employee','attendances.in_time','attendances.out_time','attendances.late','attendances.over_time','attendances.total_working_hour','attendances.status','attendances.note','employment_infos.*','employees.id','employees.employee_id as string_employee_id','employees.name')
                            ->join('employees','employees.id','employment_infos.employee_id')
                            ->join('attendances','attendances.employee_id','employment_infos.employee_id')
                            ->where('employees.company_id',Auth::user()->company_id)
                            ->where('over_time','>',0)
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
        $select_employees       = [];
        $selected_attendance_id = '';

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
            if(!in_array("All", $request->employee_id)) {
                $employee_id    = $request->employee_id;

                $employment_infos = $employment_infos->whereIn('employees.employee_id',$employee_id)->get();

                $attendance_id  = [];
                foreach($employment_infos as $attendance) {
                    $attendance_id[] = $attendance->attendance_id;
                }
                
                $selected_attendance_id = implode(" ",$attendance_id);

            }else{
                $employees      = $employment_infos;

                $employment_infos = $employment_infos->get();

                $attendance_id  = [];
                foreach($employment_infos as $attendance) {
                    $attendance_id[] = $attendance->attendance_id;
                }

                $all_employee = 'All';
                
                $selected_attendance_id = implode(" ",$attendance_id);
            }


            $employees = Attendance::whereIn('id',$attendance_id)->select('employee_id',DB::raw('SUM(over_time) as over_time'))->groupBy('employee_id')->get();
        }

        if($request->employee_id == "" && $request->employee_id != ['All']) {
            $select_employees = EmploymentInfo::select('employment_infos.*','employees.id','employees.employee_id as string_employee_id','employees.name')
                                ->join('employees','employees.id','employment_infos.employee_id')
                                ->where('employees.company_id',Auth::user()->company_id)
                                ->orderBy('department_id','asc')->get();

            $employment_infos = $employment_infos->get();
        }

        $excel_link = "export/ot-summary-report?from_date=".$from_date."&to_date=".$to_date."&attendance_id=".$selected_attendance_id;

        return view('reports.ot_summary',
        compact('departments','projects','branches','designations','department_id','branch_id','employees','from_date','select_employees',
        'all_employee','project_id','employment_infos','employee_id','designation_id','excel_link','remark','to_date'));
    }

    public function export_ot_summary_report(){
        return Excel::download(new OTSummaryReport(), 'OT Summary Report.xlsx');
    }

    //OT Report Individual
    public function ot_report_single(Request $request) {
        if(roles() != "" && !in_array(81, json_decode(roles(),false))){
            return redirect('404');
        }

        $employment_infos   = Attendance::orderBy('employment_infos.id','asc')
                            ->select('employment_infos.*','attendances.id as attendance_id','attendances.employee_id','attendances.date','attendances.actual_in_time','attendances.actual_out_time','attendances.roster_employee','attendances.in_time','attendances.out_time','attendances.late','attendances.over_time','attendances.total_working_hour','attendances.status','attendances.note','attendances.work_in_leave_day','attendances.work_in_govt_holiday','employees.id','employees.employee_id as string_employee_id','employees.name')
                            ->join('employees','employees.id','attendances.employee_id')
                            ->join('employment_infos','employment_infos.employee_id','attendances.employee_id')
                            ->where('employees.company_id',Auth::user()->company_id)
                            ->where('over_time','>',0);

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

            if($request->remark != "") {

                if($request->remark == "Leave") {
                    $attendance_id = [];
                    foreach($employment_infos as $employment_info) {
                        $general_leave = GeneralLeave::where('employee_id',$employment_info->employee_id)->where('date',$employment_info->date)->first();
                        if($general_leave != "") {
                            $attendance_id[] = $employment_info->attendance_id;
                        }elseif($employment_info->status == "PAID_LEAVE"){
                            $attendance_id[] = $employment_info->attendance_id;
                        }elseif($employment_info->work_in_leave_day == 1){
                            $attendance_id[] = $employment_info->attendance_id;
                        }
                    }
                    $remark             = "Leave";

                }elseif($request->remark == "Absent") {
                    $attendance_id = [];
                    foreach($employment_infos as $employment_info) {
                        if($employment_info->status == "ABSENT") {
                            $day_name = date('l',strtotime($employment_info->date));
                            if($employment_info->weekend_1 != $day_name && $employment_info->weekend_2 != $day_name) {
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
                    }
                    $remark             = "Absent";

                }elseif($request->remark == "Day Off") {
                    $attendance_id = [];
                    foreach($employment_infos as $employment_info) {
                        if($employment_info->roster_employee == 0) {
                            $day_name = date('l',strtotime($employment_info->date));
                            if($employment_info->status == "WEEKLY_HOLIDAY" || $employment_info->weekend_1 == $day_name || $employment_info->weekend_2 == $day_name) {
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

                }elseif($request->remark == "Govt Holiday") {
                    $attendance_id = [];
                    foreach($employment_infos as $employment_info) {
                        if($employment_info->status == 'GOVT_HOLIDAY') {
                            $attendance_id[] = $employment_info->attendance_id;
                        }elseif($employment_info->work_in_govt_holiday == 1){
                            $attendance_id[] = $employment_info->attendance_id;
                        }
                    }
                    $remark             = "Govt Holiday";

                }elseif($request->remark == "OK") {
                    $attendance_id = [];
                    foreach($employment_infos as $employment_info) {
                        $day_name = date('l',strtotime($employment_info->date));
                        if($employment_info->weekend_1 != $day_name && $employment_info->weekend_2 != $day_name) {
                            $general_leave = GeneralLeave::where('employee_id',$employment_info->employee_id)->where('date',$employment_info->date)->first();
                            if($general_leave == "") {
                                if($employment_info->work_in_govt_holiday != 1) {
                                    if($employment_info->work_in_leave_day != 1) {
                                        if($employment_info->roster_employee == 1) {
                                            $roster = RosterEmployee::where('employee_id',$employment_info->employee_id)->where('date',$employment_info->date)->first();
                                            if($roster != "") {
                                                if($roster->day_off == 0) {
                                                    if($employment_info->status == 'PRESENT' && $employment_info->late == 0) {
                                                        $attendance_id[] = $employment_info->attendance_id;
                                                    }
                                                }
                                            }else{
                                                if($employment_info->status == 'PRESENT' && $employment_info->late == 0) {
                                                    $attendance_id[] = $employment_info->attendance_id;
                                                }
                                            }
                                        }else{
                                            if($employment_info->status == 'PRESENT' && $employment_info->late == 0) {
                                                $attendance_id[] = $employment_info->attendance_id;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $remark             = "OK";

                }elseif($request->remark == "Late") {
                    $attendance_id = [];
                    foreach($employment_infos as $employment_info) {
                        $day_name = date('l',strtotime($employment_info->date));
                        if($employment_info->weekend_1 != $day_name && $employment_info->weekend_2 != $day_name) {
                            $general_leave = GeneralLeave::where('employee_id',$employment_info->employee_id)->where('date',$employment_info->date)->first();
                            if($general_leave == "") {
                                if($employment_info->work_in_govt_holiday != 1) {
                                    if($employment_info->work_in_leave_day != 1) {
                                        if($employment_info->roster_employee == 1) {
                                            $roster = RosterEmployee::where('employee_id',$employment_info->employee_id)->where('date',$employment_info->date)->first();
                                            if($roster != "") {
                                                if($roster->day_off == 0) {
                                                    if($employment_info->status == 'PRESENT' && $employment_info->late > 0) {
                                                        $attendance_id[] = $employment_info->attendance_id;
                                                    }
                                                }
                                            }else{
                                                if($employment_info->status == 'PRESENT' && $employment_info->late > 0) {
                                                    $attendance_id[] = $employment_info->attendance_id;
                                                }
                                            }
                                        }else{
                                            if($employment_info->status == 'PRESENT' && $employment_info->late > 0) {
                                                $attendance_id[] = $employment_info->attendance_id;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $remark             = "Late";
                }
            }else{
                $attendance_id = [];
                foreach($employment_infos as $employment_info) {
                    $attendance_id[] = $employment_info->attendance_id;
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

        $excel_link = "export/ot-report-single?attendance_id=".$selected_attendance_id."&employee_id="
        .$selected_employee_id."&remark=".$remark."&from_date=".$from_date."&to_date=".$to_date;

        return view('reports.ot_single',
        compact('departments','projects','branches','designations','department_id','branch_id','employees','from_date','employee_selection','select_employees',
        'all_employee','project_id','employment_infos','employee_id','designation_id','remark','to_date','original_employee_id','excel_link'));
    }

    public function export_ot_report_single(){
        return Excel::download(new OTReportSingle(), 'OT Report Individual.xlsx');
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
        $projects               = Project::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $branches               = Branch::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();

        $department_id          = '';
        $designation_id         = '';
        $project_id             = '';
        $branch_id              = '';
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

            if($request->project_id != ""){
                $employment_infos   = $employment_infos->where('project_id',$request->project_id);
                $project_id         = $request->project_id;
            }

            if($request->branch_id != ""){
                $employment_infos   = $employment_infos->where('branch_id',$request->branch_id);
                $branch_id          = $request->branch_id;
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

        $excel_link = "export/employee-list-report?department_id=".$department_id."&designation_id=".$designation_id."&project_id=".$project_id.
        "&branch_id=".$branch_id."&religion=".$religion."&gender=".$gender."&blood_group=".$blood_group."&duty_type=".$duty_type.
        "&original_employee_id=".$original_employee_id;

        return view('reports.employee_list',
        compact('departments','projects','branches','designations','department_id','branch_id','project_id','designation_id',
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
        $projects               = Project::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $branches               = Branch::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();

        $department_id          = '';
        $designation_id         = '';
        $project_id             = '';
        $branch_id              = '';
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

            if($request->project_id != ""){
                $employment_infos   = $employment_infos->where('project_id',$request->project_id);
                $project_id         = $request->project_id;
            }

            if($request->branch_id != ""){
                $employment_infos   = $employment_infos->where('branch_id',$request->branch_id);
                $branch_id          = $request->branch_id;
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

        $excel_link = "export/inactive-employee-list-report?department_id=".$department_id."&designation_id=".$designation_id."&project_id=".$project_id.
        "&branch_id=".$branch_id."&religion=".$religion."&gender=".$gender."&blood_group=".$blood_group."&duty_type=".$duty_type.
        "&original_employee_id=".$original_employee_id;

        return view('reports.inactive_employee_list',
        compact('departments','projects','branches','designations','department_id','branch_id','project_id','designation_id',
        'religion','gender','blood_group','duty_type','employees','original_employee_id','excel_link'));
    }

    public function export_inactive_employee_list_report(){
        return Excel::download(new InactiveEmployeeListReport(), 'Inactive Employee List.xlsx');
    }
    
    public function leave_report_single(Request $request) {
        if(roles() != "" && !in_array(165, json_decode(roles(),false))){
            return redirect('404');
        }
        $employment_infos   = LeaveRequest::select('employment_infos.*','leave_requests.*','employees.id','employees.employee_id as string_employee_id','employees.name')
                            ->join('employees','employees.id','leave_requests.employee_id')
                            ->join('employment_infos','employment_infos.employee_id','leave_requests.employee_id')
                            ->where('employees.company_id',Auth::user()->company_id)
                            ->where('leave_requests.status','Approved')
                            ->orderBy('leave_requests.id','asc');

        $departments        = Department::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $designations       = Designation::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $leave_types        = LeaveType::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();

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
            $employment_infos   = $employment_infos->whereBetween('start_date',[$from_date,$to_date]);
            $employment_infos   = $employment_infos->whereBetween('end_date',[$from_date,$to_date]);
        }

        if($request->original_employee_id != "") {
            $employee_id = $request->original_employee_id;
        }elseif($request->employee_id != "") {
            $employee_id = $request->employee_id;
        }

        if($employee_id != "") {
            $employee_selection     = Employee::where('company_id',Auth::user()->company_id)->where('employee_id',$employee_id)->first();
            $selected_employee_id   = $employee_selection->id;

            $employees              = $employment_infos->where('leave_requests.employee_id',$employee_selection->id)->get();
        }

        if($request->employee_id == "") {
            $select_employees = EmploymentInfo::select('employment_infos.*','employees.id','employees.employee_id as string_employee_id','employees.name')
                                ->join('employees','employees.id','employment_infos.employee_id')
                                ->where('employees.company_id',Auth::user()->company_id)
                                ->orderBy('department_id','asc')->get();


            $employment_infos = $employment_infos->get();
        }

        $excel_link = "export/leave-report-single?from_date=".$from_date."&to_date=".$to_date."&employee_id=".$selected_employee_id;

        return view('reports.leave_single',
        compact('departments','designations','department_id','employees','from_date','select_employees','leave_types',
        'employment_infos','employee_id','designation_id','to_date','original_employee_id','employee_selection','excel_link'));
    }

    public function export_leave_report_single(){
        return Excel::download(new LeaveReportSingle(), 'Leave Report Individual.xlsx');
    }
    
    public function rejected_leave_report(Request $request) {
        if(roles() != "" && !in_array(166, json_decode(roles(),false))){
            return redirect('404');
        }

        $employment_infos   = LeaveRequest::select('employment_infos.*','leave_requests.*','employees.id','employees.employee_id as string_employee_id','employees.name')
                            ->join('employees','employees.id','leave_requests.employee_id')
                            ->join('employment_infos','employment_infos.employee_id','leave_requests.employee_id')
                            ->where('employees.company_id',Auth::user()->company_id)
                            ->where('leave_requests.status','Rejected')
                            ->orderBy('leave_requests.id','asc');

        $departments        = Department::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $designations       = Designation::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $leave_types        = LeaveType::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();

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
            $employment_infos   = $employment_infos->whereBetween('start_date',[$from_date,$to_date]);
            $employment_infos   = $employment_infos->whereBetween('end_date',[$from_date,$to_date]);
        }

        if($request->original_employee_id != "") {
            $employee_id = $request->original_employee_id;
        }elseif($request->employee_id != "") {
            $employee_id = $request->employee_id;
        }

        if($employee_id != "") {
            $employee_selection     = Employee::where('company_id',Auth::user()->company_id)->where('employee_id',$employee_id)->first();
            $selected_employee_id   = $employee_selection->id;

            $employees              = $employment_infos->where('leave_requests.employee_id',$employee_selection->id)->get();
        }

        if($request->employee_id == "") {
            $select_employees = EmploymentInfo::select('employment_infos.*','employees.id','employees.employee_id as string_employee_id','employees.name')
                                ->join('employees','employees.id','employment_infos.employee_id')
                                ->where('employees.company_id',Auth::user()->company_id)
                                ->orderBy('department_id','asc')->get();


            $employment_infos = $employment_infos->get();
        }

        $excel_link = "export/rejected-leave-report?from_date=".$from_date."&to_date=".$to_date."&employee_id=".$selected_employee_id;

        return view('reports.rejected_leave',
        compact('departments','designations','department_id','employees','from_date','select_employees','leave_types',
        'employment_infos','employee_id','designation_id','to_date','original_employee_id','employee_selection','excel_link'));
    }

    public function export_rejected_leave_report(){
        return Excel::download(new RejectedLeaveReport(), 'Rejected Leave Report.xlsx');
    }

    public function leave_report_all(Request $request) {
        if(roles() != "" && !in_array(167, json_decode(roles(),false))){
            return redirect('404');
        }

        $employment_infos   = LeaveRequest::select('employment_infos.*','leave_requests.*','employees.id','employees.employee_id as string_employee_id','employees.name')
                            ->join('employees','employees.id','leave_requests.employee_id')
                            ->join('employment_infos','employment_infos.employee_id','leave_requests.employee_id')
                            ->where('employees.company_id',Auth::user()->company_id)
                            ->where('leave_requests.status','Approved')
                            ->orderBy('department_id','asc');

        $departments        = Department::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $designations       = Designation::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $projects           = Project::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $branches           = Branch::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $leave_types        = LeaveType::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();

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
        $project_id             = '';
        $branch_id              = '';
        $gender                 = '';
        $duty_type              = '';

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

        if($request->gender != ""){
            $employment_infos   = $employment_infos->where('gender',$request->gender);
            $gender             = $request->gender;
        }

        if($request->duty_type != ""){
            $employment_infos   = $employment_infos->where('duty_type',$request->duty_type);
            $duty_type          = $request->duty_type;
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
            $employment_infos   = $employment_infos->whereBetween('start_date',[$from_date,$to_date]);
            $employment_infos   = $employment_infos->whereBetween('end_date',[$from_date,$to_date]);
        }

        if($request->job            == "1"){
            $employees              = $employment_infos->groupBy('leave_requests.employee_id')->get();
        }

        if($request->employee_id == "") {
            $select_employees = EmploymentInfo::select('employment_infos.*','employees.id','employees.employee_id as string_employee_id','employees.name')
                                ->join('employees','employees.id','employment_infos.employee_id')
                                ->where('employees.company_id',Auth::user()->company_id)
                                ->orderBy('department_id','asc')->get();


            $employment_infos = $employment_infos->get();
        }

        $excel_link = "export/leave-report-all?department_id=".$department_id."&designation_id=".$designation_id."&project_id=".$project_id.
        "&branch_id=".$branch_id."&gender=".$gender."&duty_type=".$duty_type."&from_date=".$from_date."&to_date=".$to_date;

        return view('reports.leave_all',
        compact('departments','designations','department_id','employees','from_date','select_employees','leave_types','projects','branches',
        'employment_infos','employee_id','designation_id','to_date','original_employee_id','employee_selection','project_id','branch_id','excel_link'));
    }

    public function export_leave_report_all(){
        return Excel::download(new LeaveReportAll(), 'Leave Report All.xlsx');
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
        $projects           = Project::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $branches           = Branch::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $salary_components  = SalaryComponent::where('company_id',Auth::user()->company_id)->where('component_type','Earnings')->orderBy('id','asc')->get();

        $department_id      = '';
        $designation_id     = '';
        $project_id         = '';
        $branch_id          = '';
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

        if($request->project_id != ""){
            $employment_infos   = $employment_infos->where('project_id',$request->project_id);
            $project_id         = $request->project_id;
        }

        if($request->branch_id != ""){
            $employment_infos   = $employment_infos->where('branch_id',$request->branch_id);
            $branch_id          = $request->branch_id;
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

        $excel_link = "export/earning-adjustment-report?department_id=".$department_id."&designation_id=".$designation_id."&project_id="
        .$project_id."&branch_id=".$branch_id."&component_id=".$component_id."&employee_id=".$employee_id."&from_date=".$from_date.
        "&to_date=".$to_date;

        return view('reports.earning_adjustment',
        compact('departments','projects','branches','designations','department_id','branch_id','employees','from_date','select_employees',
        'project_id','employment_infos','employee_id','designation_id','to_date','salary_components','period','excel_link'));
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
        $projects           = Project::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $branches           = Branch::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $salary_components  = SalaryComponent::where('company_id',Auth::user()->company_id)->where('component_type','Deduction')->orderBy('id','asc')->get();

        $department_id      = '';
        $designation_id     = '';
        $project_id         = '';
        $branch_id          = '';
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

        if($request->project_id != ""){
            $employment_infos   = $employment_infos->where('project_id',$request->project_id);
            $project_id         = $request->project_id;
        }

        if($request->branch_id != ""){
            $employment_infos   = $employment_infos->where('branch_id',$request->branch_id);
            $branch_id          = $request->branch_id;
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

        $excel_link = "export/deduction-adjustment-report?department_id=".$department_id."&designation_id=".$designation_id."&project_id="
        .$project_id."&branch_id=".$branch_id."&component_id=".$component_id."&employee_id=".$employee_id."&from_date=".$from_date.
        "&to_date=".$to_date;

        return view('reports.deduction_adjustment',
        compact('departments','projects','branches','designations','department_id','branch_id','employees','from_date','select_employees',
        'project_id','employment_infos','employee_id','designation_id','to_date','salary_components','period','excel_link'));
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

        if($request->project_id != ""){
            $employment_infos   = $employment_infos->where('project_id',$request->project_id);
            $project_id         = $request->project_id;
        }

        if($request->branch_id != ""){
            $employment_infos   = $employment_infos->where('branch_id',$request->branch_id);
            $branch_id          = $request->branch_id;
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
        compact('departments','projects','branches','designations','department_id','branch_id','employees','from_date','select_employees','show_closing_balance',
        'all_employee','project_id','employment_infos','employee_id','designation_id','remark','to_date','show_previous_balance','show_current_period','excel_link'));
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
        $projects               = Project::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $branches               = Branch::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $currencies             = Currency::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();


        $department_id          = '';
        $designation_id         = '';
        $project_id             = '';
        $branch_id              = '';
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

        if($request->job            == "1"){
            $employment_infos   = $employment_infos->get();
        }else{
            $employment_infos       = [];
        }

        $excel_link = "export/salary-sheet-report?month=".$month."&year=".$year."&department_id=".$department_id."&designation_id=".$designation_id."&project_id="
        .$project_id."&branch_id=".$branch_id."&currency_id=".$currency_id;

        return view('reports.salary_sheet',compact('departments','projects','branches','designations','designation_id','hide_detail_btn',
        'currencies','department_id','project_id','branch_id','month','currency_id','employment_infos','year','excel_link'));
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
        $projects               = Project::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $branches               = Branch::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $currencies             = Currency::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();


        $department_id          = '';
        $designation_id         = '';
        $project_id             = '';
        $branch_id              = '';
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

        if($request->job            == "1"){
            $employment_infos   = $employment_infos->get();
        }else{
            $employment_infos       = [];
        }

        return view('reports.payslip',compact('departments','projects','branches','designations','designation_id','hide_detail_btn',
        'currencies','department_id','project_id','branch_id','month','currency_id','employment_infos','year'));
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
        $projects               = Project::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $branches               = Branch::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $currencies             = Currency::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();


        $department_id          = '';
        $designation_id         = '';
        $project_id             = '';
        $branch_id              = '';
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

        if($request->job            == "1"){
            $employment_infos   = $employment_infos->get();
        }else{
            $employment_infos       = [];
        }

        return view('reports.email_payslip',compact('departments','projects','branches','designations','designation_id','hide_detail_btn',
        'currencies','department_id','project_id','branch_id','month','currency_id','employment_infos','year'));
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
        $projects           = Project::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $branches           = Branch::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();

        $last_week      = Carbon\Carbon::now()->subWeek()->format('Y-m-d');
        $current_date   = Carbon\Carbon::now()->format('Y-m-d');

        $department_id          = '';
        $designation_id         = '';
        $project_id             = '';
        $branch_id              = '';
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
        compact('departments','projects','branches','designations','department_id','branch_id','employees','from_date','employee_selection','select_employees',
        'project_id','employment_infos','employee_id','designation_id','to_date','original_employee_id','deposit_taxes','excel_link'));
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

            }elseif($request->changes_made == "Project") {
                $audits = $audits->where('auditable_type','App\Project');

            }elseif($request->changes_made == "Branch") {
                $audits = $audits->where('auditable_type','App\Branch');

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

            }elseif($request->changes_made == "Payroll Bank") {
                $audits = $audits->where('auditable_type','App\PayrollBank')
                        ->orWhere('auditable_type','App\PayrollBranch');

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
