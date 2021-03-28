<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\ProvidentFund;
use Auth;
use DB;

class PfSummaryReport implements FromView
{
    public function view(): View
    {
        if(request()->from_date != null){
            $from_date = request()->from_date;
        }

        if(request()->to_date != null){
            $to_date = request()->to_date;
        }

        if(request()->show_previous_balance != ""){
            $show_previous_balance  = request()->show_previous_balance;
        }

        if(request()->show_current_period != ""){
            $show_current_period    = request()->show_current_period;
        }

        if(request()->show_closing_balance != ""){
            $show_closing_balance   = request()->show_closing_balance;
        }

        if(request()->provident_fund_id != ""){
            $provident_fund_id  = explode(" ",request()->provident_fund_id);
            $employees          = ProvidentFund::whereIn('id',$provident_fund_id)->groupBy('employee_id')->get();
        }else{
            $employees = [];
        }

        return view('reports.exports.pf_summary_list_table',
        compact('employees','from_date','to_date','show_previous_balance','show_current_period','show_closing_balance'));
    }
}
