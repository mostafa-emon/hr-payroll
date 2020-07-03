<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Currency;
use App\Setting;
use App\Email;
use App\Printer;
use App\PaymentMethod;
use DB;
use Auth;
use App\Helpers\ViewHelper;
use App\Mail\SendMR;
use Illuminate\Support\Facades\Mail;
use PDF;
use Config;
use Redirect;
use Swift_SwiftException;

class ConfigurationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index_currency(){
        $currency = Currency::where('company_id', Auth::user()->company_id)->orderBy('id', 'asc')->paginate(10);
        return view('currencies.index', ['currencies'=>$currency]);
    }
    
    public function add_currency(Request $request){
        if(roles() != "" && !in_array(8, json_decode(roles(),false))){
            return redirect('404');
        }
        if($request->full_name !=""){
            $currency = new Currency();
            $currency->company_id       = Auth::user()->company_id;
            $currency->full_name        = $request->full_name;
            $currency->fraction_name    = $request->fraction_name;

            if($request->default == 1) {
                Currency::where('company_id',Auth::user()->company_id)->where('default', 1)->update(['default' => 0]);
                $currency->default      = 1; 
            }else { $currency->default  = 0; }

            $currency->save();
            return redirect('currency')->with('message', 'Currency added successfully!');
        }
        return view('currencies.add');
    }

    public function delete_currency($currency_id){
        if(roles() != "" && !in_array(10, json_decode(roles(),false))){
            return redirect('404');
        }
        $currency = Currency::find($currency_id);
        $currency->delete();
        return redirect('currency')->with('message', 'Currency deleted successfully!');
    }

    public function update_currency($currency_id, Request $request){
        if(roles() != "" && !in_array(9, json_decode(roles(),false))){
            return redirect('404');
        }
        if($request->full_name !=""){
            $currency = Currency::where('id',$currency_id)->first();
            $currency->full_name        = $request->full_name;
            $currency->fraction_name    = $request->fraction_name;
            if($request->default == 1) {
                Currency::where('company_id',Auth::user()->company_id)->where('default', 1)->update(['default' => 0]);
                $currency->default      = 1;
            }else { $currency->default  = 0; }
            $currency->save();
            return redirect('currency')->with('message', 'Currency updated successfully!');
        }
        $currencies = Currency::where('id',$currency_id)->first();
        return view('currencies.update', ['currencies' => $currencies]);
    }

    public function index_payment_method(){
        $payment_method = PaymentMethod::where('company_id', Auth::user()->company_id)->orderBy('id', 'asc')->paginate(10);
        return view('payment_methods.index', ['payment_methods'=>$payment_method]);
    }
    
    public function add_payment_method(Request $request){
        if(roles() != "" && !in_array(11, json_decode(roles(),false))){
            return redirect('404');
        }
        if($request->method_name !=""){
            $payment_method = new PaymentMethod();
            $payment_method->company_id          = Auth::user()->company_id;
            $payment_method->method_name         = $request->method_name;
            $payment_method->save();
            return redirect('payment-method')->with('message', 'Payment Method added successfully!');
        }
        return view('payment_methods.add');
    }

    public function delete_payment_method($payment_method_id){
        if(roles() != "" && !in_array(13, json_decode(roles(),false))){
            return redirect('404');
        }
        $payment_method = PaymentMethod::find($payment_method_id);
        $payment_method->delete();
        return redirect('payment-method')->with('message', 'Payment Method deleted successfully!');
    }

    public function update_payment_method($payment_method_id, Request $request){
        if(roles() != "" && !in_array(12, json_decode(roles(),false))){
            return redirect('404');
        }
        if($request->method_name !=""){
            $payment_method = PaymentMethod::where('id',$payment_method_id)->first();
            $payment_method->method_name        = $request->method_name;
            $payment_method->save();
            return redirect('payment-method')->with('message', 'Payment Method updated successfully!');
        }
        $payment_methods = PaymentMethod::where('id',$payment_method_id)->first();
        return view('payment_methods.update', ['payment_methods' => $payment_methods]);
    }

    public function index() {
        $settings = Setting::where('company_id', Auth::user()->company_id)->first();
        return view('settings.index', ['settings' => $settings]);
    }

    public function update(Request $request){
        if(roles() != "" && !in_array(88, json_decode(roles(),false))){
            return redirect('404');
        }
        $count = Setting::where('company_id',Auth::user()->company_id)->count();

        if($count == 0) {
            $setting = new Setting;
            $setting->company_id                            = Auth::user()->company_id;
            $setting->voucher_number                        = $request->voucher_number;
            $setting->voucher_size                          = $request->voucher_size;

            $setting->cash_payment_voucher_prefix           = $request->cash_payment_voucher_prefix;
            $setting->cash_payment_voucher_suffix           = $request->cash_payment_voucher_suffix;
            $setting->cash_payment_voucher_start_from       = $request->cash_payment_voucher_start_from;

            $setting->bank_payment_voucher_prefix           = $request->bank_payment_voucher_prefix;
            $setting->bank_payment_voucher_suffix           = $request->bank_payment_voucher_suffix;
            $setting->bank_payment_voucher_start_from       = $request->bank_payment_voucher_start_from;

            $setting->cash_receipt_voucher_prefix           = $request->cash_receipt_voucher_prefix;
            $setting->cash_receipt_voucher_suffix           = $request->cash_receipt_voucher_suffix;
            $setting->cash_receipt_voucher_start_from       = $request->cash_receipt_voucher_start_from;
            if($request->cash_receipt_voucher_sales_receipt == 1) {
                $setting->cash_receipt_voucher_sales_receipt       = 1;
            }else { $setting->cash_receipt_voucher_sales_receipt   = 0; }
            
            $setting->bank_receipt_voucher_prefix           = $request->bank_receipt_voucher_prefix;
            $setting->bank_receipt_voucher_suffix           = $request->bank_receipt_voucher_suffix;
            $setting->bank_receipt_voucher_start_from       = $request->bank_receipt_voucher_start_from;

            $setting->contra_voucher_prefix                 = $request->contra_voucher_prefix;
            $setting->contra_voucher_suffix                 = $request->contra_voucher_suffix;
            $setting->contra_voucher_start_from             = $request->contra_voucher_start_from;

            $setting->journal_voucher_prefix                = $request->journal_voucher_prefix;
            $setting->journal_voucher_suffix                = $request->journal_voucher_suffix;
            $setting->journal_voucher_start_from            = $request->journal_voucher_start_from;

            $setting->mr_number                             = $request->mr_number;

            $setting->mr_prefix                             = $request->mr_prefix;
            $setting->mr_suffix                             = $request->mr_suffix;
            $setting->mr_start_from                         = $request->mr_start_from;

            $setting->mr_size                               = $request->mr_size;

            $setting->amount_in_word_format                 = $request->amount_in_word_format;
            $setting->approval_for_mr                       = $request->approval_for_mr;
            $setting->approval_for_cheque                   = $request->approval_for_cheque;
            $setting->save();
        }else{
            $setting = Setting::where('company_id', Auth::user()->company_id)->first();
            $setting->voucher_number                        = $request->voucher_number;
            $setting->voucher_size                          = $request->voucher_size;

            $setting->cash_payment_voucher_prefix           = $request->cash_payment_voucher_prefix;
            $setting->cash_payment_voucher_suffix           = $request->cash_payment_voucher_suffix;
            $setting->cash_payment_voucher_start_from       = $request->cash_payment_voucher_start_from;

            $setting->bank_payment_voucher_prefix           = $request->bank_payment_voucher_prefix;
            $setting->bank_payment_voucher_suffix           = $request->bank_payment_voucher_suffix;
            $setting->bank_payment_voucher_start_from       = $request->bank_payment_voucher_start_from;

            $setting->cash_receipt_voucher_prefix           = $request->cash_receipt_voucher_prefix;
            $setting->cash_receipt_voucher_suffix           = $request->cash_receipt_voucher_suffix;
            $setting->cash_receipt_voucher_start_from       = $request->cash_receipt_voucher_start_from;
            if($request->cash_receipt_voucher_sales_receipt == 1) {
                $setting->cash_receipt_voucher_sales_receipt       = 1;
            }else { $setting->cash_receipt_voucher_sales_receipt   = 0; }
            
            $setting->bank_receipt_voucher_prefix           = $request->bank_receipt_voucher_prefix;
            $setting->bank_receipt_voucher_suffix           = $request->bank_receipt_voucher_suffix;
            $setting->bank_receipt_voucher_start_from       = $request->bank_receipt_voucher_start_from;

            $setting->contra_voucher_prefix                 = $request->contra_voucher_prefix;
            $setting->contra_voucher_suffix                 = $request->contra_voucher_suffix;
            $setting->contra_voucher_start_from             = $request->contra_voucher_start_from;

            $setting->journal_voucher_prefix                = $request->journal_voucher_prefix;
            $setting->journal_voucher_suffix                = $request->journal_voucher_suffix;
            $setting->journal_voucher_start_from            = $request->journal_voucher_start_from;

            $setting->mr_number                             = $request->mr_number;

            $setting->mr_prefix                             = $request->mr_prefix;
            $setting->mr_suffix                             = $request->mr_suffix;
            $setting->mr_start_from                         = $request->mr_start_from;

            $setting->mr_size                               = $request->mr_size;
            $setting->amount_in_word_format                 = $request->amount_in_word_format;
            $setting->approval_for_mr                       = $request->approval_for_mr;
            $setting->approval_for_cheque                   = $request->approval_for_cheque;
            $setting->save();
        }
        return redirect('settings')->with('message','Settings updated successfully!');
    }

    public function index_printer(){
        $printer = Printer::where('company_id', Auth::user()->company_id)->orderBy('id', 'asc')->paginate(10);
        return view('printers.index', ['printers'=>$printer]);
    }
    
    public function add_printer(Request $request){
        if(roles() != "" && !in_array(84, json_decode(roles(),false))){
            return redirect('404');
        }
        if($request->print_name !=""){
            $printer = new Printer();
            $printer->company_id        = Auth::user()->company_id;
            $printer->print_name        = $request->print_name;
            $printer->top               = $request->top;
            $printer->left              = $request->left;
            $printer->rotate            = $request->rotate;
            $printer->save();
            return redirect('printer')->with('message', 'Printer added successfully!');
        }
        return view('printers.add');
    }

    public function delete_printer($printer_id){
        if(roles() != "" && !in_array(86, json_decode(roles(),false))){
            return redirect('404');
        }
        $printer = Printer::find($printer_id);
        $printer->delete();
        return redirect('printer')->with('message', 'Printer deleted successfully!');
    }

    public function update_printer($printer_id, Request $request){
        if(roles() != "" && !in_array(85, json_decode(roles(),false))){
            return redirect('404');
        }
        if($request->print_name !=""){
            $printer = Printer::where('id',$printer_id)->first();
            $printer->print_name        = $request->print_name;
            $printer->top               = $request->top;
            $printer->left              = $request->left;
            $printer->rotate            = $request->rotate;
            $printer->save();
            return redirect('printer')->with('message', 'Printer updated successfully!');
        }
        $printers = Printer::where('id',$printer_id)->first();
        return view('printers.update', ['printers' => $printers]);
    }

    public function mail_setup(){
        $emails = Email::where('company_id', Auth::user()->company_id)->first();
        if($emails != "") {
            return view('settings.mail', ['emails' => $emails]);
        }else{
            return view('settings.mail');
        }
        
    }

    public function mail_setup_update(Request $request){

        if(roles() != "" && !in_array(87, json_decode(roles(),false))){
            return redirect('404');
        }
        
        if($request->job == "savesettings") {
            $count = Email::where('company_id',Auth::user()->company_id)->count();

            if($count == 0) {
                $email = new Email;
                $email->company_id                            = Auth::user()->company_id;
                $email->mail_driver                           = $request->mail_driver;
                $email->host_name                             = $request->host_name;
                $email->port_name                             = $request->port_name;
                $email->user_name                             = $request->user_name;
                $email->password                              = $request->password;
                if($request->encryption == ""){
                    if($request->port_name == "465") {
                        $email->encryption                    = "ssl";
                    }else {
                        $email->encryption                    = "tls";
                    }
                }else {
                    $email->encryption                        = $request->encryption;
                }
                $email->from_address                          = $request->user_name;
                $email->from_name                             = $request->from_name;
                $email->subject                               = $request->email_subject;
                $email->body                                  = $request->editor1;
                $email->save();
            }else{
                $email = Email::where('company_id', Auth::user()->company_id)->first();
                $email->mail_driver                           = $request->mail_driver;
                $email->host_name                             = $request->host_name;
                $email->port_name                             = $request->port_name;
                $email->user_name                             = $request->user_name;
                $email->password                              = $request->password;
                if($request->encryption == ""){
                    if($request->port_name == "465") {
                        $email->encryption                    = "ssl";
                    }else {
                        $email->encryption                    = "tls";
                    }
                }else {
                    $email->encryption                        = $request->encryption;
                }
                $email->from_address                          = $request->user_name;
                $email->from_name                             = $request->from_name;
                $email->subject                               = $request->email_subject;
                $email->body                                  = $request->editor1;
                $email->save();
            }
            return redirect('mail-setup')->with('message','Email settings updated!');
        }
        
        else {
            Config::set('mail.driver', $request->mail_driver);
            Config::set('mail.host', $request->host_name);
            Config::set('mail.port', $request->port_name);
            Config::set('mail.username', $request->user_name);
            Config::set('mail.password', $request->password);

            if($request->port_name == "465") {
                $encryption                    = "ssl";
            }else {
                $encryption                    = "tls";
            }

            Config::set('mail.encryption', $encryption);

            Config::set('mail.from.address', $request->user_name);
            Config::set('mail.from.name', $request->from_name);
            
            $data["email"] = $request->email_to;
            $data["client_name"] = '';
            $data["subject"] = $request->email_subject;
            $data["body"] = $request->editor1;

            if($request->send_as_attachment == 1) {
                $pdf = PDF::loadView('email.mr',compact('data'));
                try{
                    Mail::send('email.body', compact('data'), function($message)use($data,$pdf) {
                    $message->to($data["email"], $data["client_name"])
                        ->subject($data["subject"])
                        ->attachData($pdf->output(), "attachment.pdf");
                    });

                    $error      =   "";
                    $message    =   "Message sent Succesfully!";
                    $status     =   "1";
                }catch(Swift_SwiftException $Ste){
                    $this->serverstatuscode = "0";
                    $this->serverstatusdes = $Ste->getMessage();

                    $error      =   $Ste->getMessage();
                    $message    =   "Error sending mail!";
                    $status     =   "0";
                }
                return Redirect::back()->with('message',$message)->with('error',$error)->withInput();
            }else {
                try{
                    Mail::send('email.body', compact('data'), function($message)use($data) {
                    $message->to($data["email"], $data["client_name"])
                        ->subject($data["subject"]);
                    });

                    $error      =   "";
                    $message    =   "Message sent Succesfully!";
                    $status     =   "1";
                }catch(Swift_SwiftException $Ste){
                    $this->serverstatuscode = "0";
                    $this->serverstatusdes = $Ste->getMessage();

                    $error      =   $Ste->getMessage();
                    $message    =   "Error sending mail!";
                    $status     =   "0";
                }
                return Redirect::back()->with('message',$message)->with('error',$error)->withInput();
            }
        }
        
    }
}
