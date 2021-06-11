<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GeneralSetting;
use App\SmsSetting;
use App\TaxRule;
use App\Email;
use PDF;
use Auth;
use Redirect;
use Config;
use Swift_SwiftException;
use Illuminate\Support\Facades\Mail;

class ConfigurationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function general_setting() {
        if(roles() != "" && !in_array(40, json_decode(roles(),false))){
            return redirect('404');
        }
        $settings = GeneralSetting::where('company_id',Auth::user()->company_id)->first();
        return view('configurations.general_settings',compact('settings'));
    }

    public function general_setting_update(Request $request) {
        $count = GeneralSetting::where('company_id',Auth::user()->company_id)->count();
        if($request->tax_chalan_code !=""){
            $length = strlen($request->tax_chalan_code);
            if($length != 13) {
                return redirect('general-settings')->with('error','Tax Challan Code Cannot More or Less than 13!');
            }
        }
        if($count == 0) {
            $setting = new GeneralSetting;
            $setting->company_id        = Auth::user()->company_id;
            $setting->amount_in_word    = $request->amount_in_word;
            $setting->date_format       = $request->date_format;
            $setting->tax_chalan_code   = $request->tax_chalan_code;
            if($request->provident_fund_registered == 1) 
            { $setting->provident_fund_registered = 1; }
            else{ $setting->provident_fund_registered = 0;}
            $setting->save();
        }else{
            $setting = GeneralSetting::where('company_id', Auth::user()->company_id)->first();
            $setting->amount_in_word    = $request->amount_in_word;
            $setting->date_format       = $request->date_format;
            $setting->tax_chalan_code   = $request->tax_chalan_code;
            if($request->provident_fund_registered == 1) 
            { $setting->provident_fund_registered = 1; }
            else{ $setting->provident_fund_registered = 0;}
            $setting->save();
        }
        return redirect('general-settings')->with('message','General Settings updated successfully!');
    }

    //SMS Setting

    public function sms_index(){
        if(roles() != "" && !in_array(41, json_decode(roles(),false))){
            return redirect('404');
        }
        $settings = SmsSetting::where('company_id', Auth::user()->company_id)->paginate(10);
        return view('configurations.sms_settings.index', compact('settings'));
    }

    public function sms_settings_add(){
        if(roles() != "" && !in_array(42, json_decode(roles(),false))){
            return redirect('404');
        }
        return view('configurations.sms_settings.add');
    }

    public function sms_settings_delete($id) {
        if(roles() != "" && !in_array(44, json_decode(roles(),false))){
            return redirect('404');
        }
        $settings = SmsSetting::find($id);
        $settings->delete();
        return redirect('sms-settings')->with('message','SMS Setting deleted successfully!');
    }

    public function sms_settings_update($id){
        if(roles() != "" && !in_array(43, json_decode(roles(),false))){
            return redirect('404');
        }
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
        if(roles() != "" && !in_array(45, json_decode(roles(),false))){
            return redirect('404');
        }
        $settings = SmsSetting::where('company_id',Auth::user()->company_id)->paginate(10);
        return view('configurations.sms_balance.index', compact('settings'));
    }

    public function sms_balance_update(Request $request,$setup_id){
        if(roles() != "" && !in_array(46, json_decode(roles(),false))){
            return redirect('404');
        }
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

    //Mail Setup

    public function mail_setup(){
        $emails = Email::where('company_id', Auth::user()->company_id)->first();
        if($emails != "") {
            return view('configurations.email.mail_setup', ['emails' => $emails]);
        }else{
            return view('configurations.email.mail_setup');
        }
    }

    public function mail_setup_update(Request $request){
        
        if($request->job == "savesettings") {
            $count = Email::where('company_id',Auth::user()->company_id)->count();

            if($count == 0) {
                $email = new Email;
                $email->company_id                            = Auth::user()->company_id;
                $email->mail_driver                           = $request->mail_driver;
                $email->host_name                             = $request->host_name;
                $email->port_name                             = $request->port_name;
                $email->user_name                             = $request->user_name;
                $email->password                              = $request->password;
                if($request->encryption == ""){
                    if($request->port_name == "465") {
                        $email->encryption                    = "ssl";
                    }else {
                        $email->encryption                    = "tls";
                    }
                }else {
                    $email->encryption                        = $request->encryption;
                }
                $email->from_address                          = $request->user_name;
                $email->from_name                             = $request->from_name;
                $email->subject                               = $request->email_subject;
                $email->body                                  = $request->editor1;
                $email->save();
            }else{
                $email = Email::where('company_id', Auth::user()->company_id)->first();
                $email->mail_driver                           = $request->mail_driver;
                $email->host_name                             = $request->host_name;
                $email->port_name                             = $request->port_name;
                $email->user_name                             = $request->user_name;
                $email->password                              = $request->password;
                if($request->encryption == ""){
                    if($request->port_name == "465") {
                        $email->encryption                    = "ssl";
                    }else {
                        $email->encryption                    = "tls";
                    }
                }else {
                    $email->encryption                        = $request->encryption;
                }
                $email->from_address                          = $request->user_name;
                $email->from_name                             = $request->from_name;
                $email->subject                               = $request->email_subject;
                $email->body                                  = $request->editor1;
                $email->save();
            }
            return redirect('smtp-settings')->with('message','Email settings updated!');
        }
        
        else {
            Config::set('mail.driver', $request->mail_driver);
            Config::set('mail.host', $request->host_name);
            Config::set('mail.port', $request->port_name);
            Config::set('mail.username', $request->user_name);
            Config::set('mail.password', $request->password);

            if($request->port_name == "465") {
                $encryption                    = "ssl";
            }else {
                $encryption                    = "tls";
            }

            Config::set('mail.encryption', $encryption);

            Config::set('mail.from.address', $request->user_name);
            Config::set('mail.from.name', $request->from_name);
            
            $data["email"] = $request->email_to;
            $data["client_name"] = '';
            $data["subject"] = $request->email_subject;
            $data["body"] = $request->editor1;

            if($request->send_as_attachment == 1) {
                $pdf = PDF::loadView('configurations.email.mail_body',compact('data'));
                try{
                    Mail::send('configurations.email.mail_body', compact('data'), function($message)use($data,$pdf) {
                    $message->to($data["email"], $data["client_name"])
                        ->subject($data["subject"])
                        ->attachData($pdf->output(), "attachment.pdf");
                    });

                    $error      =   "";
                    $message    =   "Message sent Succesfully!";
                    $status     =   "1";
                }catch(Swift_SwiftException $Ste){
                    $this->serverstatuscode = "0";
                    $this->serverstatusdes = $Ste->getMessage();

                    $error      =   $Ste->getMessage();
                    $message    =   "Error sending mail!";
                    $status     =   "0";
                }
                return Redirect::back()->with('message',$message)->with('error',$error)->withInput();
            }else {
                try{
                    Mail::send('configurations.email.mail_body', compact('data'), function($message)use($data) {
                    $message->to($data["email"], $data["client_name"])
                        ->subject($data["subject"]);
                    });

                    $error      =   "";
                    $message    =   "Message sent Succesfully!";
                    $status     =   "1";
                }catch(Swift_SwiftException $Ste){
                    $this->serverstatuscode = "0";
                    $this->serverstatusdes = $Ste->getMessage();

                    $error      =   $Ste->getMessage();
                    $message    =   "Error sending mail!";
                    $status     =   "0";
                }
                return Redirect::back()->with('message',$message)->with('error',$error)->withInput();
            }
        }
        
    }

    //Tax Rule Setup
    public function tax_rule_setup() {
        /*if(roles() != "" && !in_array(40, json_decode(roles(),false))){
            return redirect('404');
        }*/
        $setups = TaxRule::where('company_id',Auth::user()->company_id)->orderBy('id','desc')->paginate(10);
        return view('configurations.tax_rule_setup.index',compact('setups'));
    }

    public function tax_rule_setup_add(Request $request) {
        
        if($request->income_year_from != "") {
            $setup                                                  = new TaxRule;
            $setup->company_id                                      = Auth::user()->company_id;
            $setup->income_year_from                                = $request->income_year_from;
            $setup->income_year_to                                  = $request->income_year_to;
            $setup->assesment_year_from                             = $request->assesment_year_from;
            $setup->assesment_year_to                               = $request->assesment_year_to;

            $setup->house_rent_allowance_amount_yearly              = $request->house_rent_allowance_amount;
            $setup->house_rent_allowance_amount_monthly             = $request->house_rent_allowance_amount / 12;

            $setup->house_rent_allowance_in_percent                 = $request->house_rent_allowance_in_percent;
            $setup->conveyance_allowance_actual                     = $request->conveyance_allowance_actual;

            $setup->conveyance_allowance_amount_yearly              = $request->conveyance_allowance_amount;
            $setup->conveyance_allowance_amount_monthly             = $request->conveyance_allowance_amount / 12;

            $setup->medical_allowance_amount_yearly                 = $request->medical_allowance_amount;
            $setup->medical_allowance_amount_monthly                = $request->medical_allowance_amount / 12;

            $setup->medical_allowance_in_percent                    = $request->medical_allowance_in_percent;

            $setup->first_amount_below_65_aged_male_yearly          = $request->first_amount_below_65_aged_male;
            $setup->first_amount_below_65_aged_male_monthly         = $request->first_amount_below_65_aged_male / 12;

            $setup->first_amount_female_above_65_aged_male_yearly   = $request->first_amount_female_above_65_aged_male;
            $setup->first_amount_female_above_65_aged_male_monthly  = $request->first_amount_female_above_65_aged_male / 12;

            $setup->first_tax_rate_percent                          = $request->first_tax_rate_percent;

            $setup->second_amount_below_65_aged_male_yearly         = $request->second_amount_below_65_aged_male;
            $setup->second_amount_below_65_aged_male_monthly        = $request->second_amount_below_65_aged_male / 12;

            $setup->second_amount_female_above_65_aged_male_yearly  = $request->second_amount_female_above_65_aged_male;
            $setup->second_amount_female_above_65_aged_male_monthly = $request->second_amount_female_above_65_aged_male / 12;

            $setup->second_tax_rate_percent                         = $request->second_tax_rate_percent;

            $setup->third_amount_below_65_aged_male_yearly          = $request->third_amount_below_65_aged_male;
            $setup->third_amount_below_65_aged_male_monthly         = $request->third_amount_below_65_aged_male / 12;

            $setup->third_amount_female_above_65_aged_male_yearly   = $request->third_amount_female_above_65_aged_male;
            $setup->third_amount_female_above_65_aged_male_monthly  = $request->third_amount_female_above_65_aged_male / 12;

            $setup->third_tax_rate_percent                          = $request->third_tax_rate_percent;

            $setup->forth_amount_below_65_aged_male_yearly          = $request->forth_amount_below_65_aged_male;
            $setup->forth_amount_below_65_aged_male_monthly         = $request->forth_amount_below_65_aged_male / 12;

            $setup->forth_amount_female_above_65_aged_male_yearly   = $request->forth_amount_female_above_65_aged_male;
            $setup->forth_amount_female_above_65_aged_male_monthly  = $request->forth_amount_female_above_65_aged_male / 12;

            $setup->forth_tax_rate_percent                          = $request->forth_tax_rate_percent;

            $setup->fifth_amount_below_65_aged_male_yearly          = $request->fifth_amount_below_65_aged_male;
            $setup->fifth_amount_below_65_aged_male_monthly         = $request->fifth_amount_below_65_aged_male / 12;

            $setup->fifth_amount_female_above_65_aged_male_yearly   = $request->fifth_amount_female_above_65_aged_male;
            $setup->fifth_amount_female_above_65_aged_male_monthly  = $request->fifth_amount_female_above_65_aged_male / 12;

            $setup->fifth_tax_rate_percent                          = $request->fifth_tax_rate_percent;

            $setup->rest_amount_below_65_aged_male                  = $request->rest_amount_below_65_aged_male;

            $setup->rest_amount_female_above_65_aged_male           = $request->rest_amount_female_above_65_aged_male;

            $setup->rest_tax_rate_percent                           = $request->rest_tax_rate_percent;
            $setup->per_percent_of_tax_income                       = $request->per_percent_of_tax_income;

            $setup->maximum_investment_amount_allowed_yearly        = $request->maximum_investment_amount_allowed;
            $setup->maximum_investment_amount_allowed_monthly       = $request->maximum_investment_amount_allowed / 12;

            $setup->investment_amount_less_percent                  = $request->investment_amount_less_percent;

            $setup->investment_amount_less_amount_yearly            = $request->investment_amount_less_amount;
            $setup->investment_amount_less_amount_monthly           = $request->investment_amount_less_amount / 12;

            $setup->investment_amount_more_percent                  = $request->investment_amount_more_percent;

            $setup->investment_amount_more_amount_yearly            = $request->investment_amount_more_amount;
            $setup->investment_amount_more_amount_monthly           = $request->investment_amount_more_amount / 12;

            $setup->query_income_date_from                          = date('Y-m-d',strtotime($request->income_year_from.'-06-01'));
            $setup->query_income_date_to                            = date('Y-m-d',strtotime($request->income_year_to.'-05-31'));
            $setup->save();
            return redirect('tax-rule-setup')->with('message','Tax Rule Setup Added Successfully!');
        }
        return view('configurations.tax_rule_setup.add');
    }

    public function tax_rule_setup_update(Request $request, $tax_id) {
        $setup = TaxRule::where('id',$tax_id)->first();
        
        if($request->income_year_from != "") {
            $setup->income_year_from                                = $request->income_year_from;
            $setup->income_year_to                                  = $request->income_year_to;
            $setup->assesment_year_from                             = $request->assesment_year_from;
            $setup->assesment_year_to                               = $request->assesment_year_to;

            $setup->house_rent_allowance_amount_yearly              = $request->house_rent_allowance_amount;
            $setup->house_rent_allowance_amount_monthly             = $request->house_rent_allowance_amount / 12;

            $setup->house_rent_allowance_in_percent                 = $request->house_rent_allowance_in_percent;
            $setup->conveyance_allowance_actual                     = $request->conveyance_allowance_actual;

            $setup->conveyance_allowance_amount_yearly              = $request->conveyance_allowance_amount;
            $setup->conveyance_allowance_amount_monthly             = $request->conveyance_allowance_amount / 12;

            $setup->medical_allowance_amount_yearly                 = $request->medical_allowance_amount;
            $setup->medical_allowance_amount_monthly                = $request->medical_allowance_amount / 12;

            $setup->medical_allowance_in_percent                    = $request->medical_allowance_in_percent;

            $setup->first_amount_below_65_aged_male_yearly          = $request->first_amount_below_65_aged_male;
            $setup->first_amount_below_65_aged_male_monthly         = $request->first_amount_below_65_aged_male / 12;

            $setup->first_amount_female_above_65_aged_male_yearly   = $request->first_amount_female_above_65_aged_male;
            $setup->first_amount_female_above_65_aged_male_monthly  = $request->first_amount_female_above_65_aged_male / 12;

            $setup->first_tax_rate_percent                          = $request->first_tax_rate_percent;

            $setup->second_amount_below_65_aged_male_yearly         = $request->second_amount_below_65_aged_male;
            $setup->second_amount_below_65_aged_male_monthly        = $request->second_amount_below_65_aged_male / 12;

            $setup->second_amount_female_above_65_aged_male_yearly  = $request->second_amount_female_above_65_aged_male;
            $setup->second_amount_female_above_65_aged_male_monthly = $request->second_amount_female_above_65_aged_male / 12;

            $setup->second_tax_rate_percent                         = $request->second_tax_rate_percent;

            $setup->third_amount_below_65_aged_male_yearly          = $request->third_amount_below_65_aged_male;
            $setup->third_amount_below_65_aged_male_monthly         = $request->third_amount_below_65_aged_male / 12;

            $setup->third_amount_female_above_65_aged_male_yearly   = $request->third_amount_female_above_65_aged_male;
            $setup->third_amount_female_above_65_aged_male_monthly  = $request->third_amount_female_above_65_aged_male / 12;

            $setup->third_tax_rate_percent                          = $request->third_tax_rate_percent;

            $setup->forth_amount_below_65_aged_male_yearly          = $request->forth_amount_below_65_aged_male;
            $setup->forth_amount_below_65_aged_male_monthly         = $request->forth_amount_below_65_aged_male / 12;

            $setup->forth_amount_female_above_65_aged_male_yearly   = $request->forth_amount_female_above_65_aged_male;
            $setup->forth_amount_female_above_65_aged_male_monthly  = $request->forth_amount_female_above_65_aged_male / 12;

            $setup->forth_tax_rate_percent                          = $request->forth_tax_rate_percent;

            $setup->fifth_amount_below_65_aged_male_yearly          = $request->fifth_amount_below_65_aged_male;
            $setup->fifth_amount_below_65_aged_male_monthly         = $request->fifth_amount_below_65_aged_male / 12;

            $setup->fifth_amount_female_above_65_aged_male_yearly   = $request->fifth_amount_female_above_65_aged_male;
            $setup->fifth_amount_female_above_65_aged_male_monthly  = $request->fifth_amount_female_above_65_aged_male / 12;

            $setup->fifth_tax_rate_percent                          = $request->fifth_tax_rate_percent;

            $setup->rest_amount_below_65_aged_male                  = $request->rest_amount_below_65_aged_male;

            $setup->rest_amount_female_above_65_aged_male           = $request->rest_amount_female_above_65_aged_male;

            $setup->rest_tax_rate_percent                           = $request->rest_tax_rate_percent;
            $setup->per_percent_of_tax_income                       = $request->per_percent_of_tax_income;

            $setup->maximum_investment_amount_allowed_yearly        = $request->maximum_investment_amount_allowed;
            $setup->maximum_investment_amount_allowed_monthly       = $request->maximum_investment_amount_allowed / 12;

            $setup->investment_amount_less_percent                  = $request->investment_amount_less_percent;

            $setup->investment_amount_less_amount_yearly            = $request->investment_amount_less_amount;
            $setup->investment_amount_less_amount_monthly           = $request->investment_amount_less_amount / 12;

            $setup->investment_amount_more_percent                  = $request->investment_amount_more_percent;

            $setup->investment_amount_more_amount_yearly            = $request->investment_amount_more_amount;
            $setup->investment_amount_more_amount_monthly           = $request->investment_amount_more_amount / 12;

            $setup->query_income_date_from                          = date('Y-m-d',strtotime($request->income_year_from.'-06-01'));
            $setup->query_income_date_to                            = date('Y-m-d',strtotime($request->income_year_to.'-05-31'));
            $setup->save();
            return redirect('tax-rule-setup')->with('message','Tax Rule Setup Added Successfully!');
        }
        return view('configurations.tax_rule_setup.update',compact('setup'));
    }

    public function tax_rule_setup_delete($tax_id) {
        /*if(roles() != "" && !in_array(5, json_decode(roles(),false))){
            return redirect('404');
        }*/
        $setup = TaxRule::find($tax_id);
        if($setup->company_id == Auth::user()->company_id){
            $setup->delete();
            return redirect('tax-rule-setup')->with('message','Tax Rule Setup Deleted Successfully!');
        }else{
            return redirect('tax-rule-setup')->with('message','Do not try to be too smart!');
        }
    }
}
