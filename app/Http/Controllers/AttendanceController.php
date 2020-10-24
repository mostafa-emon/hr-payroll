<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AttendancePolicy;
use Auth;

class AttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $policies = AttendancePolicy::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->paginate(10);
        return view('attendance_setup.attendance_policy.index',compact('policies'));
    }

    public function add(Request $request) {
        if($request->start_time != "") {
            $policy = new AttendancePolicy;
            $policy->company_id             = Auth::user()->company_id;
            $policy->start_time             = $request->start_time;
            $policy->start_time_meridiem    = $request->start_time_meridiem;
            $policy->end_time               = $request->end_time;
            $policy->end_time_meridiem      = $request->end_time_meridiem;
            $policy->late_policy            = $request->late_policy;
            $policy->late_mark              = $request->late_mark;
            $policy->late_absent_policy     = $request->late_absent_policy;
            $policy->marks_absent_for       = $request->marks_absent_for;
            $policy->use_ot_round           = $request->use_ot_round;
            $policy->ot_round               = $request->ot_round;
            $policy->time_for_ot            = $request->time_for_ot;
            $policy->clear_log_data         = $request->clear_log_data;
            $policy->save();
            return redirect('attendance-policy')->with('message','Attendance Policy Added Successfully!');
        }
        return view('attendance_setup.attendance_policy.add');
    }

    public function update(Request $request,$id) {
        $policy = AttendancePolicy::where('id',$id)->first();
        if($policy->company_id == Auth::user()->company_id) {
            if($request->start_time != "") {
                $policy->start_time             = $request->start_time;
                $policy->start_time_meridiem    = $request->start_time_meridiem;
                $policy->end_time               = $request->end_time;
                $policy->end_time_meridiem      = $request->end_time_meridiem;
                $policy->late_policy            = $request->late_policy;
                $policy->late_mark              = $request->late_mark;
                $policy->late_absent_policy     = $request->late_absent_policy;
                $policy->marks_absent_for       = $request->marks_absent_for;
                $policy->use_ot_round           = $request->use_ot_round;
                $policy->ot_round               = $request->ot_round;
                $policy->time_for_ot            = $request->time_for_ot;
                $policy->clear_log_data         = $request->clear_log_data;
                $policy->save();
                return redirect('attendance-policy')->with('message','Attendance Policy Updated Successfully!');
            }
            return view('attendance_setup.attendance_policy.update',compact('policy'));
        }else{
            return redirect('attendance-policy')->with('message','Do not try to be too smart!');
        }
    }

    public function delete($id) {
        $policy = AttendancePolicy::find($id);
        if($policy->company_id == Auth::user()->company_id){
            $policy->delete();
            return redirect('attendance-policy')->with('message','Attendance Policy Deleted Successfully!');
        }else{
            return redirect('attendance-policy')->with('message','Do not try to be too smart!');
        }
    }
}
