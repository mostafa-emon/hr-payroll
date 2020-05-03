<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ChequeBook;
use App\Cheque;
use App\Bank;
use App\BankAccount;

class ChequeBookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
        $cheque_books = ChequeBook::orderBy('id', 'asc')->get();
        return view('cheque_books.index', ['cheque_books'=>$cheque_books]);
    }

    public function add(Request $request){
        if($request->bank_id !=""){
            $cheque_book = new ChequeBook();
            $cheque_book->bank_id          = $request->bank_id;
            $cheque_book->account_id       = $request->account_id;
            $cheque_book->book_no          = $request->book_no;
            $cheque_book->no_of_leaves     = $request->no_of_leaves;
            $cheque_book->starting_number  = $request->starting_number;
            $cheque_book->ending_number    = $request->ending_number;
            $cheque_book->save();
            return redirect('cheque_books')->with('message', 'Cheque book added successfully!');
        }
        $banks      = Bank::orderBy('name', 'asc')->get();
        $accounts   = BankAccount::orderBy('id', 'asc')->get();
        return view('cheque_books.add', ['banks' => $banks, 'accounts' => $accounts]);
    }
}
