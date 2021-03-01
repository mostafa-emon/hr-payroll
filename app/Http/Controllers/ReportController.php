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
use Auth;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function daily_attendance_report(Request $request) {
        $employment_infos   = EmploymentInfo::orderBy('employment_infos.id','asc')->join('employees','employees.id','employment_infos.employee_id')->where('employees.company_id',Auth::user()->company_id);
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
            $employment_infos    = $employment_infos->where('branch_id',$request->branch_id);
            $branch_id           = $request->branch_id;
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
        }

        if($request->employee_id == "" && $request->employee_id != ['All']) {
            $employment_infos = $employment_infos->get();
        }

        return view('reports.attendance.daily_attendance',
        compact('departments','projects','branches','designations','department_id','branch_id',
        'all_employee','project_id','employment_infos','employee_id','designation_id'));
    }
}
