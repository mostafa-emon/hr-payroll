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
        return view('attendance_setup.govt_holiday',compact('holidays'));
    }

    /*public function add(Request $request) {
        $designation = new GovtHoliday;
        $designation->company_id     = Auth::user()->company_id;
        $designation->name           = $request->name;
        $designation->designation_id = $request->designation_id;
        $designation->save();
        return redirect('designations')->with('message','Designation Added Successfully!');
    }

    public function get($id) {
        $designation = GovtHoliday::where('id',$id)->first();
        echo $designation;
    }

    public function update(Request $request,$id) {
        $designation = GovtHoliday::where('id',$id)->first();
        $designation->name           = $request->name;
        $designation->designation_id = $request->designation_id;
        $designation->save();
        return redirect('designations')->with('message','Designation Updated Successfully!');
    }

    public function delete($id) {
        $designation = GovtHoliday::find($id);
        if($designation->company_id == Auth::user()->company_id){
            $designation->delete();
            return redirect('designations')->with('message','Designation Deleted Successfully!');
        }else{
            return redirect('designations')->with('message','Do not try to be too smart!');
        }
    }*/
}
