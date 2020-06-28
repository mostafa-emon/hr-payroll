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
use App\Mail\SendMR;
use Illuminate\Support\Facades\Mail;
use PDF;
use Config;

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
        
        /*
        Config::set('mail.driver', 'smtp');
        Config::set('mail.host', 'smtp.gmail.com');
        Config::set('mail.port', '587');
        Config::set('mail.username', 'mostafa.shopinvento@gmail.com');
        Config::set('mail.password', 'A1c3E5g7');
        Config::set('mail.encryption', 'tls');

        Config::set('mail.from.address', 'mostafa.shopinvento@gmail.com');
        Config::set('mail.from.name', 'ShopMamun');
        */
        
        $data["email"] ='mostafaemon.info@gmail.com';
        $data["client_name"]='Mostafa Emon';
        $data["subject"]='This is test email';

        $pdf = PDF::loadView('email.mr', $data);

        try{
            Mail::send('email.mr', $data, function($message)use($data,$pdf) {
            $message->to($data["email"], $data["client_name"])
                ->subject($data["subject"])
                ->attachData($pdf->output(), "invoice.pdf");
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
        return response()->json(compact('this'));
    }
}
