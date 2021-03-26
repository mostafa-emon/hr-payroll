<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Employee;
use App\ProvidentFund;

use Auth;

class PfDetailReport implements FromView
{
    public function view(): View
    {
        $employment_infos   = ProvidentFund::select('employment_infos.*','provident_funds.*','employees.id','employees.employee_id as string_employee_id','employees.name')
                            ->join('employees','employees.id','provident_funds.employee_id')
                            ->join('employment_infos','employment_infos.employee_id','provident_funds.employee_id')
                            ->where('employees.company_id',Auth::user()->company_id)
                            ->orderBy('provident_funds.id','asc');

        if(request()->from_date != null && request()->to_date != null) {
            $from_date          = request()->from_date;
            $to_date            = request()->to_date;
            $employment_infos   = $employment_infos->whereBetween('provident_funds.query_date',[$from_date,$to_date]);
        }

        $show_previous_balance  = request()->show_previous_balance;

        if(request()->employee_id != "") {
            $employee_selection     = Employee::where('company_id',Auth::user()->company_id)->where('id',request()->employee_id)->first();
            $employees              = $employment_infos->where('provident_funds.employee_id',$employee_selection->id)->groupBy('provident_funds.query_date')->get();
        }else{
            $employees = [];
        }

        return view('reports.exports.pf_detail_list_table',compact('employees','employee_selection','from_date','to_date','show_previous_balance'));
    }
}
