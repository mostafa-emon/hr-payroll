<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ChequeBook;
use App\Cheque;
use App\Bank;
use App\BankAccount;
use DB;
use Auth;
use App\Helpers\ViewHelper;

class ChequeBookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
        $cheque_books = DB::table('cheque_books')
                        ->select('cheque_books.*','banks.name as bank_name','bank_accounts.ac_number as ac_number')
                        ->join('banks','banks.id','cheque_books.bank_id')
                        ->join('bank_accounts','bank_accounts.id','cheque_books.account_id')
                        ->where('cheque_books.company_id', Auth::user()->company_id)
                        ->paginate(10);
        return view('cheque_books.index', ['cheque_books'=>$cheque_books]);
    }

    public function add(Request $request){
        if(roles() != "" && !in_array(23, json_decode(roles(),false))){
            return redirect('404');
        }
        if($request->bank_id !=""){
            $cheque_book = new ChequeBook();
            $cheque_book->company_id       = Auth::user()->company_id;
            $cheque_book->bank_id          = $request->bank_id;
            $cheque_book->account_id       = $request->account_id;
            $cheque_book->book_no          = $request->book_no;
            $cheque_book->no_of_leaves     = $request->no_of_leaves;
            $cheque_book->starting_number  = $request->starting_number;
            $cheque_book->ending_number    = $request->ending_number;
            $cheque_book->save();

            for($i = $cheque_book->starting_number;$i<=$cheque_book->ending_number;$i++) {
                $cheque = new Cheque;
                $cheque->company_id     = Auth::user()->company_id;
                $cheque->cheque_book_id = $cheque_book->id;
                $cheque->cheque_no      = $i;
                $cheque->status         = 0;
                $cheque->save();
            }

            return redirect('cheque-books')->with('message', 'Cheque book added successfully!');
        }
        $banks      = Bank::where('company_id', Auth::user()->company_id)->orderBy('name', 'asc')->get();
        $accounts   = BankAccount::where('company_id', Auth::user()->company_id)->orderBy('id', 'asc')->get();
        return view('cheque_books.add', ['banks' => $banks, 'accounts' => $accounts]);
    }

    public function update($cheque_book_id,Request $request){
        if(roles() != "" && !in_array(24, json_decode(roles(),false))){
            return redirect('404');
        }
        if($request->bank_id !=""){
            $cheque_book = ChequeBook::where('id',$cheque_book_id)->first();
            $cheque_book->bank_id          = $request->bank_id;
            $cheque_book->account_id       = $request->account_id;
            $cheque_book->book_no          = $request->book_no;
            $cheque_book->no_of_leaves     = $request->no_of_leaves;
            $cheque_book->starting_number  = $request->starting_number;
            $cheque_book->ending_number    = $request->ending_number;
            $cheque_book->save();

            Cheque::where('cheque_book_id',$cheque_book_id)->delete();
            for($i = $cheque_book->starting_number;$i<=$cheque_book->ending_number;$i++) {
                $cheque = new Cheque;
                $cheque->cheque_book_id = $cheque_book->id;
                $cheque->cheque_no      = $i;
                $cheque->status         = 0;
                $cheque->save();
            }

            return redirect('cheque-books')->with('message', 'Cheque book updated successfully!');
        }

        $cheque_book = ChequeBook::where('id',$cheque_book_id)->first();
        $banks      = Bank::where('company_id', Auth::user()->company_id)->orderBy('name', 'asc')->get();
        $accounts   = BankAccount::where('bank_id',$cheque_book->bank_id)->orderBy('id', 'asc')->get();
        return view('cheque_books.update', ['cheque_book' => $cheque_book, 'banks' => $banks, 'accounts' => $accounts]);
    }

    public function delete($cheque_book_id){
        if(roles() != "" && !in_array(25, json_decode(roles(),false))){
            return redirect('404');
        }
        $cheque_book = ChequeBook::find($cheque_book_id);
        $cheque_book->delete();
        return redirect('cheque-books')->with('message', 'Cheque book deleted successfully!');
    }
}
