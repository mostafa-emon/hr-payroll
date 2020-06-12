<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Signatory;
use Auth;

class SignatoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $signatory = Signatory::where('company_id', Auth::user()->company_id)->first();
        return view('signatories.index', ['signatories' => $signatory]);
    }

    public function update(Request $request){
        $count = Signatory::where('company_id',Auth::user()->company_id)->count();

        if($count == 0) {
            $signatory = new Signatory;
            $signatory->company_id       = Auth::user()->company_id;
            $signatory->prepared_by      = $request->prepared_by;
            $signatory->checked_by       = $request->checked_by;
            $signatory->verified_by      = $request->verified_by;
            $signatory->authorized_by    = $request->authorized_by;
            $signatory->approved_by      = $request->approved_by;
            $signatory->save();
        }else{
            $signatory = Signatory::where('company_id', Auth::user()->company_id)->first();
            $signatory->prepared_by      = $request->prepared_by;
            $signatory->checked_by       = $request->checked_by;
            $signatory->verified_by      = $request->verified_by;
            $signatory->authorized_by    = $request->authorized_by;
            $signatory->approved_by      = $request->approved_by;
            $signatory->save();
        }
        return redirect('signatory')->with('message','Signatory updated successfully!');
    }
}
