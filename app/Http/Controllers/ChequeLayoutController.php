<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ChequeLayout;
use App\Bank;
use App\Printer;

class ChequeLayoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
        $cheque_layout = ChequeLayout::select('cheque_layouts.*','banks.name as bank_name')
        ->join('banks','banks.id','cheque_layouts.bank_id')
        ->paginate(10);

        return view('cheque_layouts.index', ['cheque_layouts'=>$cheque_layout]);
    }
    public function add(Request $request){
        if($request->height !=""){
            $cheque_layout = new ChequeLayout();

            $cheque_layout->bank_id                     = $request->bank_id;
            $cheque_layout->height                      = $request->height;
            $cheque_layout->width                       = $request->width;

            if($request->date == 1) {
                $cheque_layout->date                    = 1;
            }else { $cheque_layout->date                = 0; }
            $cheque_layout->date_top                    = $request->date_top;
            $cheque_layout->date_left                   = $request->date_left;
            $cheque_layout->date_format                 = $request->date_format;
            $cheque_layout->date_font_size              = $request->date_font_size;
            $cheque_layout->date_letter_spacing         = $request->date_letter_spacing;

            if($request->payee == 1) {
                $cheque_layout->payee                   = 1;
            }else { $cheque_layout->payee               = 0; }
            $cheque_layout->payee_top                   = $request->payee_top;
            $cheque_layout->payee_left                  = $request->payee_left;
            $cheque_layout->payee_font_size             = $request->payee_font_size;
            $cheque_layout->payee_letter_spacing        = $request->payee_letter_spacing;

            if($request->amount == 1) {
                $cheque_layout->amount                  = 1;
            }else { $cheque_layout->amount              = 0; }
            $cheque_layout->amount_top                  = $request->amount_top;
            $cheque_layout->amount_left                 = $request->amount_left;
            $cheque_layout->amount_font_size            = $request->amount_font_size;
            $cheque_layout->amount_letter_spacing       = $request->amount_letter_spacing;

            if($request->amoamount_in_word_line_1 == 1) {
                $cheque_layout->amount_in_word_line_1       = 1;
            }else { $cheque_layout->amount_in_word_line_1   = 0; }
            $cheque_layout->amount_in_word_line_1           = $request->amount_in_word_line_1;
            $cheque_layout->amount_in_word_line_1_top       = $request->amount_in_word_line_1_top;
            $cheque_layout->amount_in_word_line_1_left      = $request->amount_in_word_line_1_left;
            $cheque_layout->amount_in_word_max_character    = $request->amount_in_word_max_character;
            $cheque_layout->amount_in_word_font_size        = $request->amount_in_word_font_size;
            $cheque_layout->amount_in_word_letter_spacing   = $request->amount_in_word_letter_spacing;
            
            if($request->amount_in_word_line_2 == 1) {
                $cheque_layout->amount_in_word_line_2       = 1;
            }else { $cheque_layout->amount_in_word_line_2   = 0; }
            $cheque_layout->amount_in_word_line_2_top       = $request->amount_in_word_line_2_top;
            $cheque_layout->amount_in_word_line_2_left      = $request->amount_in_word_line_2_left;
            
            if($request->ac_payee_only == 1) {
                $cheque_layout->ac_payee_only               = 1;
            }else { $cheque_layout->ac_payee_only           = 0; }
            $cheque_layout->ac_payee_only_top               = $request->ac_payee_only_top;
            $cheque_layout->ac_payee_only_left              = $request->ac_payee_only_left;

            $cheque_layout->printer_setup                   = $request->printer_setup;
            $cheque_layout->save();

            return redirect('cheque-layouts')->with('message', 'Cheque Layout added successfully!');
        }
        $printers   = Printer::orderby('id','desc')->get();
        $banks      = Bank::orderby('name','asc')->get();
        return view('cheque_layouts.add', ['banks' => $banks, 'printers' => $printers]);
    }

    public function delete($cheque_layout_id){
        $cheque_layout = ChequeLayout::find($cheque_layout_id);
        $cheque_layout->delete();
        return redirect('cheque-layouts')->with('message', 'Cheque Layout deleted successfully!');
    }

    public function update($cheque_layout_id, Request $request){
        if($request->height !=""){
            $cheque_layout = ChequeLayout::where('id',$cheque_layout_id)->first();
            $cheque_layout->bank_id                     = $request->bank_id;
            $cheque_layout->height                      = $request->height;
            $cheque_layout->width                       = $request->width;

            if($request->date == 1) {
                $cheque_layout->date                    = 1;
            }else { $cheque_layout->date                = 0; }
            $cheque_layout->date_top                    = $request->date_top;
            $cheque_layout->date_left                   = $request->date_left;
            $cheque_layout->date_format                 = $request->date_format;
            $cheque_layout->date_font_size              = $request->date_font_size;
            $cheque_layout->date_letter_spacing         = $request->date_letter_spacing;

            if($request->payee == 1) {
                $cheque_layout->payee                   = 1;
            }else { $cheque_layout->payee               = 0; }
            $cheque_layout->payee_top                   = $request->payee_top;
            $cheque_layout->payee_left                  = $request->payee_left;
            $cheque_layout->payee_font_size             = $request->payee_font_size;
            $cheque_layout->payee_letter_spacing        = $request->payee_letter_spacing;

            if($request->amount == 1) {
                $cheque_layout->amount                  = 1;
            }else { $cheque_layout->amount              = 0; }
            $cheque_layout->amount_top                  = $request->amount_top;
            $cheque_layout->amount_left                 = $request->amount_left;
            $cheque_layout->amount_font_size            = $request->amount_font_size;
            $cheque_layout->amount_letter_spacing       = $request->amount_letter_spacing;

            if($request->amoamount_in_word_line_1 == 1) {
                $cheque_layout->amount_in_word_line_1       = 1;
            }else { $cheque_layout->amount_in_word_line_1   = 0; }
            $cheque_layout->amount_in_word_line_1           = $request->amount_in_word_line_1;
            $cheque_layout->amount_in_word_line_1_top       = $request->amount_in_word_line_1_top;
            $cheque_layout->amount_in_word_line_1_left      = $request->amount_in_word_line_1_left;
            $cheque_layout->amount_in_word_max_character    = $request->amount_in_word_max_character;
            $cheque_layout->amount_in_word_font_size        = $request->amount_in_word_font_size;
            $cheque_layout->amount_in_word_letter_spacing   = $request->amount_in_word_letter_spacing;
            
            if($request->amount_in_word_line_2 == 1) {
                $cheque_layout->amount_in_word_line_2       = 1;
            }else { $cheque_layout->amount_in_word_line_2   = 0; }
            $cheque_layout->amount_in_word_line_2_top       = $request->amount_in_word_line_2_top;
            $cheque_layout->amount_in_word_line_2_left      = $request->amount_in_word_line_2_left;
            
            if($request->ac_payee_only == 1) {
                $cheque_layout->ac_payee_only               = 1;
            }else { $cheque_layout->ac_payee_only           = 0; }
            $cheque_layout->ac_payee_only_top               = $request->ac_payee_only_top;
            $cheque_layout->ac_payee_only_left              = $request->ac_payee_only_left;
            
            $cheque_layout->printer_setup                   = $request->printer_setup;
            $cheque_layout->save();

            return redirect('cheque-layouts')->with('message', 'Cheque Layout updated successfully!');
        }
        $printers   = Printer::orderby('id','desc')->get();
        $layout = ChequeLayout::where('id',$cheque_layout_id)->first();
        $banks  = Bank::orderby('name','asc')->get();
        return view('cheque_layouts.update', ['banks' => $banks, 'layout' => $layout, 'printers' => $printers]);
    }

    public function duplicate($cheque_layout_id, Request $request){
        if($request->height !=""){
            $cheque_layout = new ChequeLayout();
            $cheque_layout->bank_id                     = $request->bank_id;
            $cheque_layout->height                      = $request->height;
            $cheque_layout->width                       = $request->width;

            if($request->date == 1) {
                $cheque_layout->date                    = 1;
            }else { $cheque_layout->date                = 0; }
            $cheque_layout->date_top                    = $request->date_top;
            $cheque_layout->date_left                   = $request->date_left;
            $cheque_layout->date_format                 = $request->date_format;
            $cheque_layout->date_font_size              = $request->date_font_size;
            $cheque_layout->date_letter_spacing         = $request->date_letter_spacing;

            if($request->payee == 1) {
                $cheque_layout->payee                   = 1;
            }else { $cheque_layout->payee               = 0; }
            $cheque_layout->payee_top                   = $request->payee_top;
            $cheque_layout->payee_left                  = $request->payee_left;
            $cheque_layout->payee_font_size             = $request->payee_font_size;
            $cheque_layout->payee_letter_spacing        = $request->payee_letter_spacing;

            if($request->amount == 1) {
                $cheque_layout->amount                  = 1;
            }else { $cheque_layout->amount              = 0; }
            $cheque_layout->amount_top                  = $request->amount_top;
            $cheque_layout->amount_left                 = $request->amount_left;
            $cheque_layout->amount_font_size            = $request->amount_font_size;
            $cheque_layout->amount_letter_spacing       = $request->amount_letter_spacing;

            if($request->amoamount_in_word_line_1 == 1) {
                $cheque_layout->amount_in_word_line_1       = 1;
            }else { $cheque_layout->amount_in_word_line_1   = 0; }
            $cheque_layout->amount_in_word_line_1           = $request->amount_in_word_line_1;
            $cheque_layout->amount_in_word_line_1_top       = $request->amount_in_word_line_1_top;
            $cheque_layout->amount_in_word_line_1_left      = $request->amount_in_word_line_1_left;
            $cheque_layout->amount_in_word_max_character    = $request->amount_in_word_max_character;
            $cheque_layout->amount_in_word_font_size        = $request->amount_in_word_font_size;
            $cheque_layout->amount_in_word_letter_spacing   = $request->amount_in_word_letter_spacing;
            
            if($request->amount_in_word_line_2 == 1) {
                $cheque_layout->amount_in_word_line_2       = 1;
            }else { $cheque_layout->amount_in_word_line_2   = 0; }
            $cheque_layout->amount_in_word_line_2_top       = $request->amount_in_word_line_2_top;
            $cheque_layout->amount_in_word_line_2_left      = $request->amount_in_word_line_2_left;
            
            if($request->ac_payee_only == 1) {
                $cheque_layout->ac_payee_only               = 1;
            }else { $cheque_layout->ac_payee_only           = 0; }
            $cheque_layout->ac_payee_only_top               = $request->ac_payee_only_top;
            $cheque_layout->ac_payee_only_left              = $request->ac_payee_only_left;
            
            $cheque_layout->printer_setup                   = $request->printer_setup;
            $cheque_layout->save();

            return redirect('cheque-layouts')->with('message', 'Cheque Layout duplicated successfully!');
        }
        $printers   = Printer::orderby('id','desc')->get();
        $layout = ChequeLayout::where('id',$cheque_layout_id)->first();
        $banks  = Bank::orderby('name','asc')->get();
        return view('cheque_layouts.duplicate', ['banks' => $banks, 'layout' => $layout, 'printers' => $printers]);
    }
}
