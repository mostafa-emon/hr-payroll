<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bank;
use Auth;

class BankController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
        $bank = Bank::orderBy('name', 'asc')->get();
        return view('banks.index', ['banks'=>$bank]);
    }
    
    public function add(Request $request){
        if($request->name !=""){
            $bank = new Bank();
            $bank->name             = $request->name;
            $bank->address          = $request->address;
            $bank->phone            = $request->phone;
            $bank->email            = $request->email;
            $bank->contact_person   = $request->contact_person;
            $bank->save();
            return redirect('bank')->with('message', 'Bank added successfully!');
        }
        return view('banks.add');
    }

    public function delete($bank_id){
        $bank = Bank::find($bank_id);
        $bank->delete();
        return redirect('bank')->with('message', 'Bank deleted successfully!');
    }

    public function update($bank_id, Request $request){
        if($request->name !=""){
            $bank = Bank::where('id',$bank_id)->first();
            $bank->name             = $request->name;
            $bank->address          = $request->address;
            $bank->phone            = $request->phone;
            $bank->email            = $request->email;
            $bank->contact_person   = $request->contact_person;
            $bank->save();
            return redirect('bank')->with('message', 'Bank updated successfully!');
        }
        $banks = Bank::where('id',$bank_id)->first();
        return view('banks.update', ['banks' => $banks]);
    }
}
