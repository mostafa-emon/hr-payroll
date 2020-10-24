<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GovtHoliday;
use Auth;

class HolidayController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index() {
        $holidays = GovtHoliday::where('company_id',Auth::user()->company_id)->orderBy('name','asc')->paginate(10);
        return view('attendance_setup.govt_holiday.index',compact('holidays'));
    }

    public function add(Request $request) {
        if($request->name != "") {
            $holiday = new GovtHoliday;
            $holiday->company_id    = Auth::user()->company_id;
            $holiday->name          = $request->name;
            $holiday->holiday_id    = $request->holiday_id;
            $holiday->start_date    = date('Y-m-d',strtotime($request->start_date));
            $holiday->end_date      = date('Y-m-d',strtotime($request->end_date));
            $holiday->save();
            return redirect('govt-holiday')->with('message','Govt Holiday Added Successfully!');
        }
        return view('attendance_setup.govt_holiday.add');
    }

    public function update(Request $request,$id) {
        $holiday = GovtHoliday::where('id',$id)->first();
        if($holiday->company_id == Auth::user()->company_id) {
            if($request->name != "") {
                $holiday->name          = $request->name;
                $holiday->holiday_id    = $request->holiday_id;
                $holiday->start_date    = date('Y-m-d',strtotime($request->start_date));
                $holiday->end_date      = date('Y-m-d',strtotime($request->end_date));
                $holiday->save();
                return redirect('govt-holiday')->with('message','Govt Holiday Updated Successfully!');
            }
            return view('attendance_setup.govt_holiday.update',compact('holiday'));
        }else{
            return redirect('govt-holiday')->with('message','Do not try to be too smart!');
        }
    }

    public function delete($id) {
        $holiday = GovtHoliday::find($id);
        if($holiday->company_id == Auth::user()->company_id){
            $holiday->delete();
            return redirect('govt-holiday')->with('message','Govt Holiday Deleted Successfully!');
        }else{
            return redirect('govt-holiday')->with('message','Do not try to be too smart!');
        }
    }
}
