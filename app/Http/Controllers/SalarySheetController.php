<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\SalarySheet;
use App\SalarySheetDetails;

class SalarySheetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('transactions.payroll.salary_sheet.index');
    }

    public function add(Request $request){
        if($request->confirmation_check =="1") {
            return response()->json($request->religion);
        }
        return view('transactions.payroll.salary_sheet.create');
    }
}
