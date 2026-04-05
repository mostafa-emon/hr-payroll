<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\EmploymentInfo;
use Auth;
use DateTime;
use DateInterval;
use DatePeriod;

class EarningAdjustmentReport implements FromView
{
    public function view(): View
    {
        $employment_infos   = EmploymentInfo::select('earning_deduction_adjustments.*','employment_infos.*','employees.id','employees.employee_id as string_employee_id','employees.name','employees.gender','employees.blood_group','employees.date_of_birth','employees.religion','employees.phone_1','employees.nid_number')
                                ->join('employees','employees.id','employment_infos.employee_id')
                                ->join('earning_deduction_adjustments','earning_deduction_adjustments.employee_id','employment_infos.employee_id')
                                ->where('employees.company_id',Auth::user()->company_id)
                                ->where('earning_deduction_adjustments.status',1)
                                ->where('earning_deduction_adjustments.earning_or_deduction','earnings')
                                ->orderBy('earning_deduction_adjustments.salary_component_id','asc');

        if(request()->from_date != null && request()->to_date != null) {
            $from_date          = request()->from_date;
            $to_date            = request()->to_date;
            $employment_infos   = $employment_infos->whereBetween('earning_deduction_adjustments.query_date',[$from_date,$to_date]);

            $start    = (new DateTime($from_date))->modify('first day of this month');
            $end      = (new DateTime($to_date))->modify('first day of next month');
            $interval = DateInterval::createFromDateString('1 month');
            $period   = new DatePeriod($start, $interval, $end);
        }

        if(request()->department_id != ""){
            $employment_infos   = $employment_infos->where('department_id',request()->department_id);
        }

        if(request()->designation_id != ""){
            $employment_infos   = $employment_infos->where('designation_id',request()->designation_id);
        }

        
        if(request()->component_id != ""){
            $employment_infos   = $employment_infos->where('earning_deduction_adjustments.salary_component_id',request()->component_id);
        }

        if(request()->employee_id != ""){
            $employment_infos   = $employment_infos->where('earning_deduction_adjustments.employee_id',request()->employee_id);
        }

        $employees      = $employment_infos->groupBy('earning_deduction_adjustments.salary_component_id','earning_deduction_adjustments.employee_id')->get();

        return view('reports.exports.earning_adjustment_report_table',compact('employees','from_date','to_date','period'));
    }
}
