<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\LeaveRequest;
use App\Employee;
use App\LeaveType;

use Auth;

class LeaveReportAll implements FromView
{
    public function view(): View
    {
        $leave_types        = LeaveType::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();

        $employment_infos   = LeaveRequest::select('employment_infos.*','leave_requests.*','employees.id','employees.employee_id as string_employee_id','employees.name')
                            ->join('employees','employees.id','leave_requests.employee_id')
                            ->join('employment_infos','employment_infos.employee_id','leave_requests.employee_id')
                            ->where('employees.company_id',Auth::user()->company_id)
                            ->where('leave_requests.status','Approved')
                            ->orderBy('department_id','asc');

        if(request()->from_date != null && request()->to_date != null) {
            $from_date          = request()->from_date;
            $to_date            = request()->to_date;
            $employment_infos   = $employment_infos->whereBetween('start_date',[$from_date,$to_date]);
            $employment_infos   = $employment_infos->whereBetween('end_date',[$from_date,$to_date]);
        }

        if(request()->department_id != ""){
            $employment_infos   = $employment_infos->where('department_id',request()->department_id);
        }

        if(request()->designation_id != ""){
            $employment_infos   = $employment_infos->where('designation_id',request()->designation_id);
        }

        if(request()->gender != ""){
            $employment_infos   = $employment_infos->where('gender',request()->gender);
        }

        if(request()->duty_type != ""){
            $employment_infos   = $employment_infos->where('duty_type',request()->duty_type);
        }

        $employees              = $employment_infos->groupBy('leave_requests.employee_id')->get();
        

        return view('reports.exports.leave_list_all_table',compact('employees','from_date','to_date','leave_types'));
    }
}
