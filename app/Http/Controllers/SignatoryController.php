<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Signatory;
use Auth;

class SignatoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $signatory = Signatory::where('company_id', Auth::user()->company_id)->orderBy('name', 'asc')->paginate(10);
        return view('signatories.index', ['signatories' => $signatory]);
    }

    public function add(Request $request){
        if(roles() != "" && !in_array(2, json_decode(roles(),false))){
            return redirect('404');
        }
        if($request->name !=""){
            $signatory = new Signatory();
            $signatory->company_id              = Auth::user()->company_id;
            $signatory->name                    = $request->name;

            if($request->cash_payment_voucher == 1) {
                $signatory->cash_payment_voucher         = 1;
            }else { $signatory->cash_payment_voucher     = 0; }

            if($request->bank_payment_voucher == 1) {
                $signatory->bank_payment_voucher         = 1;
            }else { $signatory->bank_payment_voucher     = 0; }

            if($request->cash_receipt_voucher == 1) {
                $signatory->cash_receipt_voucher         = 1;
            }else { $signatory->cash_receipt_voucher     = 0; }

            if($request->bank_receipt_voucher == 1) {
                $signatory->bank_receipt_voucher         = 1;
            }else { $signatory->bank_receipt_voucher     = 0; }

            if($request->contra_voucher == 1) {
                $signatory->contra_voucher         = 1;
            }else { $signatory->contra_voucher     = 0; }

            if($request->contra_voucher == 1) {
                $signatory->contra_voucher         = 1;
            }else { $signatory->contra_voucher     = 0; }

            if($request->journal_voucher == 1) {
                $signatory->journal_voucher         = 1;
            }else { $signatory->journal_voucher     = 0; }

            $signatory->save();
            return redirect('signatory')->with('message', 'Signatory added successfully!');
        }
        return view('signatories.add');
    }

    public function delete($signatory_id){
        if(roles() != "" && !in_array(4, json_decode(roles(),false))){
            return redirect('404');
        }
        $signatory = Signatory::find($signatory_id);
        $signatory->delete();
        return redirect('signatory')->with('message', 'Signatory deleted successfully!');
    }

    public function update($signatory_id, Request $request){
        if(roles() != "" && !in_array(3, json_decode(roles(),false))){
            return redirect('404');
        }
        if($request->name !=""){
            $signatory = Signatory::where('id', $signatory_id)->first();
            $signatory->company_id       = Auth::user()->company_id;
            $signatory->name             = $request->name;

            if($request->cash_payment_voucher == 1) {
                $signatory->cash_payment_voucher         = 1;
            }else { $signatory->cash_payment_voucher     = 0; }

            if($request->bank_payment_voucher == 1) {
                $signatory->bank_payment_voucher         = 1;
            }else { $signatory->bank_payment_voucher     = 0; }

            if($request->cash_receipt_voucher == 1) {
                $signatory->cash_receipt_voucher         = 1;
            }else { $signatory->cash_receipt_voucher     = 0; }

            if($request->bank_receipt_voucher == 1) {
                $signatory->bank_receipt_voucher         = 1;
            }else { $signatory->bank_receipt_voucher     = 0; }

            if($request->contra_voucher == 1) {
                $signatory->contra_voucher         = 1;
            }else { $signatory->contra_voucher     = 0; }

            if($request->contra_voucher == 1) {
                $signatory->contra_voucher         = 1;
            }else { $signatory->contra_voucher     = 0; }

            if($request->journal_voucher == 1) {
                $signatory->journal_voucher         = 1;
            }else { $signatory->journal_voucher     = 0; }

            $signatory->save();
            return redirect('signatory')->with('message', 'Signatory updated successfully!');
        }
        $signatory = Signatory::where('id', $signatory_id)->first();
        return view('signatories.update', ['signatories' => $signatory]);
    }
}
