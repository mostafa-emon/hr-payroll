<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Bank;
use App\BankAccount;
use App\ChequeBook;
use App\Cheque;
use App\User;
use App\SiteOffice;
use App\Customer;
use App\Supplier;

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
        $total_bank         = Bank::count();
        $total_account      = BankAccount::count();
        $total_cheque_book  = ChequeBook::count();
        $total_cheque       = Cheque::count();
        $total_site_office  = SiteOffice::count();
        $total_customer     = Customer::count();
        $total_supplier     = Supplier::count();
        $total_user         = User::count();
        return view('welcome', [
            'total_bank'        => $total_bank,
            'total_account'     => $total_account,
            'total_cheque_book' => $total_cheque_book,
            'total_cheque'      => $total_cheque,
            'total_site_office' => $total_site_office,
            'total_customer'    => $total_customer,
            'total_supplier'    => $total_supplier,
            'total_user'        => $total_user
        ]);
    }
    
    public function logout(){
        Auth::logout();
        return redirect('login');
    }
}
