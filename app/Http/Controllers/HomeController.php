<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Bank;
use App\BankAccount;
use App\ChequeBook;
use App\Cheque;
use App\User;
use App\Customer;
use App\Supplier;
use App\Company;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $total_bank         = Bank::where('company_id',Auth::user()->company_id)->count();
        $total_account      = BankAccount::where('company_id',Auth::user()->company_id)->count();
        $total_cheque_book  = ChequeBook::where('company_id',Auth::user()->company_id)->count();
        $total_cheque       = Cheque::where('company_id',Auth::user()->company_id)->count();
        $total_customer     = Customer::where('company_id',Auth::user()->company_id)->count();
        $total_supplier     = Supplier::where('company_id',Auth::user()->company_id)->count();
        $total_user         = User::where('company_id',Auth::user()->company_id)->count();

        $total_company      = Company::count();
        $pending_company    = Company::where('status',0)->count();
        $active_company     = Company::where('status',1)->where('subscription_end_date','>=',date('Y-m-d'))->count();
        $expired_company    = Company::where('subscription_end_date','<',date('Y-m-d'))->count();

        return view('welcome', [
            'total_bank'        => $total_bank,
            'total_account'     => $total_account,
            'total_cheque_book' => $total_cheque_book,
            'total_cheque'      => $total_cheque,
            'total_customer'    => $total_customer,
            'total_supplier'    => $total_supplier,
            'total_user'        => $total_user,

            'total_company'     => $total_company,
            'pending_company'   => $pending_company,
            'active_company'    => $active_company,
            'expired_company'   => $expired_company
        ]);
    }
    
    public function pageNotFound(){
        return view('404');
    }

    public function logout(){
        Auth::logout();
        return redirect('login');
    }
}
