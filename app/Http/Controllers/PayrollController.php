<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PayrollBank;
use App\PayrollBranch;
use Auth;

class PayrollController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function bank_index() {
        $banks = PayrollBank::where('company_id',Auth::user()->company_id)->orderBy('bank_name','asc')->paginate(10);
        return view('payroll_setup.banks.index',compact('banks'));
    }

    public function bank_add(Request $request) {
        $bank = new PayrollBank;
        $bank->company_id = Auth::user()->company_id;
        $bank->bank_name  = $request->bank_name;
        $bank->save();
        return redirect('payroll-banks')->with('message','Bank added successfully!');
    }

    public function bank_get($id) {
        $bank = PayrollBank::where('id',$id)->first();
        echo $bank;
    }

    public function bank_update(Request $request,$id) {
        $bank = PayrollBank::where('id',$id)->first();
        $bank->bank_name = $request->bank_name;
        $bank->save();
        return redirect('payroll-banks')->with('message','Bank updated successfully!');
    }

    public function bank_delete($id) {
        $bank = PayrollBank::find($id);
        if($bank->company_id == Auth::user()->company_id){
            $bank->delete();
            return redirect('payroll-banks')->with('message','Bank Deleted Successfully!');
        }else{
            return redirect('payroll-banks')->with('message','Do not try to be too smart!');
        }
    }

    // Branch
    public function branch_index($id) {
        $branches   = PayrollBranch::where('bank_id',$id)->orderBy('branch_name','asc')->get();
        $bank       = PayrollBank::where('id',$id)->first();
        return view('payroll_setup.banks.branches',compact('branches','bank'));
    }

    public function branch_add(Request $request) {
        $branch = new PayrollBranch;
        $branch->bank_id        = $request->bank_id;
        $branch->branch_name    = $request->branch_name;
        $branch->save();
        return back()->with('message','Branch Added Successfully!');
    }

    public function branch_get($id) {
        $branch = PayrollBranch::where('id',$id)->first();
        echo $branch;
    }

    public function branch_update(Request $request,$id) {
        $branch = PayrollBranch::where('id',$id)->first();
        $branch->branch_name    = $request->branch_name;
        $branch->save();
        return back()->with('message','Branch Updated Successfully!');
    }

    public function branch_delete($id) {
        $branch = PayrollBranch::find($id);
        $branch->delete();
        return back()->with('message','Branch Deleted Successfully!');
    }
}
