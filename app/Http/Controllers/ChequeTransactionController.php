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

class ChequeTransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
        $cheque_transactions = ChequeTransaction::orderby('created_at','desc')->paginate(10);
        return view('cheque_transactions.index', ['cheque_transactions'=>$cheque_transactions]);
    }
    public function add($bank_id = null,Request $request){
        if($request->height !=""){
            $cheque_layout = new ChequeLayout();

            $cheque_layout->bank_id                     = $request->bank_id;
            $cheque_layout->height                      = $request->height;
            $cheque_layout->width                       = $request->width;

            if($request->date == 1) {
                $cheque_layout->date                    = 1;
            }else { $cheque_layout->date                = 0; }
            $cheque_layout->date_top                    = $request->date_top;
            $cheque_layout->date_left                   = $request->date_left;

            if($request->payee == 1) {
                $cheque_layout->payee                   = 1;
            }else { $cheque_layout->payee               = 0; }
            $cheque_layout->payee_top                   = $request->payee_top;
            $cheque_layout->payee_left                  = $request->payee_left;

            if($request->amount == 1) {
                $cheque_layout->amount                  = 1;
            }else { $cheque_layout->amount              = 0; }
            $cheque_layout->amount_top                  = $request->amount_top;
            $cheque_layout->amount_left                 = $request->amount_left;

            if($request->amoamount_in_word_line_1 == 1) {
                $cheque_layout->amount_in_word_line_1       = 1;
            }else { $cheque_layout->amount_in_word_line_1   = 0; }
            $cheque_layout->amount_in_word_line_1           = $request->amount_in_word_line_1;
            $cheque_layout->amount_in_word_line_1_top       = $request->amount_in_word_line_1_top;
            $cheque_layout->amount_in_word_line_1_left      = $request->amount_in_word_line_1_left;
            
            if($request->amount_in_word_line_2 == 1) {
                $cheque_layout->amount_in_word_line_2       = 1;
            }else { $cheque_layout->amount_in_word_line_2   = 0; }
            $cheque_layout->amount_in_word_line_2_top       = $request->amount_in_word_line_2_top;
            $cheque_layout->amount_in_word_line_2_left      = $request->amount_in_word_line_2_left;
            
            if($request->ac_payee_only == 1) {
                $cheque_layout->ac_payee_only               = 1;
            }else { $cheque_layout->ac_payee_only           = 0; }
            $cheque_layout->ac_payee_only_top               = $request->ac_payee_only_top;
            $cheque_layout->ac_payee_only_left              = $request->ac_payee_only_left;

            $cheque_layout->save();

            return redirect('cheque-transactions')->with('message', 'Cheque added successfully!');
        }
        $setting   = Setting::where('id',1)->first();
        $printers   = Printer::orderby('id','desc')->get();
        $banks      = Bank::orderby('name','asc')->get();
        $accounts   = [];
        $layout = "";

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
            echo '<option value="'.$cheque->id.'">'.$cheque->cheque_no.'</option>';
        }
    }
}
