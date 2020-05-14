<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ChequeLayout;
use App\Bank;
use App\BankAccount;
use App\ChequeBook;
use App\Cheque;
use App\Printer;
use App\ChequeTransaction;
use App\Supplier;
use App\Setting;
use App\Currency;

class ChequeTransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
        $setting = Setting::where('id',1)->first();
        $cheque_transactions = ChequeTransaction::orderby('created_at','desc')->paginate(10);
        return view('cheque_transactions.index', ['cheque_transactions'=>$cheque_transactions, 'setting'=>$setting]);
    }
    public function add($bank_id = null,Request $request){
        if(roles() != "" && !in_array(40, json_decode(roles(),false))){
            return redirect('404');
        }
        if($request->amount !="" && $request->cheque_name != ""){
            $cheque_transaction = new ChequeTransaction();

            $cheque_transaction->bank_name      = Bank::where('id',$request->bank_name)->value('name');
            $cheque_transaction->ac_number      = BankAccount::where('id',$request->ac_number)->value('ac_number');
            $cheque_transaction->book_no        = ChequeBook::where('id',$request->book_no)->value('book_no');
            $cheque_transaction->cheque_no      = $request->cheque_no;
            $cheque_transaction->date           = date('Y-m-d',strtotime($request->date_field));
            $cheque_transaction->cheque_name    = $request->cheque_name;
            $cheque_transaction->amount         = $request->amount;
            $cheque_transaction->amount_in_word_line_1 = $request->amount_in_word_line_1_input;
            $cheque_transaction->amount_in_word_line_2 = $request->amount_in_word_line_2_input;

            if($request->ac_payee_only == 1) {
                $cheque_transaction->ac_payee_only       = 1;
            }else { $cheque_transaction->ac_payee_only   = 0; }
            
            $cheque_transaction->status         = 0;
            $cheque_transaction->save();

            $cheque = Cheque::where('cheque_no',$request->cheque_no)->first();
            $cheque->status = 1;
            $cheque->save();
            
            return redirect('cheque-transactions')->with('message', 'Cheque added successfully!');
        }
        $setting   = Setting::where('id',1)->first();
        $printers   = Printer::orderby('id','desc')->get();
        $banks      = Bank::orderby('name','asc')->get();
        $accounts   = [];
        $layout     = "";
        
        if($bank_id != "" && $bank_id != null) {
            $accounts = BankAccount::where('bank_id',$bank_id)->get();
            $layout = ChequeLayout::where('bank_id',$bank_id)->first();
        }

        $suppliers  = Supplier::orderby('name','asc')->get();
        return view('cheque_transactions.add', ['banks' => $banks, 'printers' => $printers, 'suppliers' => $suppliers, 'bank_id' => $bank_id, 'accounts' => $accounts, 'layout' => $layout, 'setting' => $setting]);
    }

    public function get_cheque_book_by_account($account_id){
        $books = ChequeBook::where('account_id',$account_id)->get();
        foreach($books as $book){
            echo '<option value="'.$book->id.'">'.$book->book_no.'</option>';
        }
    }

    public function get_cheques_by_book($book_id){
        $cheques = Cheque::where('cheque_book_id',$book_id)->where('status',0)->get();
        foreach($cheques as $cheque){
            echo '<option value="'.$cheque->cheque_no.'">'.$cheque->cheque_no.'</option>';
        }
    }

    public function get_currency_by_account($account_id){
        $account = BankAccount::where('id',$account_id)->first();
        $currency = Currency::where('id',$account->currency_id)->first();
        echo json_encode($currency);
    }

    public function approve($cheque_id){
        if(roles() != "" && !in_array(41, json_decode(roles(),false))){
            return redirect('404');
        }
        $transaction = ChequeTransaction::where('id',$cheque_id)->first();
        $transaction->status = 1;
        $transaction->save();
        echo "Ok";                
    }

    public function reject($cheque_id){
        if(roles() != "" && !in_array(42, json_decode(roles(),false))){
            return redirect('404');
        }
        $transaction = ChequeTransaction::where('id',$cheque_id)->first();
        $transaction->status = 2;
        $transaction->save();
        echo "Ok";                
    }

    public function void($cheque_id){
        if(roles() != "" && !in_array(43, json_decode(roles(),false))){
            return redirect('404');
        }
        $transaction = ChequeTransaction::where('id',$cheque_id)->first();
        $transaction->status = 3;
        $transaction->save();
        echo "Ok";                
    }

    public function print($cheque_id){
        if(roles() != "" && !in_array(44, json_decode(roles(),false))){
            return redirect('404');
        }
        $transaction = ChequeTransaction::where('id',$cheque_id)->first();
        $account = BankAccount::where('ac_number',$transaction->ac_number)->first();
        $layout = ChequeLayout::where('bank_id',$account->bank_id)->first();
        $setting = Setting::where('id',1)->first();
        $printer = Printer::where('id',$layout->printer_id)->first();

        if($transaction->status == 0 && $setting->approval_for_cheque == 1){
            $status = "pending";
        }
        if($transaction->status == 0 && $setting->approval_for_cheque == 0){
            $status = "approved";
        }
        if($transaction->status == 1){
            $status = "approved";
        }
        if($transaction->status == 2){
            $status = "rejected";
        }
        if($transaction->status == 3){
            $status = "void";
        }
        return view('cheque_transactions.print', ['transaction'=>$transaction, 'layout'=>$layout, 'status'=>$status, 'printer'=>$printer]);
    }

    public function draft($cheque_id){
        if(roles() != "" && !in_array(44, json_decode(roles(),false))){
            return redirect('404');
        }
        $transaction = ChequeTransaction::where('id',$cheque_id)->first();
        $account = BankAccount::where('ac_number',$transaction->ac_number)->first();
        $layout = ChequeLayout::where('bank_id',$account->bank_id)->first();
        $setting = Setting::where('id',1)->first();
        $printer = Printer::where('id',$layout->printer_id)->first();
        return view('cheque_transactions.draft', ['transaction'=>$transaction, 'layout'=>$layout, 'printer'=>$printer]);
    }
}
