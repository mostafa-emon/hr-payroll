<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SalaryTransferLetterFormat;
use App\SalaryTransferLetter;
use App\SalaryTransferLetterDetail;
use App\EmploymentInfo;
use App\Department;
use App\Project;
use App\Branch;
use App\Currency;
use App\PayrollBank;
use App\SalarySheet;
use Auth;

class SalaryTransferLetterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
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

    public function transfer_letter() {
        $transfer_letters = SalaryTransferLetter::where('company_id',Auth::user()->company_id)->orderBy('id','desc')->paginate(10);
        return view('transactions.payroll.salary_transfer_letter.index',compact('transfer_letters'));
    }

    public function transfer_letter_create(Request $request) {
        
        $currency_id            = '';
        $bank_id                = '';
        $month                  = '';
        $formatted_month        = '';
        $formatted_year         = '';

        $salary_format          = SalaryTransferLetterFormat::where('company_id',Auth::user()->company_id)->first();

        $employment_infos       = EmploymentInfo::orderBy('employment_infos.id','asc')
                                ->select('employees.name','employees.employee_id as original_employee_id','employment_infos.employee_id','employment_infos.bank_name','salary_sheets.*','payroll_infos.currency_id')
                                ->join('payroll_infos','payroll_infos.employee_id','employment_infos.employee_id')
                                ->join('employees','employees.id','employment_infos.employee_id')
                                ->join('salary_sheets','salary_sheets.employee_id','employment_infos.employee_id')
                                ->where('employees.company_id',Auth::user()->company_id);


        $banks                  = PayrollBank::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $currencies             = Currency::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();

        if($request->currency_id != ""){
            $employment_infos   = $employment_infos->where('currency_id',$request->currency_id);
            $currency_id        = $request->currency_id;
        }

        if($request->bank_id != ""){
            $employment_infos   = $employment_infos->where('bank_name',$request->bank_id);
            $bank_id            = $request->bank_id;
        }

        if($request->month != ""){
            $formatted_month    = date('F', strtotime($request->month));
            $formatted_year     = date('Y', strtotime($request->month));
            $month              = $request->month;

            $employment_infos   = $employment_infos->where('month',$formatted_month);
            $employment_infos   = $employment_infos->where('year',$formatted_year);
            $employment_infos   = $employment_infos->get();
        }


        return view('transactions.payroll.salary_transfer_letter.add',compact('banks','currencies','month','currency_id','bank_id','employment_infos','salary_format','formatted_month','formatted_year'));
    }

    public function transfer_letter_store(Request $request){

        $transfer_letter                = new SalaryTransferLetter();
        $transfer_letter->company_id    = Auth::user()->company_id;
        $transfer_letter->month         = $request->store_month;
        $transfer_letter->year          = $request->store_year;
        $transfer_letter->currency_id   = $request->store_currency_id;
        $transfer_letter->bank_id       = $request->store_bank_id;
        $transfer_letter->save();

        $interval = count($request->employee_id);
        for($i = 0; $i < $interval; $i++) {

            $detail = new SalaryTransferLetterDetail();
            $detail->letter_id      = $transfer_letter->id;
            $detail->employee_id    = $request->employee_id[$i];
            $detail->salary_amount  = $request->salary_amount[$i];
            $detail->save();
        }

        $salary_format              = SalaryTransferLetterFormat::where('company_id',Auth::user()->company_id)->first();
        $employees                  = SalaryTransferLetterDetail::where('letter_id',$transfer_letter->id)->get();
        return view('transactions.payroll.salary_transfer_letter.print',compact('salary_format','employees'));
    }

    public function transfer_letter_details($letter_id) {
        $transfer_details = SalaryTransferLetterDetail::where('letter_id',$letter_id)->orderBy('id','asc')->paginate(10);
        return view('transactions.payroll.salary_transfer_letter.details',compact('transfer_details'));
    }

    public function transfer_letter_reprint($letter_id) {
        $salary_format              = SalaryTransferLetterFormat::where('company_id',Auth::user()->company_id)->first();
        $employees                  = SalaryTransferLetterDetail::where('letter_id',$letter_id)->get();
        return view('transactions.payroll.salary_transfer_letter.print',compact('salary_format','employees'));
    }
}
