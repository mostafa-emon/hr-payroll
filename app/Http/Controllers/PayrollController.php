<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PayrollBank;
use App\PayrollBranch;
use App\SmsSetting;
use App\Department;
use App\Project;
use App\Branch;
use App\SmsCampaign;
use App\EmploymentInfo;
use App\CampaignReceiver;
use App\CompanyPf;
use App\Currency;
use App\AbsentDeduction;
use Auth;

class PayrollController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function bank_index() {
        $banks = PayrollBank::where('company_id',Auth::user()->company_id)->orderBy('bank_name','asc')->paginate(10);
        return view('payroll_setup.banks.index',compact('banks'));
    }

    public function bank_add(Request $request) {
        $bank = new PayrollBank;
        $bank->company_id = Auth::user()->company_id;
        $bank->bank_name  = $request->bank_name;
        $bank->save();
        return redirect('payroll-banks')->with('message','Bank added successfully!');
    }

    public function bank_get($id) {
        $bank = PayrollBank::where('id',$id)->first();
        echo $bank;
    }

    public function bank_update(Request $request,$id) {
        $bank = PayrollBank::where('id',$id)->first();
        $bank->bank_name = $request->bank_name;
        $bank->save();
        return redirect('payroll-banks')->with('message','Bank updated successfully!');
    }

    public function bank_delete($id) {
        $bank = PayrollBank::find($id);
        if($bank->company_id == Auth::user()->company_id){
            $bank->delete();
            return redirect('payroll-banks')->with('message','Bank Deleted Successfully!');
        }else{
            return redirect('payroll-banks')->with('message','Do not try to be too smart!');
        }
    }

    // Branch
    public function branch_index($id) {
        $bank           = PayrollBank::where('id',$id)->first();
        if($bank->company_id == Auth::user()->company_id){
            $branches   = PayrollBranch::where('bank_id',$id)->orderBy('branch_name','asc')->get();
            return view('payroll_setup.banks.branches',compact('branches','bank'));
        }else{
            return redirect('payroll-banks')->with('message','Do not try to be too smart!');
        }
    }

    public function branch_add(Request $request) {
        $branch = new PayrollBranch;
        $branch->bank_id        = $request->bank_id;
        $branch->branch_name    = $request->branch_name;
        $branch->save();
        return back()->with('message','Branch Added Successfully!');
    }

    public function branch_get($id) {
        $branch = PayrollBranch::where('id',$id)->first();
        echo $branch;
    }

    public function branch_update(Request $request,$id) {
        $branch = PayrollBranch::where('id',$id)->first();
        $branch->branch_name    = $request->branch_name;
        $branch->save();
        return back()->with('message','Branch Updated Successfully!');
    }

    public function branch_delete($id) {
        $branch = PayrollBranch::find($id);
        $branch->delete();
        return back()->with('message','Branch Deleted Successfully!');
    }

    public function get_branch($bank_id) {
        $branches = PayrollBranch::where('bank_id',$bank_id)->get();
        if(count($branches) > 0) {
            foreach($branches as $branch) {
                echo "<option value=".$branch->id.">".$branch->branch_name."</option>";
            }
        }else {
            echo "";
        }
    }


    //SMS Campaign
    public function create_campaign(){
        $apis           = SmsSetting::where('company_id', Auth::user()->company_id)->get();
        $departments    = Department::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $projects       = Project::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $branches       = Branch::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $campaigns      = SmsCampaign::where('company_id',Auth::user()->company_id)->orderby('created_at','desc')->paginate(10);
        return view('transactions.payroll.sms_notifications.create_campaign',compact('departments','campaigns','projects','branches','apis'));
    }

    public function create_campaign_post(Request $request){
        $campaign = new SmsCampaign();
        $campaign->company_id           = Auth::user()->company_id;
        $campaign->sms_body             = $request->sms_body;
        if (strlen($request->sms_body) != strlen(utf8_decode($request->sms_body))){
            $campaign->language         = "Other Language";
        }else {
            $campaign->language         = "English";
        }
        $campaign->body_length          = $request->body_length;
        if($request->department_id != "") {
            $campaign->department_id    = json_encode($request->department_id);
        }
        if($request->project_id != "") {
            $campaign->project_id       = json_encode($request->project_id);
        }
        if($request->branch_id != "") {
            $campaign->branch_id        = json_encode($request->branch_id);
        }
        $campaign->save();

        $receivers                      = EmploymentInfo::orderBy('employment_infos.id','asc')->join('employees','employees.id','employment_infos.employee_id')->where('employees.company_id',Auth::user()->company_id);

        if($request->department_id != ""){
            $receivers                  = $receivers->whereIn('department_id',$request->department_id);
        }
        if($request->project_id != ""){
            $receivers                  = $receivers->whereIn('project_id',$request->project_id);
        }
        if($request->branch_id != ""){
            $receivers                  = $receivers->whereIn('branch_id',$request->branch_id);
        }

        $receivers = $receivers->get();

        foreach($receivers as $receiver) {
            if($receiver->phone_1 != "") {
                $phone = '+880'.substr($receiver->phone_1,-10);
                $is_exists = CampaignReceiver::where('campaign_id',$campaign->id)->where('phone',$phone)->count();
                if($is_exists == 0) {
                    $campaign_receiver = new CampaignReceiver();
                    $campaign_receiver->campaign_id     = $campaign->id;
                    $campaign_receiver->receiver_id     = $receiver->id;
                    $campaign_receiver->receiver_name   = $receiver->name;
                    $campaign_receiver->phone           = $phone;
                    $campaign_receiver->save();
                }
            }
            if($receiver->phone_2 != "") {
                $phone = '+880'.substr($receiver->phone_2,-10);
                $is_exists = CampaignReceiver::where('campaign_id',$campaign->id)->where('phone',$phone)->count();
                if($is_exists == 0) {
                    $campaign_receiver = new CampaignReceiver();
                    $campaign_receiver->campaign_id     = $campaign->id;
                    $campaign_receiver->receiver_id     = $receiver->id;
                    $campaign_receiver->receiver_name   = $receiver->name;
                    $campaign_receiver->phone           = $phone;
                    $campaign_receiver->save();
                }
            }
        }
        
        return redirect('create-campaign')->with('message','Campaign added successfully!');
    }

    public function campaign_receivers($campaign_id){
        $receivers = CampaignReceiver::where('campaign_id',$campaign_id)->paginate(10);
        return view('transactions.payroll.sms_notifications.campaign_receivers',compact('receivers'));
    }

    public function campaign_update(Request $request){
        $campaign = SmsCampaign::where('id',$request->campaign_id_update)->first();
        $campaign->sms_body         = $request->updated_body;
        $campaign->body_length      = $request->updated_body_count;
        if (strlen($request->updated_body) != strlen(utf8_decode($request->updated_body))){
            $campaign->language  = "Other Language";
        }else {
            $campaign->language  = "English";
        }
        $campaign->save();

        return redirect('create-campaign')->with('message','Campaign updated successfully!');
    }

    public function campaign_duplicate($campaign_id){
        $request = SmsCampaign::where('id',$campaign_id)->first();
        $campaign = new SmsCampaign();
        $campaign->company_id           = Auth::user()->company_id;
        $campaign->sms_body             = $request->sms_body;
        $campaign->body_length          = $request->body_length;
        $campaign->department_id        = $request->department_id;
        $campaign->project_id           = $request->project_id;
        $campaign->branch_id            = $request->branch_id;
        $campaign->language             = $request->language;
        $campaign->save();

        $receivers = CampaignReceiver::where('campaign_id',$campaign_id)->get();
        foreach($receivers as $pre_receiver) {
            $receiver = new CampaignReceiver();
            $receiver->campaign_id      = $campaign->id;
            $receiver->receiver_id      = $pre_receiver->receiver_id;
            $receiver->receiver_name    = $pre_receiver->receiver_name;
            $receiver->phone            = $pre_receiver->phone;
            $receiver->status           = 0;
            $receiver->save();
        }

        return redirect('create-campaign')->with('message','Campaign copied successfully!');
    }

    public function delete_campaign($campaign_id) {
        $campaign = SmsCampaign::find($campaign_id);
        $campaign->delete();
        return redirect('create-campaign')->with('message','Campaign Deleted Successfully!');
    }

    public function send_sms($campaign_id,$api_id) {
        $sms_setting = SmsSetting::where('id',$api_id)->first();
        $campaign    = SmsCampaign::where('id',$campaign_id)->first();
        $receivers   = CampaignReceiver::where('campaign_id',$campaign_id)->get();
        $received    = CampaignReceiver::where('campaign_id',$campaign_id)->where('status',1)->count();
        return view('transactions.payroll.sms_notifications.send-sms',compact('campaign_id','api_id','sms_setting','campaign','receivers','received'));
    }

    function ajax_send_sms($sl,$send_per_sms,$campaign_id,$api_id) {
        $sms_settings   = SmsSetting::where('id',$api_id)->first();
        $receiver       = CampaignReceiver::orderby('receiver_id','asc')->where('campaign_id',$campaign_id)->where('status',0)->first();
        $campaign       = SmsCampaign::where('id',$receiver->campaign_id)->first();
        $parameter      = "";
        
        if($sms_settings->sms_balance >= $send_per_sms) {
            $receiver->status = 1;
            $receiver->save();

            $sms_settings->sms_balance = $sms_settings->sms_balance - $send_per_sms;
            $sms_settings->save();

            if($sms_settings->parameter_1_key != "") {
                if($sms_settings->sms_body_parameter_name == "parameter_1") {
                    $parameter = $parameter.$sms_settings->parameter_1_key.'='.urlencode($campaign->sms_body);
                }else{
                    if($sms_settings->send_to_parameter_name == "parameter_1") {
                        $parameter = $parameter.$sms_settings->parameter_1_key.'=+'.'+880'.substr($receiver->phone, -10);
                    }else{
                        $parameter = $parameter.$sms_settings->parameter_1_key.'='.$sms_settings->parameter_1_value;
                    }
                }
            }
            if($sms_settings->parameter_2_key != "") {
                if($sms_settings->sms_body_parameter_name == "parameter_2") {
                    $parameter = $parameter.'&'.$sms_settings->parameter_2_key.'='.urlencode($campaign->sms_body);
                }else{
                    if($sms_settings->send_to_parameter_name == "parameter_2") {
                        $parameter = $parameter.'&'.$sms_settings->parameter_2_key.'=+'.'+880'.substr($receiver->phone, -10);
                    }else{
                        $parameter = $parameter.'&'.$sms_settings->parameter_2_key.'='.$sms_settings->parameter_2_value;
                    }
                }
            }
            if($sms_settings->parameter_3_key != "") {
                if($sms_settings->sms_body_parameter_name == "parameter_3") {
                    $parameter = $parameter.'&'.$sms_settings->parameter_3_key.'='.urlencode($campaign->sms_body);
                }else{
                    if($sms_settings->send_to_parameter_name == "parameter_3") {
                        $parameter = $parameter.'&'.$sms_settings->parameter_3_key.'=+'.'+880'.substr($receiver->phone, -10);
                    }else{
                        $parameter = $parameter.'&'.$sms_settings->parameter_3_key.'='.$sms_settings->parameter_3_value;
                    }
                }
            }
            if($sms_settings->parameter_4_key != "") {
                if($sms_settings->sms_body_parameter_name == "parameter_4") {
                    $parameter = $parameter.'&'.$sms_settings->parameter_4_key.'='.urlencode($campaign->sms_body);
                }else{
                    if($sms_settings->send_to_parameter_name == "parameter_4") {
                        $parameter = $parameter.'&'.$sms_settings->parameter_4_key.'=+'.'+880'.substr($receiver->phone, -10);
                    }else{
                        $parameter = $parameter.'&'.$sms_settings->parameter_4_key.'='.$sms_settings->parameter_4_value;
                    }
                }
            }
            if($sms_settings->parameter_5_key != "") {
                if($sms_settings->sms_body_parameter_name == "parameter_5") {
                    $parameter = $parameter.'&'.$sms_settings->parameter_5_key.'='.urlencode($campaign->sms_body);
                }else{
                    if($sms_settings->send_to_parameter_name == "parameter_5") {
                        $parameter = $parameter.'&'.$sms_settings->parameter_5_key.'=+'.'+880'.substr($receiver->phone, -10);
                    }else{
                        $parameter = $parameter.'&'.$sms_settings->parameter_5_key.'='.$sms_settings->parameter_5_value;
                    }
                }
            }
            if($sms_settings->parameter_6_key != "") {
                if($sms_settings->sms_body_parameter_name == "parameter_6") {
                    $parameter = $parameter.'&'.$sms_settings->parameter_6_key.'='.urlencode($campaign->sms_body);
                }else{
                    if($sms_settings->send_to_parameter_name == "parameter_6") {
                        $parameter = $parameter.'&'.$sms_settings->parameter_6_key.'=+'.'+880'.substr($receiver->phone, -10);
                    }else{
                        $parameter = $parameter.'&'.$sms_settings->parameter_6_key.'='.$sms_settings->parameter_6_value;
                    }
                }
            }
            if($sms_settings->parameter_7_key != "") {
                if($sms_settings->sms_body_parameter_name == "parameter_7") {
                    $parameter = $parameter.'&'.$sms_settings->parameter_7_key.'='.urlencode($campaign->sms_body);
                }else{
                    if($sms_settings->send_to_parameter_name == "parameter_7") {
                        $parameter = $parameter.'&'.$sms_settings->parameter_7_key.'=+'.'+880'.substr($receiver->phone, -10);
                    }else{
                        $parameter = $parameter.'&'.$sms_settings->parameter_7_key.'='.$sms_settings->parameter_7_value;
                    }
                }
            }
            if($sms_settings->parameter_8_key != "") {
                if($sms_settings->sms_body_parameter_name == "parameter_8") {
                    $parameter = $parameter.'&'.$sms_settings->parameter_8_key.'='.urlencode($campaign->sms_body);
                }else{
                    if($sms_settings->send_to_parameter_name == "parameter_8") {
                        $parameter = $parameter.'&'.$sms_settings->parameter_8_key.'=+'.'+880'.substr($receiver->phone, -10);
                    }else{
                        $parameter = $parameter.'&'.$sms_settings->parameter_8_key.'='.$sms_settings->parameter_8_value;
                    }
                }
            }
            if($sms_settings->parameter_9_key != "") {
                if($sms_settings->sms_body_parameter_name == "parameter_9") {
                    $parameter = $parameter.'&'.$sms_settings->parameter_9_key.'='.urlencode($campaign->sms_body);
                }else{
                    if($sms_settings->send_to_parameter_name == "parameter_9") {
                        $parameter = $parameter.'&'.$sms_settings->parameter_9_key.'=+'.'+880'.substr($receiver->phone, -10);
                    }else{
                        $parameter = $parameter.'&'.$sms_settings->parameter_9_key.'='.$sms_settings->parameter_9_value;
                    }
                }
            }
            if($sms_settings->parameter_10_key != "") {
                if($sms_settings->sms_body_parameter_name == "parameter_10") {
                    $parameter = $parameter.'&'.$sms_settings->parameter_10_key.'='.urlencode($campaign->sms_body);
                }else{
                    if($sms_settings->send_to_parameter_name == "parameter_10") {
                        $parameter = $parameter.'&'.$sms_settings->parameter_10_key.'=+'.'+880'.substr($receiver->phone, -10);
                    }else{
                        $parameter = $parameter.'&'.$sms_settings->parameter_10_key.'='.$sms_settings->parameter_10_value;
                    }
                }
            }
    
            if(substr($sms_settings->sms_api_url, -1) == "?") {
                $api_url = $sms_settings->sms_api_url;
            }else {
                $api_url = $sms_settings->sms_api_url.'?';
            }
    
            $url = $api_url.$parameter;
            
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $curl_exec = curl_exec($curl);
            curl_close($curl);

            echo "<tr><td style='text-align:center'>".$sl."</td><td colspan='2'>".$receiver->receiver_name."</td><td colspan='2'>".$receiver->phone."</td><td style='color:green'><i class='fa fa-check-circle'></i> Request Sent</td></tr>";
        }
    }

    public function company_pf_index() {
        $company_pfs            = CompanyPf::where('company_id',Auth::user()->company_id)->where('status',0)->orderBy('id','desc')->paginate(10);
        return view('transactions.payroll.company_pf.index',compact('company_pfs'));
    }

    public function company_pf_create(Request $request) {
        $employment_infos       = EmploymentInfo::orderBy('employment_infos.id','asc')->join('employees','employees.id','employment_infos.employee_id')->where('employees.company_id',Auth::user()->company_id);
        $departments            = Department::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $projects               = Project::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $branches               = Branch::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $currencies             = Currency::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();

        $department_id          = '';
        $project_id             = '';
        $branch_id              = '';
        $month                  = '';
        $year                   = '';
        $currency_id            = '';

        if($request->department_id != ""){
            $employment_infos   = $employment_infos->where('department_id',$request->department_id);
            $department_id      = $request->department_id;
        }

        if($request->project_id != ""){
            $employment_infos   = $employment_infos->where('project_id',$request->project_id);
            $project_id         = $request->project_id;
        }

        if($request->branch_id != ""){
            $employment_infos   = $employment_infos->where('branch_id',$request->branch_id);
            $branch_id          = $request->branch_id;
        }

        if($request->currency_id != ""){
            $currency_id        = $request->currency_id;
        }

        if($request->month != ""){
            $month              = $request->month;
        }

        if($request->year != ""){
            $year               = $request->year;
        }

        if($request->month != "") {
            $employment_infos   = $employment_infos->get();
        }

        return view('transactions.payroll.company_pf.add',compact('departments','projects','branches',
        'currencies','department_id','project_id','branch_id','month','year','currency_id','employment_infos'));
    }

    public function company_pf_store(Request $request){
        $interval = count($request->pf_amount);
        for($i = 0; $i < $interval; $i++) {
            if($request->pf_amount[$i] !=''){

                $count_pf = CompanyPf::where('employee_id',$request->employee_id[$i])->where('month',$request->store_month)->where('year',$request->store_year)->first();
                if($count_pf !=""){
                    $pf = CompanyPf::where('employee_id',$request->employee_id[$i])->where('month',$request->store_month)->where('year',$request->store_year)->delete();
                }

                $company_pf = new CompanyPf();
                $company_pf->company_id     = Auth::user()->company_id;
                $company_pf->employee_id    = $request->employee_id[$i];
                $company_pf->amount         = $request->pf_amount[$i];
                $company_pf->currency_id    = $request->store_currency_id;
                $company_pf->month          = $request->store_month;
                $company_pf->year           = $request->store_year;
                $company_pf->type           = 'Company PF';
                $company_pf->status         = 0;
                $company_pf->save();
            }
        }
        return redirect('company-pf')->with('message','Company PF successfully!');
    }

    public function company_pf_pay_index(Request $request) {
        $employment_infos       = EmploymentInfo::orderBy('employment_infos.id','asc')->join('employees','employees.id','employment_infos.employee_id')->where('employees.company_id',Auth::user()->company_id);
        $departments            = Department::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $projects               = Project::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $branches               = Branch::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();

        $department_id          = '';
        $project_id             = '';
        $branch_id              = '';
        $employee_id            = '';
        $increment_employee_id  = '';
        $company_pfs            = [];

        if($request->department_id != ""){
            $employment_infos   = $employment_infos->where('department_id',$request->department_id);
            $department_id      = $request->department_id;
        }

        if($request->project_id != ""){
            $employment_infos   = $employment_infos->where('project_id',$request->project_id);
            $project_id         = $request->project_id;
        }

        if($request->branch_id != ""){
            $employment_infos   = $employment_infos->where('branch_id',$request->branch_id);
            $branch_id          = $request->branch_id;
        }

        if($request->employee_id != "") {
            $employee_id            = $request->employee_id;
            $increment_employee_id  = get_auto_increment_employee_id($request->employee_id);
            $company_pfs            = CompanyPf::where('company_id',Auth::user()->company_id)
                                    ->where('employee_id',$increment_employee_id)
                                    ->where('type','Company PF')
                                    ->where('status',0)->get();
        }

        $employment_infos = $employment_infos->get();

        return view('transactions.payroll.company_pf.pay',compact('departments','projects','branches',
        'department_id','project_id','branch_id','employee_id','employment_infos','company_pfs','increment_employee_id'));
    }

    public function company_pf_pay_store($employee_id) {
        //return response()->json($employee_id);
        $company_pfs    = CompanyPf::where('company_id',Auth::user()->company_id)
                        ->where('employee_id',$employee_id)
                        ->where('type','Company PF')
                        ->where('status',0)->get();
        foreach($company_pfs as $pf) {
            $pf->status = 1;
            $pf->save();
        }
        return redirect('company-pf')->with('message','Company PF paid successfully!');
    }

    public function company_pf_delete($id) {
        $pf = CompanyPf::find($id);
        if($pf->company_id == Auth::user()->company_id){
            $pf->delete();
            return redirect('company-pf')->with('message','Company PF Deleted Successfully!');
        }else{
            return redirect('company-pf')->with('message','Do not try to be too smart!');
        }
    }

    public function company_pf_update(Request $request,$id) {
        $currencies = Currency::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $company_pf = CompanyPf::where('id',$id)->first();
        if($request->amount != "") {
            $company_pf->currency_id    = $request->currency_id;
            $company_pf->month          = $request->month;
            $company_pf->year           = $request->year;
            $company_pf->amount         = $request->amount;
            $company_pf->save();

            return redirect('company-pf')->with('message','Company PF Updated Successfully!');
        }
        return view('transactions.payroll.company_pf.update',compact('company_pf','currencies'));
    }

    public function absent_deduction_index() {
        $deductions = AbsentDeduction::where('company_id',Auth::user()->company_id)->orderBy('id','desc')->paginate(10);
        return view('transactions.payroll.absent_deduction.index',compact('deductions'));
    }

    public function absent_deduction_create(Request $request) {
        $employment_infos   = EmploymentInfo::orderBy('employment_infos.id','asc')->join('employees','employees.id','employment_infos.employee_id')->where('employees.company_id',Auth::user()->company_id);
        $departments        = Department::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $projects           = Project::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $branches           = Branch::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();

        $department_id      = '';
        $project_id         = '';
        $branch_id          = '';
        $employee_id        = [];
        $month              = '';
        $year               = '';

        if($request->department_id != ""){
            $employment_infos   = $employment_infos->where('department_id',$request->department_id);
            $department_id      = $request->department_id;
        }

        if($request->project_id != ""){
            $employment_infos   = $employment_infos->where('project_id',$request->project_id);
            $project_id         = $request->project_id;
        }

        if($request->branch_id != ""){
            $employment_infos   = $employment_infos->where('branch_id',$request->branch_id);
            $branch_id          = $request->branch_id;
        }

        if($request->month != "") {
            $month              = $request->month;
        }else{
            $month              = date('F');
        }

        if($request->year != "") {
            $year               = $request->year;
        }else{
            $year               = date('Y');
        }

        if($request->employee_id != "") {
            $employee_id        = $request->employee_id;
            $employment_infos   = $employment_infos->whereIn('employees.employee_id',$request->employee_id);
        }

        $employment_infos       = $employment_infos->get();

        return view('transactions.payroll.absent_deduction.add',compact('departments','projects','branches',
        'department_id','branch_id','project_id','employment_infos','month','year','employee_id'));
    }

    public function absent_deduction_store(Request $request){
        $interval = count($request->deduction);
        for($i = 0; $i < $interval; $i++) {
            if($request->deduction[$i] !='0'){

                $count_deduction        = AbsentDeduction::where('employee_id',$request->employee_id[$i])->where('month',$request->store_month)->where('year',$request->store_year)->first();
                if($count_deduction !=""){
                    $delete_deduction   = AbsentDeduction::where('employee_id',$request->employee_id[$i])->where('month',$request->store_month)->where('year',$request->store_year)->delete();
                }

                $deduction = new AbsentDeduction();
                $deduction->company_id          = Auth::user()->company_id;
                $deduction->employee_id         = $request->employee_id[$i];
                $deduction->total_absent_days   = $request->total_absent_days[$i];
                $deduction->deduction           = $request->deduction[$i];
                $deduction->month               = $request->store_month;
                $deduction->year                = $request->store_year;
                $deduction->save();
            }
        }
        return redirect('absent-deduction')->with('message','Absent Deduction Created successfully!');
    }

    public function absent_deduction_delete($id) {
        $deduction = AbsentDeduction::find($id);
        if($deduction->company_id == Auth::user()->company_id){
            $deduction->delete();
            return redirect('absent-deduction')->with('message','Absent Deduction Deleted Successfully!');
        }else{
            return redirect('absent-deduction')->with('message','Do not try to be too smart!');
        }
    }

    public function absent_deduction_update(Request $request,$id) {
        $deduction = AbsentDeduction::where('id',$id)->first();
        if($request->total_absent_days != "") {
            $deduction->total_absent_days   = $request->total_absent_days;
            $deduction->deduction           = $request->deduction;
            $deduction->save();
            return redirect('absent-deduction')->with('message','Absent Deduction Updated Successfully!');
        }
        return view('transactions.payroll.absent_deduction.update',compact('deduction'));
    }
}
