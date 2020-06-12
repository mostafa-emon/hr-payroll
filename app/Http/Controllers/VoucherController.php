<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function cash_payment(){
        return view('vouchers.cash_payment');
    }
    
    public function bank_payment(){
        return view('vouchers.bank_payment');
    }

    public function cash_receipt(){
        return view('vouchers.cash_receipt');
    }

    public function bank_receipt(){
        return view('vouchers.bank_receipt');
    }

    public function void_voucher(){
        return view('vouchers.void');
    }

    public function contra_voucher(){
        return view('vouchers.contra');
    }

    public function journal_voucher(){
        return view('vouchers.journal');
    }
}
