<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\EmploymentInfo;
use Auth;

class AttendanceSummaryReportAll implements FromView
{
    public function view(): View
    {
        $employment_infos   = EmploymentInfo::select('attendances.employee_id')
                            ->join('employees','employees.id','employment_infos.employee_id')
                            ->join('attendances','attendances.employee_id','employment_infos.employee_id')
                            ->where('employees.company_id',Auth::user()->company_id)
                            ->orderBy('department_id','asc');
                            
        if(request()->department_id != ""){
            $employment_infos   = $employment_infos->where('department_id',request()->department_id);
        }

        if(request()->designation_id != ""){
            $employment_infos   = $employment_infos->where('designation_id',request()->designation_id);
        }



        if(request()->from_date != null){
            $from_date = request()->from_date;
        }

        if(request()->to_date != null){
            $to_date = request()->to_date;
        }

        if(request()->employee_id != "") {
            $employment_infos   = $employment_infos->whereBetween('date',[$from_date,$to_date]);
        }

        if(request()->employee_id != ""){
            $employees = $employment_infos->groupBy('attendances.employee_id')->get();
        }else{
            $employees = [];
        }

        return view('reports.exports.attendance_summary_list_all_table',
        compact('employees','from_date','to_date'));
    }
}
