<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\VoucherFormat;
use App\Setting;
use App\Company;
use Auth;

class VourcherFormatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
        $voucher_formats = VoucherFormat::where('company_id', Auth::user()->company_id)
        ->paginate(10);

        return view('voucher_formats.index', ['voucher_formats'=>$voucher_formats]);
    }

    public function add($type = null, Request $request){
        if(roles() != "" && !in_array(26, json_decode(roles(),false))){
            return redirect('404');
        }
        if($request->title !=""){
            $voucher_format = new VoucherFormat();
            $voucher_format->company_id             = Auth::user()->company_id;
            $voucher_format->title                  = $request->title;
            $voucher_format->type                   = $request->type;

            $voucher_format->qb_logo_top            = $request->qb_logo_top;
            $voucher_format->qb_logo_left           = $request->qb_logo_left;
            $voucher_format->voucher_no_top         = $request->voucher_no_top;
            $voucher_format->voucher_no_left        = $request->voucher_no_left;
            $voucher_format->voucher_date_top       = $request->voucher_date_top;
            $voucher_format->voucher_date_left      = $request->voucher_date_left;

            if($request->payee_name == 1) {
                $voucher_format->payee_name         = 1;
            }else { $voucher_format->payee_name     = 0; }
            
            $voucher_format->payee_name_top         = $request->payee_name_top;
            $voucher_format->payee_name_left        = $request->payee_name_left;

            if($request->cheque_no == 1) {
                $voucher_format->cheque_no          = 1;
            }else { $voucher_format->cheque_no      = 0; }
            
            $voucher_format->cheque_no_top          = $request->cheque_no_top;
            $voucher_format->cheque_no_left         = $request->cheque_no_left;

            if($request->cheque_date == 1) {
                $voucher_format->cheque_date        = 1;
            }else { $voucher_format->cheque_date    = 0; }
            
            $voucher_format->cheque_date_top        = $request->cheque_date_top;
            $voucher_format->cheque_date_left       = $request->cheque_date_left;

            if($request->received_from == 1) {
                $voucher_format->received_from      = 1;
            }else { $voucher_format->received_from  = 0; }
            
            $voucher_format->received_from_top      = $request->received_from_top;
            $voucher_format->received_from_left     = $request->received_from_left;

            if($request->account_code == 1) {
                $voucher_format->account_code       = 1;
            }else { $voucher_format->account_code   = 0; }

            if($request->customer_job == 1) {
                $voucher_format->customer_job       = 1;
            }else { $voucher_format->customer_job   = 0; }

            if($request->class == 1) {
                $voucher_format->class              = 1;
            }else { $voucher_format->class          = 0; }

            if($request->name == 1) {
                $voucher_format->name               = 1;
            }else { $voucher_format->name           = 0; }

            if($request->project == 1) {
                $voucher_format->project            = 1;
            }else { $voucher_format->project        = 0; }

            if($request->location == 1) {
                $voucher_format->location           = 1;
            }else { $voucher_format->location       = 0; }

            $voucher_format->table_top              = $request->table_top;
            $voucher_format->table_left             = $request->table_left;

            $voucher_format->signatory_top          = $request->signatory_top;
            
            $voucher_format->save();
            
            return redirect('voucher-formats')->with('message', 'Format added successfully!');
        }

        if($type != ""){
            $company = Company::where('id',Auth::user()->company_id)->first();
            $settings = Setting::where('company_id',Auth::user()->company_id)->first();
            $voucher_format = VoucherFormat::where('title', 'default')->where('type',$type)->where('company_id',null)->first();
            return view('voucher_formats.'.$type,['settings' => $settings, 'company' => $company, 'type' => $type, 'voucher_formats' => $voucher_format]);
        }else{
            return view('voucher_formats.type');
        }
        
    }
}
