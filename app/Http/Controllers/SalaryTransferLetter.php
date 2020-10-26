<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SalaryTransferLetterFormat;
use Auth;

class SalaryTransferLetter extends Controller
{
    public function format(Request $request){
        $format = SalaryTransferLetterFormat::where('company_id',Auth::user()->company_id)->first();
        if($request->editor1 != "" || $request->editor2 != "") {

            $top_text = str_replace('<p>', '<div>', $request->editor1);
            $top_text = str_replace('</p>', '</div>', $top_text);

            $bottom_text = str_replace('<p>', '<div>', $request->editor2);
            $bottom_text = str_replace('</p>', '</div>', $bottom_text);

            if($format == "") {
                $letterFormat = new SalaryTransferLetterFormat();
                $letterFormat->company_id = Auth::user()->company_id;
                $letterFormat->top_text = $top_text;
                $letterFormat->bottom_text = $bottom_text;
                $letterFormat->save();
            }else{
                $format->company_id = Auth::user()->company_id;
                $format->top_text = $top_text;
                $format->bottom_text = $bottom_text;
                $format->save();
            }
            return redirect('salary-transfer-letter-format')->with('message','Format updated successfully!');
        }
        return view('payroll_setup.salary_transfer_letter.format',compact('format'));
    }
}
