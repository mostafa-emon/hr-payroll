<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Employee;
use App\DepositSalaryTax;
use App\DepositSalaryTaxDetail;
use App\SalarySheetDetails;

use Auth;

class SalaryCertificate implements FromView
{
    public function view(): View
    {
        $employment_infos   = SalarySheetDetails::orderBy('employment_infos.id','asc')
                            ->select('employment_infos.*','salary_sheet_details.*','employees.id','employees.employee_id as string_employee_id','employees.name')
                            ->join('employees','employees.id','salary_sheet_details.employee_id')
                            ->join('employment_infos','employment_infos.employee_id','salary_sheet_details.employee_id')
                            ->where('employees.company_id',Auth::user()->company_id)
                            ->where('component_type','!=','Deduction');

        $deposit_taxes      = DepositSalaryTax::orderBy('deposit_salary_taxes.id','asc')
                            ->select('deposit_salary_taxes.id','deposit_salary_taxes.company_id','deposit_salary_taxes.challan_no','deposit_salary_taxes.chalan_date','deposit_salary_taxes.bank_name','deposit_salary_tax_details.*')
                            ->join('deposit_salary_tax_details','deposit_salary_tax_details.tax_id','deposit_salary_taxes.id')
                            ->where('deposit_salary_taxes.company_id',Auth::user()->company_id)
                            ->where('status','Approved');

        if(request()->from_date != null && request()->to_date != null) {
            $from_date          = request()->from_date;
            $to_date            = request()->to_date;
            $employment_infos   = $employment_infos->whereBetween('query_date',[$from_date,$to_date]);
            $deposit_taxes      = $deposit_taxes->whereBetween('query_date',[$from_date,$to_date]);
        }

        if(request()->employee_id != "") {
            $employee_selection     = Employee::where('company_id',Auth::user()->company_id)->where('id',request()->employee_id)->first();
            $employees              = $employment_infos->where('salary_sheet_details.employee_id',request()->employee_id)->groupBy('salary_sheet_details.component_id')->get();
            $deposit_taxes          = $deposit_taxes->where('employee_id',request()->employee_id)->get();
        }else{
            $employees      = [];
            $deposit_taxes  = [];
        }

        return view('reports.exports.salary_certificate_table',compact('employees','employee_selection','from_date','to_date','deposit_taxes'));
    }
}
