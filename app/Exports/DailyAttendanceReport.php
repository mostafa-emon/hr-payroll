<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\EmploymentInfo;
use Auth;

class DailyAttendanceReport implements FromView
{
    public function view(): View
    {
        $remark = request()->remark;

        $employment_infos   = EmploymentInfo::orderBy('employment_infos.id','asc')
                            ->select('employment_infos.*','attendances.*','employees.id','employees.employee_id as string_employee_id','employees.name')
                            ->join('employees','employees.id','employment_infos.employee_id')
                            ->join('attendances','attendances.id','employment_infos.employee_id')
                            ->where('employees.company_id',Auth::user()->company_id);
                            
        if(request()->employee_id != ""){
            $employee_id        = explode(" ",request()->employee_id);
            $employees          = $employment_infos->whereIn('employees.employee_id',$employee_id)->get();
        }else{
            $employees = [];
        }

        return view('reports.exports.daily_attendance_list_table',
        compact('employees','remark'));
    }
}
