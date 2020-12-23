<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GeneralSetting;
use Auth;

class ConfigurationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function general_setting() {
        $settings = GeneralSetting::where('company_id',Auth::user()->company_id)->first();
        return view('configurations.general_settings',compact('settings'));
    }

    public function general_setting_update(Request $request) {
        $count = GeneralSetting::where('company_id',Auth::user()->company_id)->count();
        if($count == 0) {
            $setting = new GeneralSetting;
            $setting->company_id        = Auth::user()->company_id;
            $setting->amount_in_word    = $request->amount_in_word;
            $setting->date_format       = $request->date_format;
            $setting->save();
        }else{
            $setting = GeneralSetting::where('company_id', Auth::user()->company_id)->first();
            $setting->amount_in_word    = $request->amount_in_word;
            $setting->date_format       = $request->date_format;
            $setting->save();
        }
        return redirect('general-settings')->with('message','General Settings updated successfully!');
    }
}
