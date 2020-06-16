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
        $signatory = Signatory::where('company_id', Auth::user()->company_id)->orderBy('name', 'asc')->paginate(10);
        return view('signatories.index', ['signatories' => $signatory]);
    }

    public function add(Request $request){
        if($request->name !=""){
            $signatory = new Signatory();
            $signatory->company_id       = Auth::user()->company_id;
            $signatory->name             = $request->name;
            $signatory->save();
            return redirect('signatory')->with('message', 'Signatory added successfully!');
        }
        return view('signatories.add');
    }

    public function delete($signatory_id){
        $signatory = Signatory::find($signatory_id);
        $signatory->delete();
        return redirect('signatory')->with('message', 'Signatory deleted successfully!');
    }

    public function update($signatory_id, Request $request){
        if($request->name !=""){
            $signatory = Signatory::where('id', $signatory_id)->first();
            $signatory->company_id       = Auth::user()->company_id;
            $signatory->name             = $request->name;
            $signatory->save();
            return redirect('signatory')->with('message', 'Signatory updated successfully!');
        }
        $signatory = Signatory::where('id', $signatory_id)->first();
        return view('signatories.update', ['signatories' => $signatory]);
    }
}
