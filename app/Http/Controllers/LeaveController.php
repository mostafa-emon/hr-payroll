<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LeaveType;
use Auth;

class LeaveController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function leave_type_index() {
        $types = LeaveType::where('company_id',Auth::user()->company_id)->orderBy('leave_name','asc')->paginate(10);
        return view('leave_setup.leave_type',compact('types'));
    }

    public function leave_type_add(Request $request) {
        $type = new LeaveType;
        $type->company_id         = Auth::user()->company_id;
        $type->leave_name         = $request->leave_name;
        $type->leave_id           = $request->leave_id;
        $type->leave_short_name   = $request->leave_short_name;
        if($request->el_deviding_factor != null){
            $type->el_deviding_factor = $request->el_deviding_factor;
        }else{
            $type->el_deviding_factor = 21;
        }
        $type->save();
        return redirect('leave-type')->with('message','Leave Type Added Successfully!');
    }

    public function leave_type_get($id) {
        $type = LeaveType::where('id',$id)->first();
        echo $type;
    }

    public function leave_type_update(Request $request,$id) {
        $type = LeaveType::where('id',$id)->first();
        $type->leave_name         = $request->leave_name;
        $type->leave_id           = $request->leave_id;
        $type->leave_short_name   = $request->leave_short_name;
        if($request->el_deviding_factor != null){
            $type->el_deviding_factor = $request->el_deviding_factor;
        }else{
            $type->el_deviding_factor = 21;
        }
        $type->save();
        return redirect('leave-type')->with('message','Leave Type Updated Successfully!');
    }

    public function leave_type_delete($id) {
        $type = LeaveType::find($id);
        if($type->company_id == Auth::user()->company_id){
            $type->delete();
            return redirect('leave-type')->with('message','Leave Type Deleted Successfully!');
        }else{
            return redirect('leave-type')->with('message','Do not try to be too smart!');
        }
    }
}
