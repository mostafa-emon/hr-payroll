<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ShiftType;
use Auth;

class ShiftController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $shifts = ShiftType::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->paginate(10);
        return view('attendance_setup.shifts',compact('shifts'));
    }

    public function add(Request $request) {
        $shift = new ShiftType;
        $shift->company_id          = Auth::user()->company_id;
        $shift->name                = $request->name;
        $shift->shift_id            = $request->shift_id;
        $shift->shift_short_name    = $request->shift_short_name;

        $shift->start_time          = date('h:i',strtotime($request->start_time));
        $start_time_am_or_pm        = date('A',strtotime($request->start_time));
        if($start_time_am_or_pm == "AM") {
            $shift->start_time_meridiem = 0;
        }else { $shift->start_time_meridiem = 1; }
        
        $shift->end_time            = date('h:i',strtotime($request->end_time));
        $end_time_am_or_pm          = date('A',strtotime($request->end_time));
        if($end_time_am_or_pm == "AM") {
            $shift->end_time_meridiem = 0;
        }else { $shift->end_time_meridiem = 1; }

        $shift->save();
        return redirect('shift')->with('message','Shift Added Successfully!');
    }

    public function get($id) {
        $shift = ShiftType::where('id',$id)->first();

        if($shift->start_time_meridiem == 1) {
            $shift->start_time = date('H:i',strtotime($shift->start_time . " +12 hours"));
        }else {
            $shift->start_time = date('H:i',strtotime($shift->start_time));
        }

        if($shift->end_time_meridiem == 1) {
            $shift->end_time = date('H:i',strtotime($shift->end_time . " +12 hours"));
        }else {
            $shift->end_time = date('H:i',strtotime($shift->end_time));
        }
        
        echo $shift;
    }

    public function update(Request $request,$id) {
        $shift = ShiftType::where('id',$id)->first();
        $shift->name                = $request->name;
        $shift->shift_id            = $request->shift_id;
        $shift->shift_short_name    = $request->shift_short_name;
        
        $shift->start_time          = date('h:i',strtotime($request->start_time));
        $start_time_am_or_pm        = date('A',strtotime($request->start_time));
        if($start_time_am_or_pm == "AM") {
            $shift->start_time_meridiem = 0;
        }else { $shift->start_time_meridiem = 1; }
        
        $shift->end_time            = date('h:i',strtotime($request->end_time));
        $end_time_am_or_pm          = date('A',strtotime($request->end_time));
        if($end_time_am_or_pm == "AM") {
            $shift->end_time_meridiem = 0;
        }else { $shift->end_time_meridiem = 1; }

        $shift->save();
        return redirect('shift')->with('message','Shift Updated Successfully!');
    }

    public function delete($id) {
        $shift = ShiftType::find($id);
        if($shift->company_id == Auth::user()->company_id){
            $shift->delete();
            return redirect('shift')->with('message','Shift Deleted Successfully!');
        }else{
            return redirect('shift')->with('message','Do not try to be too smart!');
        }
    }
}
