<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Attendance;
use Auth;
use DB;

class OTSummaryReport implements FromView
{
    public function view(): View
    {
        if(request()->from_date != null){
            $from_date = request()->from_date;
        }

        if(request()->to_date != null){
            $to_date = request()->to_date;
        }

        if(request()->attendance_id != ""){
            $attendance_id          = explode(" ",request()->attendance_id);
            $employees = Attendance::whereIn('id',$attendance_id)->select('employee_id',DB::raw('SUM(over_time) as over_time'))->groupBy('employee_id')->get();
        }else{
            $employees = [];
        }

        return view('reports.exports.ot_summary_list_table',
        compact('employees','from_date','to_date'));
    }
}
