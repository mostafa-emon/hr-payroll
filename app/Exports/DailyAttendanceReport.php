<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Attendance;
use Auth;

class DailyAttendanceReport implements FromView
{
    public function view(): View
    {
        $remark = request()->remark;

        $employment_infos   = Attendance::orderBy('department_id','asc')
                            ->select('employment_infos.*','attendances.id as attendance_id','attendances.employee_id','attendances.date','attendances.actual_in_time','attendances.actual_out_time','attendances.roster_employee','attendances.in_time','attendances.out_time','attendances.late','attendances.over_time','attendances.total_working_hour','attendances.status','attendances.readable_status','attendances.note','employees.id','employees.employee_id as string_employee_id','employees.name')
                            ->join('employees','employees.id','attendances.employee_id')
                            ->join('employment_infos','employment_infos.employee_id','attendances.employee_id')
                            ->where('employees.company_id',Auth::user()->company_id);
                            
        if(request()->attendance_id != ""){
            $attendance_id      = explode(" ",request()->attendance_id);
            $employees          = $employment_infos->whereIn('attendances.id',$attendance_id)->get();
        }else{
            $employees = [];
        }

        if(request()->date != ""){
            $date               = request()->date;
        }

        return view('reports.exports.daily_attendance_list_table',
        compact('employees','remark','date'));
    }
}
