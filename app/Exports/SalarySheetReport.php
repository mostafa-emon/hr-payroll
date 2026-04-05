<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\EmploymentInfo;
use Auth;
use DateTime;
use DateInterval;
use DatePeriod;

class SalarySheetReport implements FromView
{
    public function view(): View
    {
        $hide_detail_btn        = 'Yes';

        $employment_infos       = EmploymentInfo::orderBy('employment_infos.department_id','asc')
                                ->select('employees.name','employees.employee_id as original_employee_id','employment_infos.*','salary_sheets.*','payroll_infos.currency_id')
                                ->join('payroll_infos','payroll_infos.employee_id','employment_infos.employee_id')
                                ->join('employees','employees.id','employment_infos.employee_id')
                                ->join('salary_sheets','salary_sheets.employee_id','employment_infos.employee_id')
                                ->where('employees.company_id',Auth::user()->company_id);

        if(request()->month != null && request()->year != null) {
            $month          = request()->month;
            $year           = request()->year;
            $employment_infos   = $employment_infos->where('month',$month)->where('year',$year);
        }

        if(request()->department_id != ""){
            $employment_infos   = $employment_infos->where('department_id',request()->department_id);
        }

        if(request()->designation_id != ""){
            $employment_infos   = $employment_infos->where('designation_id',request()->designation_id);
        }

        if(request()->currency_id != ""){
            $employment_infos   = $employment_infos->where('currency_id',request()->currency_id);
        }

        $employment_infos   = $employment_infos->get();

        return view('reports.exports.salary_sheet_list_table',compact('employment_infos','month','year','hide_detail_btn'));
    }
}
