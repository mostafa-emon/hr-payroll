<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MoneyReceipt;
use App\SiteOffice;
use App\Customer;
use App\Currency;
use App\PaymentMethod;
use App\Setting;
use App\Voucher;
use App\Company;
use Auth;
use Mail;

class MRController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
        $money_receipts = MoneyReceipt::where('company_id',Auth::user()->company_id)->paginate(10);
        $setting = Setting::where('company_id',Auth::user()->company_id)->first();
        return view('mr.index', ['money_receipts' => $money_receipts, 'setting' => $setting]);
    }

    public function create_mr(){
        return view('vouchers.create_mr');
    }

    public function create_cheque(){
        return view('vouchers.create_cheque');
    }

    public function sendmail(){
        $data["email"]  = 'mostafaemon.info@gmail.com';
        $data["client_name"] = 'Mostafa Mamun Emon';
        $data["subject"] = 'This is a test subject';

        try{
            Mail::send('mails.mail', $data, function($message)use($data) {
                $message->to($data["email"], $data["client_name"])->subject($data["subject"]);
            });
        }catch(JWTException $exception){
            $this->serverstatuscode = "0";
            $this->serverstatusdes = $exception->getMessage();
        }
        if (Mail::failures()) {
             $this->statusdesc  =   "Error sending mail";
             $this->statuscode  =   "0";

        }else{

           $this->statusdesc  =   "Message sent Succesfully";
           $this->statuscode  =   "1";
        }
    }
}
