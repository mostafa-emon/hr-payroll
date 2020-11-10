<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LeaveType;
use App\LeaveRequest;
use Auth;
use Redirect;

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

    public function leave_request_index() {
        $leaves = LeaveRequest::/*where('employee_id',Auth::user()->id)->*/orderBy('id','desc')->paginate(10);
        return view('transactions.leave.create_request.index',compact('leaves'));
    }

    public function leave_request_add(Request $request) {
        if($request->start_date != "") {
            $leave = new LeaveRequest;
            $leave->company_id    = Auth::user()->company_id;
            $leave->employee_id   = Auth::user()->id;
            $leave->leave_type_id = $request->leave_type_id;
            $leave->start_date    = date('Y-m-d',strtotime($request->start_date));
            $leave->end_date      = date('Y-m-d',strtotime($request->end_date));
            $leave->leave_days    = $request->leave_days;
            $leave->remark        = $request->remark;
            if($request->hasFile('attach_file')){  
                $leave->attach_file       = $request->file('attach_file')->store('leave_request');
            }
            $leave->save();
            return redirect('leave-request')->with('message','Leave Request Created Successfully!');
        }
        $types = LeaveType::where('company_id',Auth::user()->company_id)->orderBy('leave_name','asc')->get();
        return view('transactions.leave.create_request.add',compact('types'));
    }

    public function leave_request_update($request_type,$id,Request $request) {
        $leave = LeaveRequest::where('id',$id)->first();
        if($leave->company_id == Auth::user()->company_id) {
            if($request->start_date != "") {
                $leave->leave_type_id = $request->leave_type_id;
                $leave->start_date    = date('Y-m-d',strtotime($request->start_date));
                $leave->end_date      = date('Y-m-d',strtotime($request->end_date));
                $leave->leave_days    = $request->leave_days;
                $leave->remark        = $request->remark;
                if($request->hasFile('attach_file')){
                    if($leave->attach_file != ""){
                        Storage::delete($leave->attach_file);
                    }
                    $leave->attach_file   = $request->file('attach_file')->store('leave_request');
                }
                $leave->save();
                if($request_type == 'approve'){
                    return redirect('approve-leave-request')->with('message','Leave Request Edited Successfully!');
                }else if($request_type == 'verify'){
                    return redirect('verify-leave-request')->with('message','Leave Request Edited Successfully!');
                }
            }
            $types = LeaveType::where('company_id',Auth::user()->company_id)->orderBy('leave_name','asc')->get();
            return view('transactions.leave.create_request.update',compact('types','leave','request_type'));
        }else{
            return Redirect::back()->with('message','Do not try to be too smart!');
        }
    }

    public function verify_leave_request() {
        $leaves = LeaveRequest::where('company_id',Auth::user()->company_id)->where('status',null)->orderBy('id','asc')->paginate(10);
        return view('transactions.leave.verify_request',compact('leaves'));
    }

    public function leave_request_verify($id) {
        $leave = LeaveRequest::where('id',$id)->first();
        $leave->status = "Verified";
        $leave->save();
        return redirect('verify-leave-request')->with('message','Leave Request Verified Successfully!');
    }

    public function leave_request_reject($id) {
        $leave = LeaveRequest::where('id',$id)->first();
        $leave->status = "Rejected";
        $leave->save();
        return redirect('verify-leave-request')->with('message','Leave Request Rejected Successfully!');
    }

    public function leave_request_approve($id) {
        $leave = LeaveRequest::where('id',$id)->first();
        $leave->status = "Approved";
        $leave->save();
        return redirect('approve-leave-request')->with('message','Leave Request Approved Successfully!');
    }

    public function approve_leave_request() {
        $leaves = LeaveRequest::where('company_id',Auth::user()->company_id)->where('status','Verified')->orderBy('id','asc')->paginate(10);
        return view('transactions.leave.approve_request',compact('leaves'));
    }
}
