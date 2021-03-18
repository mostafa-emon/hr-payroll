<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\LeaveRequest;
use App\Employee;
use App\LeaveType;

use Auth;

class RejectedLeaveReport implements FromView
{
    public function view(): View
    {
        $leave_types        = LeaveType::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();

        $employment_infos   = LeaveRequest::select('employment_infos.*','leave_requests.*','employees.id','employees.employee_id as string_employee_id','employees.name')
                            ->join('employees','employees.id','leave_requests.employee_id')
                            ->join('employment_infos','employment_infos.employee_id','leave_requests.employee_id')
                            ->where('employees.company_id',Auth::user()->company_id)
                            ->where('leave_requests.status','Rejected')
                            ->orderBy('leave_requests.id','asc');

        if(request()->from_date != null && request()->to_date != null) {
            $from_date          = request()->from_date;
            $to_date            = request()->to_date;
            $employment_infos   = $employment_infos->whereBetween('start_date',[$from_date,$to_date]);
            $employment_infos   = $employment_infos->whereBetween('end_date',[$from_date,$to_date]);
        }

        if(request()->employee_id != "") {
            $employee_selection     = Employee::where('company_id',Auth::user()->company_id)->where('id',request()->employee_id)->first();
            $employees              = $employment_infos->where('leave_requests.employee_id',$employee_selection->id)->get();
        }else{
            $employees = [];
        }

        return view('reports.exports.rejected_leave_list_table',compact('employees','employee_selection','from_date','to_date','leave_types'));
    }
}
