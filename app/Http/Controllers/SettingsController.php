<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;

class SettingsController extends Controller
{
    public function index() {
        $settings = Setting::where('id',1)->first();
        return view('settings.index', ['settings' => $settings]);
    }

    public function update(Request $request){
        $count = Setting::where('id',1)->count();

        if($count == 0) {
            $setting = new Setting;
            $setting->mr_number                 = $request->mr_number;
            $setting->mr_size                   = $request->mr_size;
            $setting->amount_in_word_format     = $request->amount_in_word_format;
            $setting->approval_for_mr           = $request->approval_for_mr;
            $setting->approval_for_cheque       = $request->approval_for_cheque;
            $setting->save();
        }else{
            $setting = Setting::where('id',1)->first();
            $setting->mr_number                 = $request->mr_number;
            $setting->mr_size                   = $request->mr_size;
            $setting->amount_in_word_format     = $request->amount_in_word_format;
            $setting->approval_for_mr           = $request->approval_for_mr;
            $setting->approval_for_cheque       = $request->approval_for_cheque;
            $setting->save();
        }
        return redirect('settings')->with('message','Settings updated successfully!');
    }
}
