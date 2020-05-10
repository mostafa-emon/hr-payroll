<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MoneyReceipt;
use App\Setting;

class ReportController extends Controller
{
    public function issued_mr() {
        $money_receipts = MoneyReceipt::all();
        $setting = Setting::where('id',1)->first();
        return view('reports.issued_mr', ['money_receipts' => $money_receipts, 'setting' => $setting]);
    }
}
