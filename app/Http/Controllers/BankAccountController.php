<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BankAccount;
use App\Bank;
use App\Currency;
use DB;
use Auth;
use App\Helpers\ViewHelper;

class BankAccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
        $bank_account = BankAccount::select('bank_accounts.*','banks.name as bank_name','currencies.full_name as currency_name','currencies.fraction_name as currency_frname')
                    ->join('banks','banks.id','bank_accounts.bank_id')->orderBy('banks.name', 'asc')
                    ->join('currencies','currencies.id','bank_accounts.currency_id')->orderBy('currencies.full_name','asc')
                    ->paginate(10);
        return view('bank_accounts.index', ['bank_accounts'=>$bank_account]);
    }
    
    public function add(Request $request){
        if(roles() != "" && !in_array(20, json_decode(roles(),false))){
            return redirect('404');
        }
        if($request->ac_number !=""){
            $bank_account = new BankAccount();
            $bank_account->company_id       = Auth::user()->company_id;
            $bank_account->bank_id          = $request->bank_id;
            $bank_account->currency_id      = $request->currency_id;
            $bank_account->ac_number        = $request->ac_number;
            $bank_account->ac_type          = $request->ac_type;
            $bank_account->save();
            return redirect('bank-account')->with('message', 'Bank Account added successfully!');
        }
        $banks      = Bank::orderBy('name', 'asc')->get();
        $currencies = Currency::orderBy('full_name', 'asc')->get();
        return view('bank_accounts.add', ['banks' => $banks, 'currencies' => $currencies]);
    }

    public function delete($bank_account_id){
        if(roles() != "" && !in_array(22, json_decode(roles(),false))){
            return redirect('404');
        }
        $bank_account = BankAccount::find($bank_account_id);
        $bank_account->delete();
        return redirect('bank-account')->with('message', 'Bank Account deleted successfully!');
    }

    public function update($bank_account_id, Request $request){
        if(roles() != "" && !in_array(21, json_decode(roles(),false))){
            return redirect('404');
        }
        if($request->ac_number !=""){
            $bank_account = BankAccount::where('id',$bank_account_id)->first();
            $bank_account->bank_id          = $request->bank_id;
            $bank_account->currency_id      = $request->currency_id;
            $bank_account->ac_number        = $request->ac_number;
            $bank_account->ac_type          = $request->ac_type;
            $bank_account->save();
            return redirect('bank-account')->with('message', 'Bank Account updated successfully!');
        }
        $bank_accounts  = BankAccount::where('id',$bank_account_id)->first();
        $banks          = Bank::orderBy('name', 'asc')->get();
        $currencies     = Currency::orderBy('full_name', 'asc')->get();
        return view('bank_accounts.update', ['banks' => $banks, 'currencies' => $currencies,'bank_accounts' => $bank_accounts]);
    }

    public function get_account_by_bank($bank_id){
        $accounts = BankAccount::where('bank_id',$bank_id)->get();
        foreach($accounts as $account){
            echo '<option value="'.$account->id.'">'.$account->ac_number.'</option>';
        }
    }
}
