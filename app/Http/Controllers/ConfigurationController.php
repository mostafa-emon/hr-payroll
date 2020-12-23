<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GeneralSetting;
use App\SmsSetting;
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

    //SMS Setting

    public function sms_index(){
        $settings = SmsSetting::where('company_id', Auth::user()->company_id)->paginate(10);
        return view('configurations.sms_settings.index', compact('settings'));
    }

    public function sms_settings_add(){
        return view('configurations.sms_settings.add');
    }

    public function sms_settings_delete($id) {
        $settings = SmsSetting::find($id);
        $settings->delete();
        return redirect('sms-settings')->with('message','SMS Setting deleted successfully!');
    }

    public function sms_settings_update($id){
        $settings = SmsSetting::where('id',$id)->first();
        return view('configurations.sms_settings.update',compact('settings'));
    }

    public function sms_settings_submit(Request $request){
        if($request->job == "save_settings") {
            $setting = new SmsSetting;
            if(substr($request->sms_api_url, -1) == "?") {
                $setting->sms_api_url           = $request->sms_api_url;
            }else {
                $setting->sms_api_url           = $request->sms_api_url.'?';
            }
            
            $setting->company_id                = Auth::user()->company_id;
            $setting->send_to_parameter_name    = $request->send_to_parameter_name;
            $setting->sms_body_parameter_name   = $request->sms_body_parameter_name;
            $setting->request_method            = "GET";

            $setting->parameter_1_key           = $request->parameter_1_key;
            $setting->parameter_1_value         = $request->parameter_1_value;

            $setting->parameter_2_key           = $request->parameter_2_key;
            $setting->parameter_2_value         = $request->parameter_2_value;

            $setting->parameter_3_key           = $request->parameter_3_key;
            $setting->parameter_3_value         = $request->parameter_3_value;

            $setting->parameter_4_key           = $request->parameter_4_key;
            $setting->parameter_4_value         = $request->parameter_4_value;

            $setting->parameter_5_key           = $request->parameter_5_key;
            $setting->parameter_5_value         = $request->parameter_5_value;

            $setting->parameter_6_key           = $request->parameter_6_key;
            $setting->parameter_6_value         = $request->parameter_6_value;

            $setting->parameter_7_key           = $request->parameter_7_key;
            $setting->parameter_7_value         = $request->parameter_7_value;

            $setting->parameter_8_key           = $request->parameter_8_key;
            $setting->parameter_8_value         = $request->parameter_8_value;

            
            $setting->parameter_9_key           = $request->parameter_9_key;
            $setting->parameter_9_value         = $request->parameter_9_value;

            $setting->parameter_10_key          = $request->parameter_10_key;
            $setting->parameter_10_value        = $request->parameter_10_value;

            $setting->title                     = $request->settings_title;
            $setting->save();
            return redirect('sms-settings')->with('message','SMS Settings saved successfully!');
        }
        else if($request->job == "update_settings") {
            $setting = SmsSetting::where('id',$request->sms_settings_id)->first();

            if(substr($request->sms_api_url, -1) == "?") {
                $setting->sms_api_url               = $request->sms_api_url;
            }else {
                $setting->sms_api_url               = $request->sms_api_url.'?';
            }
            $setting->send_to_parameter_name    = $request->send_to_parameter_name;
            $setting->sms_body_parameter_name   = $request->sms_body_parameter_name;
            $setting->request_method            = "GET";

            $setting->parameter_1_key           = $request->parameter_1_key;
            $setting->parameter_1_value         = $request->parameter_1_value;

            $setting->parameter_2_key           = $request->parameter_2_key;
            $setting->parameter_2_value         = $request->parameter_2_value;

            $setting->parameter_3_key           = $request->parameter_3_key;
            $setting->parameter_3_value         = $request->parameter_3_value;

            $setting->parameter_4_key           = $request->parameter_4_key;
            $setting->parameter_4_value         = $request->parameter_4_value;

            $setting->parameter_5_key           = $request->parameter_5_key;
            $setting->parameter_5_value         = $request->parameter_5_value;

            $setting->parameter_6_key           = $request->parameter_6_key;
            $setting->parameter_6_value         = $request->parameter_6_value;

            $setting->parameter_7_key           = $request->parameter_7_key;
            $setting->parameter_7_value         = $request->parameter_7_value;

            $setting->parameter_8_key           = $request->parameter_8_key;
            $setting->parameter_8_value         = $request->parameter_8_value;

            
            $setting->parameter_9_key           = $request->parameter_9_key;
            $setting->parameter_9_value         = $request->parameter_9_value;

            $setting->parameter_10_key          = $request->parameter_10_key;
            $setting->parameter_10_value        = $request->parameter_10_value;

            $setting->title                     = $request->settings_title;
            $setting->save();
            return redirect('sms-settings')->with('message','SMS Settings updated successfully!');
        }
        else if($request->job == "send_test_sms") {
            $parameter = "";
            if($request->parameter_1_key != "") {
                if($request->sms_body_parameter_name == "parameter_1") {
                    $parameter = $parameter.$request->parameter_1_key.'='.urlencode($request->parameter_1_value);
                }else{
                    $parameter = $parameter.$request->parameter_1_key.'='.$request->parameter_1_value;
                }
            }
            if($request->parameter_2_key != "") {
                if($request->sms_body_parameter_name == "parameter_2") {
                    $parameter = $parameter.'&'.$request->parameter_2_key.'='.urlencode($request->parameter_2_value);
                }else{
                    $parameter = $parameter.'&'.$request->parameter_2_key.'='.$request->parameter_2_value;
                }
            }
            if($request->parameter_3_key != "") {
                if($request->sms_body_parameter_name == "parameter_3") {
                    $parameter = $parameter.'&'.$request->parameter_3_key.'='.urlencode($request->parameter_3_value);
                }else{
                    $parameter = $parameter.'&'.$request->parameter_3_key.'='.$request->parameter_3_value;
                }
            }
            if($request->parameter_4_key != "") {
                if($request->sms_body_parameter_name == "parameter_4") {
                    $parameter = $parameter.'&'.$request->parameter_4_key.'='.urlencode($request->parameter_4_value);
                }else{
                    $parameter = $parameter.'&'.$request->parameter_4_key.'='.$request->parameter_4_value;
                }
            }
            if($request->parameter_5_key != "") {
                if($request->sms_body_parameter_name == "parameter_5") {
                    $parameter = $parameter.'&'.$request->parameter_5_key.'='.urlencode($request->parameter_5_value);
                }else{
                    $parameter = $parameter.'&'.$request->parameter_5_key.'='.$request->parameter_5_value;
                }
            }
            if($request->parameter_6_key != "") {
                if($request->sms_body_parameter_name == "parameter_6") {
                    $parameter = $parameter.'&'.$request->parameter_6_key.'='.urlencode($request->parameter_6_value);
                }else{
                    $parameter = $parameter.'&'.$request->parameter_6_key.'='.$request->parameter_6_value;
                }
            }
            if($request->parameter_7_key != "") {
                if($request->sms_body_parameter_name == "parameter_7") {
                    $parameter = $parameter.'&'.$request->parameter_7_key.'='.urlencode($request->parameter_7_value);
                }else{
                    $parameter = $parameter.'&'.$request->parameter_7_key.'='.$request->parameter_7_value;
                }
            }
            if($request->parameter_8_key != "") {
                if($request->sms_body_parameter_name == "parameter_8") {
                    $parameter = $parameter.'&'.$request->parameter_8_key.'='.urlencode($request->parameter_8_value);
                }else{
                    $parameter = $parameter.'&'.$request->parameter_8_key.'='.$request->parameter_8_value;
                }
            }
            if($request->parameter_9_key != "") {
                if($request->sms_body_parameter_name == "parameter_9") {
                    $parameter = $parameter.'&'.$request->parameter_9_key.'='.urlencode($request->parameter_9_value);
                }else{
                    $parameter = $parameter.'&'.$request->parameter_9_key.'='.$request->parameter_9_value;
                }
            }
            if($request->parameter_10_key != "") {
                if($request->sms_body_parameter_name == "parameter_10") {
                    $parameter = $parameter.'&'.$request->parameter_10_key.'='.urlencode($request->parameter_10_value);
                }else{
                    $parameter = $parameter.'&'.$request->parameter_10_key.'='.$request->parameter_10_value;
                }
            }

            if(substr($request->sms_api_url, -1) == "?") {
                $api_url = $request->sms_api_url;
            }else {
                $api_url = $request->sms_api_url.'?';
            }

            $url = $api_url.$parameter;
            
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $curl_exec = curl_exec($curl);
            curl_close($curl);
            
            return Redirect::back()->withInput();
        }
    }

    public function sms_balance(){
        $settings = SmsSetting::where('company_id',Auth::user()->company_id)->paginate(10);
        return view('configurations.sms_balance.index', compact('settings'));
    }

    public function sms_balance_update(Request $request,$setup_id){
        if($request->sms_balance !=""){
            $sms_setup = SmsSetting::where('id',$setup_id)->first();
            $sms_setup->sms_balance         = $request->sms_balance;
            $sms_setup->eng_character_1     = $request->eng_character_1;

            if($request->eng_character_2 !=""){
                $sms_setup->eng_character_2     = $request->eng_character_2;
            }else{
                $sms_setup->eng_character_2     = $request->eng_character_1 * 2;
            }
            if($request->eng_character_3 !=""){
                $sms_setup->eng_character_3     = $request->eng_character_3;
            }else{
                $sms_setup->eng_character_3     = $request->eng_character_1 * 3;
            }
            if($request->eng_character_4 !=""){
                $sms_setup->eng_character_4     = $request->eng_character_4;
            }else{
                $sms_setup->eng_character_4     = $request->eng_character_1 * 4;
            }
            if($request->eng_character_5 !=""){
                $sms_setup->eng_character_5     = $request->eng_character_5;
            }else{
                $sms_setup->eng_character_5     = $request->eng_character_1 * 5;
            }

            $sms_setup->other_character_1   = $request->other_character_1;

            if($request->other_character_2 !=""){
                $sms_setup->other_character_2     = $request->other_character_2;
            }else{
                $sms_setup->other_character_2     = $request->other_character_1 * 2;
            }
            if($request->other_character_3 !=""){
                $sms_setup->other_character_3     = $request->other_character_3;
            }else{
                $sms_setup->other_character_3     = $request->other_character_1 * 3;
            }
            if($request->other_character_4 !=""){
                $sms_setup->other_character_4     = $request->other_character_4;
            }else{
                $sms_setup->other_character_4     = $request->other_character_1 * 4;
            }
            if($request->other_character_5 !=""){
                $sms_setup->other_character_5     = $request->other_character_5;
            }else{
                $sms_setup->other_character_5     = $request->other_character_1 * 5;
            }

            $sms_setup->save();
            return redirect('sms-balance')->with('message','Updated successfully!');
        }
        $sms_setup = SmsSetting::where('id',$setup_id)->first();
        return view('configurations.sms_balance.update',compact('sms_setup'));
    }
}
