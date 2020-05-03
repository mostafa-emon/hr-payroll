<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BankAccount;
use App\Bank;
use App\Currency;
use Auth;

class BankAccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
        $bankaccount = BankAccount::select('bank_accounts.*','banks.name as bank_name','currencies.full_name as currency_name')
                  ->join('banks','banks.id','bank_accounts.bank_id')->orderBy('banks.name', 'asc')
                  ->join('currencies','currencies.id','bank_accounts.currency_id')->orderBy('currencies.full_name','asc')
                  ->paginate(10);
        return view('bankaccounts.index', ['bankaccounts'=>$bankaccount]);
    }
    
    public function add(Request $request){
        if($request->ac_number !=""){
            $bankaccount = new BankAccount();
            $bankaccount->bank_id          = $request->bank_id;
            $bankaccount->currency_id      = $request->currency_id;
            $bankaccount->ac_number        = $request->ac_number;
            $bankaccount->ac_type          = $request->ac_type;
            $bankaccount->save();
            return redirect('bank-account')->with('message', 'Bank Account added successfully!');
        }
        $banks  = Bank::orderBy('name', 'asc')->get();
        $currencies = Currency::orderBy('full_name', 'asc')->get();
        return view('bankaccounts.add', ['banks' => $banks, 'currencies' => $currencies]);
    }

    public function delete($bankaccount_id){
        $bankaccount = BankAccount::find($bankaccount_id);
        $bankaccount->delete();
        return redirect('bank-account')->with('message', 'Bank Account deleted successfully!');
    }

    public function update($bankaccount_id, Request $request){
        if($request->ac_number !=""){
            $bankaccount = BankAccount::where('id',$bankaccount_id)->first();
            $bankaccount->bank_id          = $request->bank_id;
            $bankaccount->currency_id      = $request->currency_id;
            $bankaccount->ac_number        = $request->ac_number;
            $bankaccount->ac_type          = $request->ac_type;
            $bankaccount->save();
            return redirect('bank-account')->with('message', 'Bank Account updated successfully!');
        }
        $bankaccounts = BankAccount::where('id',$bankaccount_id)->first();
        $banks  = Bank::orderBy('name', 'asc')->get();
        $currencies = Currency::orderBy('full_name', 'asc')->get();
        return view('bankaccounts.update', ['banks' => $banks, 'currencies' => $currencies,'bankaccounts' => $bankaccounts]);
    }
}
