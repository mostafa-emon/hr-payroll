<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\QuickBook;
use Auth;

class VoucherController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function cash_payment(){
        $qb = QuickBook::where('company_id',Auth::user()->company_id)->first();
        $token = $qb->token;
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://sandbox-quickbooks.api.intuit.com/v3/company/4620816365062880570/query?minorversion=14",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS =>"SELECT * FROM purchase WHERE AccountRef.value = '91'",
        CURLOPT_HTTPHEADER => array(
            "User-Agent: Token ".$qb->token,
            "Accept: application/json",
            "Content-Type: application/text",
            "Authorization: Bearer ".$qb->token,
            "Cookie: qboeuid=dd7e3fce.5a8116cd35a6f"
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
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
