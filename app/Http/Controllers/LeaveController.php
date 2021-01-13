<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LeaveType;
use App\LeaveRequest;
use App\Employee;
use App\EmploymentInfo;
use App\LeaveInfo;
use App\LeaveBalance;
use App\Department;
use App\Project;
use App\Branch;
use App\PaidLeave;
use Auth;
use Carbon;
use Redirect;
use DateTime;

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
        $type->reference          = $request->reference;
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
        $type->reference          = $request->reference;
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
        $leaves = LeaveRequest::where('employee_id',Auth::user()->employee_id)->orderBy('id','desc')->paginate(10);
        return view('transactions.leave.create_request.index',compact('leaves'));
    }

    public function leave_request_add(Request $request) {
        if($request->start_date != "") {
            
            $employee = Employee::where('id',Auth::user()->employee_id)->first();
            if($employee != ""){
                
                $current_date           = Carbon\Carbon::now()->format('Y-m-d');
                if($employee->leave_count_from == 'date_of_confirmation') {
                    $date_of_confirmation   = EmploymentInfo::where('employee_id',Auth::user()->employee_id)->first();
                    if($date_of_confirmation !="" && $current_date < $date_of_confirmation->date_of_confirmation) {
                        $confirmation_date  = date('d-m-Y',strtotime($date_of_confirmation->date_of_confirmation));
                        return redirect('leave-request/add')->with('error_message','You can not take leave before your job Confirmation date '.$confirmation_date.'!');
                    }
                }
                
                $curYear = date('Y');
                $from = $curYear.'-01-01';
                $to = $curYear.'-12-31';

                $leave_info     = LeaveInfo::where('employee_id',Auth::user()->employee_id)->where('leave_type_id',$request->leave_type_id)->first();
                $leave_requests = LeaveRequest::where('employee_id',Auth::user()->employee_id)->whereBetween('start_date', [$from, $to])->whereBetween('end_date', [$from, $to])->where('leave_type_id',$request->leave_type_id)->where('status','!=','Rejected')->get();

                if($leave_requests !=""){
                    $before_leave = 0;
                    foreach($leave_requests as $leave_request) {
                        $before_leave = $before_leave + $leave_request->leave_days;
                    }
                }
                $total_leave = $before_leave + $request->leave_days;

                if($leave_info !=""){
                    $allotment_year = date('Y', strtotime($leave_info->opening_balance_date));
                    if($allotment_year == $curYear){
                        if($leave_info->opening_balance < $total_leave) {

                            if($leave_requests != "") {
                                if($leave_info->opening_balance > $before_leave) {
                                    $remaining_leave = $leave_info->opening_balance - $before_leave;
                                    return redirect('leave-request/add')->with('error_message','You can not take leave more than '.$remaining_leave.' days!');
                                }else{
                                    return redirect('leave-request/add')->with('error_message','You can not take any leave this year!');
                                }
                            }
                        }
                    }

                    $leave_balances = LeaveBalance::where('employee_id',Auth::user()->employee_id)->where('leave_type_id',$request->leave_type_id)->where('applicable_year',$curYear)->get();
                    if($leave_balances !=""){
                        $balance = 0;
                        foreach($leave_balances as $leave_balance){
                            $balance = $balance + $leave_balance->transfer_amount;
                        }
                    }

                    if(count($leave_balances) == 0){
                        if($leave_info->yearly_allotment < $total_leave){
                            if($leave_requests != "") {
                                if($leave_info->yearly_allotment > $before_leave) {
                                    $remaining_leave = $leave_info->yearly_allotment - $before_leave;
                                    return redirect('leave-request/add')->with('error_message','You can not take leave more than '.$remaining_leave.' days!');
                                }else{
                                    return redirect('leave-request/add')->with('error_message','You can not take any leave this year!');
                                }
                            }
                        }
                    }else{
                        $grand_total_leave = $balance + $leave_info->yearly_allotment;
                        if($grand_total_leave < $total_leave){
                            if($leave_requests != "") {
                                if($grand_total_leave > $before_leave) {
                                    $remaining_leave = $grand_total_leave - $before_leave;
                                    return redirect('leave-request/add')->with('error_message','You can not take leave more than '.$remaining_leave.' days!');
                                }else{
                                    return redirect('leave-request/add')->with('error_message','You can not take any leave this year!');
                                }
                            }
                        }
                    }

                }

                $leave_type = LeaveType::where('id',$request->leave_type_id)->first();
                if($leave_type->reference == 'paid_leave') {
                    $total_date = $leave_type->el_deviding_factor * $request->leave_days;
                    $last_date = Carbon\Carbon::now()->subDays($total_date)->format('Y-m-d');

                    $request_leaves = LeaveRequest::where('employee_id',Auth::user()->employee_id)->whereBetween('start_date', [$last_date, $current_date])->where('leave_type_id',$request->leave_type_id)->where('status','!=','Rejected')->get();
                    if(count($request_leaves) > 0){
                        return redirect('leave-request/add')->with('error_message','You can take 1 earn leave after '.$leave_type->el_deviding_factor.' days!');
                    }
                }
            }

            $leave = new LeaveRequest;
            $leave->company_id    = Auth::user()->company_id;
            $leave->employee_id   = Auth::user()->employee_id;
            $leave->leave_type_id = $request->leave_type_id;
            $leave->start_date    = date('Y-m-d',strtotime($request->start_date));
            $leave->end_date      = date('Y-m-d',strtotime($request->end_date));
            $leave->leave_days    = $request->leave_days;
            $leave->remark        = $request->remark;
            $leave->status        = "Pending";
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
        $leaves = LeaveRequest::where('company_id',Auth::user()->company_id)->where('status','Pending')->orderBy('id','asc')->paginate(10);
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

        if(LeaveType::where('id',$leave->leave_type_id)->first()->reference == "paid_leave") {
            $formatted_from_date = new DateTime($leave->start_date);
            $formatted_to_date   = new DateTime($leave->end_date);
            $interval = $formatted_to_date->diff($formatted_from_date);
            $interval = $interval->format('%a');
    
            $current_day = $leave->start_date;

            for($i = 0; $i <= $interval; $i++) {
                $next_day = date('Y-m-d', strtotime('+1 day', strtotime($current_day)));

                $paid_leave = new PaidLeave();
                $paid_leave->employee_id    = $leave->employee_id;
                $paid_leave->date           = $current_day;
                $paid_leave->save();

                $current_day = $next_day;
            }
        }
        return redirect('approve-leave-request')->with('message','Leave Request Approved Successfully!');
    }

    public function approve_leave_request() {
        $leaves = LeaveRequest::where('company_id',Auth::user()->company_id)->where('status','Verified')->orderBy('id','asc')->paginate(10);
        return view('transactions.leave.approve_request',compact('leaves'));
    }




    // Balance Transfer
    public function leave_balance_transfer(Request $request){

        $employment_infos   = EmploymentInfo::orderBy('employment_infos.id','asc')->join('employees','employees.id','employment_infos.employee_id');
        $departments        = Department::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $projects           = Project::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $branches           = Branch::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();

        $department_id      = '';
        $project_id         = '';
        $branch_id          = '';
        $employee_id        = '';
        $applicable_for     = '';
        $leave_types        = '';
        $employee           = '';

        if($request->department_id != ""){
            $employment_infos   = $employment_infos->where('department_id',$request->department_id);
            $department_id      = $request->department_id;
        }

        if($request->project_id != ""){
            $employment_infos   = $employment_infos->where('project_id',$request->project_id);
            $project_id         = $request->project_id;
        }

        if($request->branch_id != ""){
            $employment_infos    = $employment_infos->where('branch_id',$request->branch_id);
            $branch_id           = $request->branch_id;
        }

        if($request->employee_id != ""){
            $employment_infos    = $employment_infos->where('employees.employee_id',$request->employee_id);
            $employee_id           = $request->employee_id;
        }

        if($request->employee_id != "" || $request->department_id != "") {
            $employment_infos   = $employment_infos->get();
            $employee           = Employee::where('employee_id',$request->employee_id)->first();
            $leave_infos        = LeaveInfo::where('employee_id',$employee->id)->where('carry_forward',1)->get();
            $leave_types        = LeaveType::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
            $applicable_for     = $request->applicable_for;
        }else{
            $employment_infos   = [];
            $leave_infos        = [];
        }

        return view('transactions.leave.balance_transfer.index',
        compact('departments','projects','branches','department_id','branch_id','applicable_for',
        'project_id','employment_infos','employee_id','leave_infos','leave_types','employee'));
    }

    public function transfer_leave_balance($employee_id,Request $request){
        if($request->applicable_year !=""){
            $leave_balance = LeaveBalance::where('employee_id',$employee_id)->where('applicable_year',$request->applicable_year)->get();
            if(count($leave_balance) > 0){
                return redirect('leave-balance-transfer')->with('error_message', 'You Have Already Transferred This Employee Balance!');
            }
            $leaves_row_count = count($request->transfer_amount);
            for($i = 0; $i < $leaves_row_count; $i++) {
                $leave = new LeaveBalance();
                $leave->employee_id     = $employee_id;
                $leave->leave_type_id   = $request->leave_type_id[$i];
                $leave->transfer_amount = $request->transfer_amount[$i];
                $leave->applicable_year = $request->applicable_year;
                $leave->save();
            }
            return redirect('leave-balance-transfer')->with('message', 'Leave Balance Transferred Successfully!');
        }
    }
}
