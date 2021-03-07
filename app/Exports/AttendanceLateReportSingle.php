<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\EmploymentInfo;
use App\Attendance;
use App\Employee;
use Auth;

class AttendanceLateReportSingle implements FromView
{
    public function view(): View
    {
        $remark = request()->remark;

        $employment_infos   = Attendance::orderBy('employment_infos.id','asc')
                            ->select('employment_infos.*','attendances.id as attendance_id','attendances.employee_id','attendances.date','attendances.actual_in_time','attendances.actual_out_time','attendances.roster_employee','attendances.in_time','attendances.out_time','attendances.late','attendances.over_time','attendances.total_working_hour','attendances.status','attendances.note','employees.id','employees.employee_id as string_employee_id','employees.name')
                            ->join('employees','employees.id','attendances.employee_id')
                            ->join('employment_infos','employment_infos.employee_id','attendances.employee_id')
                            ->where('employees.company_id',Auth::user()->company_id)
                            ->where('status','PRESENT')->where('late','>',0);
                            
        if(request()->attendance_id != ""){
            $attendance_id      = explode(" ",request()->attendance_id);
            $employees          = $employment_infos->whereIn('attendances.id',$attendance_id)->get();
        }else{
            $employees = [];
        }

        if(request()->employee_id != ""){
            $employee_id        = request()->employee_id;
            $employee_selection = Employee::where('id',$employee_id)->first();
        }

        if(request()->from_date != ""){
            $from_date          = request()->from_date;
        }

        if(request()->to_date != ""){
            $to_date            = request()->to_date;
        }

        return view('reports.exports.attendance_late_list_single_table',
        compact('employees','remark','employee_selection','from_date','to_date'));
    }
}
