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
use App\ProvidentFund;
use App\Currency;
use App\AbsentDeduction;
use App\Gratuity;
use App\DepositSalaryTax;
use App\GeneralSetting;
use App\IncomeTax;
use App\PayrollInfo;
use Auth;
use Storage;

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
        $company_pfs            = ProvidentFund::where('company_id',Auth::user()->company_id)->where('type','Company Portion')->where('status',0)->orderBy('id','desc')->paginate(10);
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

        if($request->month != "") {
            $employment_infos   = $employment_infos->get();
        }

        return view('transactions.payroll.company_pf.add',compact('departments','projects','branches',
        'currencies','department_id','project_id','branch_id','month','currency_id','employment_infos'));
    }

    public function company_pf_store(Request $request){
        $interval = count($request->pf_amount);
        for($i = 0; $i < $interval; $i++) {
            if($request->pf_amount[$i] !=''){

                $count_pf = ProvidentFund::where('employee_id',$request->employee_id[$i])->where('month',$request->store_month)->where('year',$request->store_year)->where('type','Company Portion')->first();
                if($count_pf !=""){
                    $pf = ProvidentFund::where('employee_id',$request->employee_id[$i])->where('month',$request->store_month)->where('year',$request->store_year)->where('type','Company Portion')->delete();
                }

                $company_pf = new ProvidentFund();
                $company_pf->company_id     = Auth::user()->company_id;
                $company_pf->employee_id    = $request->employee_id[$i];
                $company_pf->amount         = $request->pf_amount[$i];
                $company_pf->currency_id    = $request->store_currency_id;
                $company_pf->month          = date('F',strtotime($request->store_month));
                $company_pf->year           = date('Y',strtotime($request->store_month));
                $company_pf->type           = 'Company Portion';
                $company_pf->status         = 0;
                $company_pf->save();
            }
        }
        return redirect('company-pf')->with('message','PF company portion generated successfully!');
    }

    public function pf_pay_index(Request $request) {
        $employment_infos       = EmploymentInfo::orderBy('employment_infos.id','asc')->join('employees','employees.id','employment_infos.employee_id')->where('employees.company_id',Auth::user()->company_id);
        $departments            = Department::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $projects               = Project::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $branches               = Branch::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();

        $department_id          = '';
        $project_id             = '';
        $branch_id              = '';
        $employee_id            = '';
        $increment_employee_id  = '';
        $pfs                    = [];
        $company_pf_opening_balance     = 0;
        $employee_pf_opening_balance    = 0;

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
            $payroll_info           = PayrollInfo::where('employee_id',$increment_employee_id)->first();
            if($payroll_info != "") {
                $company_pf_opening_balance     = $company_pf_opening_balance + $payroll_info->company_pf_opening_balance;
                $employee_pf_opening_balance    = $employee_pf_opening_balance + $payroll_info->employee_pf_opening_balance;
            }

            $pfs                    = ProvidentFund::where('company_id',Auth::user()->company_id)
                                    ->where('employee_id',$increment_employee_id)
                                    ->where('status',0)
                                    ->select('month','year')
                                    ->groupBy('month', 'year')
                                    ->orderBy('id','desc')
                                    ->get();

            //return response()->json($pfs);
        }

        $employment_infos = $employment_infos->get();

        return view('transactions.payroll.pay_pf',compact('departments','projects','branches','company_pf_opening_balance',
        'department_id','project_id','branch_id','employee_id','employment_infos','pfs','increment_employee_id','employee_pf_opening_balance'));
    }

    public function pf_pay_store($employee_id) {
        $pfs            = ProvidentFund::where('company_id',Auth::user()->company_id)
                        ->where('employee_id',$employee_id)
                        ->where('status',0)->get();
        foreach($pfs as $pf) {
            $pf->status = 1;
            $pf->save();
        }

        $payroll_info = PayrollInfo::where('employee_id',$employee_id)->first();
        if($payroll_info != "") {
            $payroll_info->company_pf_opening_balance   = 0;
            $payroll_info->employee_pf_opening_balance  = 0;
            $payroll_info->save();
        }

        return redirect('pf-pay')->with('message','Provident Fund paid successfully!');
    }

    public function company_pf_delete($id) {
        $pf = ProvidentFund::find($id);
        if($pf->company_id == Auth::user()->company_id){
            $pf->delete();
            return redirect('company-pf')->with('message','Company PF Deleted Successfully!');
        }else{
            return redirect('company-pf')->with('message','Do not try to be too smart!');
        }
    }

    public function company_pf_update(Request $request,$id) {
        $currencies = Currency::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $company_pf = ProvidentFund::where('id',$id)->first();
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
        $all_employee       = '';

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
            if(!in_array("All", $request->employee_id)) {
                $employee_id        = $request->employee_id;
                $employment_infos   = $employment_infos->whereIn('employees.employee_id',$request->employee_id);
            }
        }

        $employment_infos       = $employment_infos->get();

        if($request->employee_id != "") {
            if(in_array("All", $request->employee_id)) {
                foreach($employment_infos as $employment_info) {
                    $employee_id[]      = $employment_info->employee_id;
                }
                $all_employee = 'All';
            }
        }

        return view('transactions.payroll.absent_deduction.add',compact('departments','projects','branches',
        'department_id','branch_id','project_id','employment_infos','month','year','employee_id','all_employee'));
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

    //Gratuity Amount
    public function gratuity_index() {
        $gratuities = Gratuity::where('company_id',Auth::user()->company_id)->where('status',0)->orderBy('id','desc')->paginate(10);
        return view('transactions.payroll.gratuity.index',compact('gratuities'));
    }

    public function gratuity_create(Request $request) {
        $employment_infos       = EmploymentInfo::orderBy('employment_infos.id','asc')->join('employees','employees.id','employment_infos.employee_id')->where('employees.company_id',Auth::user()->company_id);
        $departments            = Department::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $projects               = Project::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $branches               = Branch::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();

        $department_id          = '';
        $project_id             = '';
        $branch_id              = '';
        $year                   = '';
        $employee_id            = [];
        $all_employee           = '';

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

        if($request->year != ""){
            $year               = $request->year;
        }

        if($request->employee_id != "") {
            if(!in_array("All", $request->employee_id)) {
                $employment_infos   = $employment_infos->whereIn('employees.employee_id',$request->employee_id);
                $employee_id        = $request->employee_id;
            }
        }

        $employment_infos   = $employment_infos->get();

        if($request->employee_id != "") {
            if(in_array("All", $request->employee_id)) {
                foreach($employment_infos as $employment_info) {
                    $employee_id[]      = $employment_info->employee_id;
                }
                $all_employee = 'All';
            }
        }

        return view('transactions.payroll.gratuity.add',compact('departments','projects','branches',
        'employee_id','department_id','project_id','branch_id','year','employment_infos','all_employee'));
    }

    public function gratuity_store(Request $request){
        $interval = count($request->gratuity_amount);
        for($i = 0; $i < $interval; $i++) {
            if($request->gratuity_amount[$i] !=''){

                $count_gratuity = Gratuity::where('employee_id',$request->employee_id[$i])->where('year',$request->store_year)->first();
                if($count_gratuity !=""){
                    $gratuity_amount = Gratuity::where('employee_id',$request->employee_id[$i])->where('year',$request->store_year)->delete();
                }

                $gratuity = new Gratuity();
                $gratuity->company_id     = Auth::user()->company_id;
                $gratuity->employee_id    = $request->employee_id[$i];
                $gratuity->amount         = $request->gratuity_amount[$i];
                $gratuity->year           = $request->store_year;
                $gratuity->status         = 0;
                $gratuity->save();
            }
        }
        return redirect('gratuity')->with('message','Gratuity Created successfully!');
    }

    public function gratuity_pay_index(Request $request) {
        $employment_infos       = EmploymentInfo::orderBy('employment_infos.id','asc')->join('employees','employees.id','employment_infos.employee_id')->where('employees.company_id',Auth::user()->company_id);
        $departments            = Department::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $projects               = Project::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();
        $branches               = Branch::where('company_id',Auth::user()->company_id)->orderBy('id','asc')->get();

        $department_id          = '';
        $project_id             = '';
        $branch_id              = '';
        $employee_id            = '';
        $increment_employee_id  = '';
        $gratuities             = [];
        $gratuity_opening_balance   = 0;

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
            $payroll_info           = PayrollInfo::where('employee_id',$increment_employee_id)->first();
            if($payroll_info != "") {
                $gratuity_opening_balance     = $gratuity_opening_balance + $payroll_info->gratuity_opening_balance;
            }

            $gratuities             = Gratuity::where('company_id',Auth::user()->company_id)
                                    ->where('employee_id',$increment_employee_id)
                                    ->where('status',0)->get();
        }

        $employment_infos = $employment_infos->get();

        return view('transactions.payroll.gratuity.pay',compact('departments','projects','branches','department_id',
        'project_id','branch_id','employee_id','employment_infos','gratuities','increment_employee_id','gratuity_opening_balance'));
    }

    public function gratuity_pay_store($employee_id) {
        $gratuities    = Gratuity::where('company_id',Auth::user()->company_id)
                        ->where('employee_id',$employee_id)
                        ->where('status',0)->get();
        foreach($gratuities as $gratuity) {
            $gratuity->status = 1;
            $gratuity->save();
        }

        $payroll_info = PayrollInfo::where('employee_id',$employee_id)->first();
        if($payroll_info != "") {
            $payroll_info->gratuity_opening_balance   = 0;
            $payroll_info->save();
        }

        return redirect('gratuity')->with('message','Gratuity paid successfully!');
    }

    public function gratuity_delete($id) {
        $gratuity = Gratuity::find($id);
        if($gratuity->company_id == Auth::user()->company_id){
            $gratuity->delete();
            return redirect('gratuity')->with('message','Gratuity Deleted Successfully!');
        }else{
            return redirect('gratuity')->with('message','Do not try to be too smart!');
        }
    }

    public function gratuity_update(Request $request,$id) {
        $gratuity = Gratuity::where('id',$id)->first();
        if($request->amount != "") {
            $gratuity->year           = $request->year;
            $gratuity->amount         = $request->amount;
            $gratuity->save();

            return redirect('gratuity')->with('message','Gratuity Updated Successfully!');
        }
        return view('transactions.payroll.gratuity.update',compact('gratuity'));
    }

    public function deposit_salary_tax() {
        $taxes = DepositSalaryTax::where('company_id',Auth::user()->company_id)->orderBy('id','desc')->paginate(10);
        return view('transactions.payroll.deposit_salary_tax.index',compact('taxes'));
    }

    public function deposit_salary_tax_add(Request $request) {
        $departments            = Department::where('company_id',Auth::user()->company_id)->orderby('name','asc')->get();
        $projects               = Project::where('company_id',Auth::user()->company_id)->orderby('name','asc')->get();
        $branches               = Branch::where('company_id',Auth::user()->company_id)->orderby('name','asc')->get();
        $currencies             = Currency::where('company_id',Auth::user()->company_id)->orderby('id','asc')->get();
        $total_tax              = 0;
        $total_taka             = 0;
        $total_poisa            = 0;

        $employment_infos       = EmploymentInfo::orderBy('income_taxes.query_date','asc')
                                ->select('employees.name','employees.employee_id as original_employee_id','employment_infos.employee_id','employment_infos.department_id','employment_infos.project_id','employment_infos.branch_id','income_taxes.*')
                                ->join('income_taxes','income_taxes.employee_id','employment_infos.employee_id')
                                ->join('employees','employees.id','employment_infos.employee_id')
                                ->where('employees.company_id',Auth::user()->company_id);

        if($request->department_id != ""){
            $employment_infos   = $employment_infos->where('department_id',$request->department_id);
        }

        if($request->project_id != ""){
            $employment_infos   = $employment_infos->where('project_id',$request->project_id);
        }

        if($request->branch_id != ""){
            $employment_infos   = $employment_infos->where('branch_id',$request->branch_id);
        }

        if($request->currency_id != ""){
            $employment_infos   = $employment_infos->where('currency_id',$request->currency_id);
        }

        if($request->from != "" && $request->to != ""){
            $from       = date('Y-m-01',strtotime($request->from));
            $to         = date('Y-m-31',strtotime($request->to));

            $employment_infos   = $employment_infos->whereBetween('query_date', [$from, $to]);
            $employment_infos   = $employment_infos->where('status',0)->get();

            foreach($employment_infos as $income_tax) {
                $total_tax = $total_tax + $income_tax->amount;
            }
            $total_taka  = floor($total_tax);
            $poisa = ($total_tax) - $total_taka;
            if($poisa > 0) {
                $final = substr($poisa,2);
                $length = strlen($final);
                if($length > 2) {
                    $cutting = $length - 2;
                    $full_final = substr($final,0,-$cutting);
                    $total_poisa = $full_final;
                }else{
                    $total_poisa = $final;
                }
            }else{
                $total_poisa = 00;
            }
        }

        
        if($request->from != "") {
            $code_no                = GeneralSetting::where('company_id',Auth::user()->company_id)->first();
            if($code_no != "") {
                if($code_no->tax_chalan_code) {
                    $code_no = $code_no->tax_chalan_code;
                }else{
                    return redirect('deposit-salary-tax')->with('error','Please Update Your General Settings First!');
                }
            }else{
                return redirect('deposit-salary-tax')->with('error','Please Update Your General Settings First!');
            }
            
            $tax = new DepositSalaryTax();
            $tax->company_id        = Auth::user()->company_id;
            $tax->from              = date('F-Y', strtotime($request->from));
            $tax->to                = date('F-Y', strtotime($request->to));
            $tax->department_id     = $request->department_id;
            $tax->project_id        = $request->project_id;
            $tax->branch_id         = $request->branch_id;
            $tax->currency_id       = $request->currency_id;
            $tax->challan_no        = $request->challan_no;
            $tax->text_1            = $request->text_1;
            $tax->text_2            = $request->text_2;
            $tax->text_3            = $request->text_3;
            $tax->text_4            = $request->text_4;
            $tax->status            = 'Pending';
            if($request->hasFile('attachment')){  
                $tax->attachment    = $request->file('attachment')->store('deposit_salary_tax');
            }
            $tax->save();

            return view('transactions.payroll.deposit_salary_tax.print_front_side',compact('tax','code_no','employment_infos','total_taka','total_poisa','total_tax'));
        }
        return view('transactions.payroll.deposit_salary_tax.add',compact('departments','projects','branches','currencies'));
    }

    public function deposit_salary_tax_update($id) {
        $tax            = DepositSalaryTax::where('id',$id)->first();
        if($tax->status != "Pending") {
            return redirect('deposit-salary-tax')->with('message','Do not try to be too smart!');
        }
        return view('transactions.payroll.deposit_salary_tax.update',compact('tax'));
    }

    public function deposit_salary_tax_update_post(Request $request,$id) {
        $tax            = DepositSalaryTax::where('id',$id)->first();
        $tax->challan_no        = $request->challan_no;
        $tax->text_1            = $request->text_1;
        $tax->text_2            = $request->text_2;
        $tax->text_3            = $request->text_3;
        $tax->text_4            = $request->text_4;
        $tax->save();
        return redirect('deposit-salary-tax')->with('message','Deposit Salary Tax Updated Successfully!');
    }

    public function deposit_salary_tax_status($status,$id) {
        if($status == "Approved") {
            $tax            = DepositSalaryTax::where('id',$id)->first();
            $tax->status    = "Approved";
            $tax->save();

            $from           = date('Y-m-01',strtotime($tax->from));
            $to             = date('Y-m-31',strtotime($tax->to));

            $employees      = EmploymentInfo::orderBy('id','asc');

            if($tax->department_id != "") {
                $employees  = $employees->where('department_id',$tax->department_id);
            }
        
            if($tax->project_id !="") {
                $employees  = $employees->where('project_id',$tax->project_id);
            }
        
            if($tax->branch_id !="") {
                $employees  = $employees->where('branch_id',$tax->branch_id);
            }
        
            $employees      = $employees->get();
        
            $employee_ids   = array();
        
            foreach($employees as $employee) {
                $employee_ids[] = $employee->employee_id;
            }
        
            $income_taxes      = IncomeTax::where('company_id',Auth::user()->company_id)->whereIn('employee_id',$employee_ids)
                                ->whereBetween('query_date', [$from, $to])->where('status',0);
        
            if($tax->currency_id !="") {
                $income_taxes  = $income_taxes->where('currency_id',$tax->currency_id);
            }

            $income_taxes  = $income_taxes->get();

            foreach($income_taxes as $income_tax) {
                $income_tax->status = 1;
                $income_tax->save();
            }

        }elseif($status == "Cancelled") {
            $tax            = DepositSalaryTax::where('id',$id)->first();
            $tax->status    = "Cancelled";
            $tax->save();
        }
        return redirect('deposit-salary-tax')->with('message','Deposit Salary Tax '.$status.' Successfully!');
    }

    public function deposit_salary_tax_upload_file(Request $request,$tax_id) {
        $tax = DepositSalaryTax::where('id',$tax_id)->first();
        if($request->hasFile('attachment'))
        {
            if($tax->attachment != ""){
                foreach(json_decode($tax->attachment) as $upload_file) {
                    Storage::delete('deposit_salary_tax/'.$upload_file);
                }
            }
            $attach_file = [];
            foreach($request->file('attachment') as $file)
            {
                $filesize = filesize($file);
                $filesize_in_kb = $filesize / 1024;
                if($filesize_in_kb <= 2048) {
                    $custom_name    = md5(uniqid(rand(), true)).$tax->company_id.'.'.$file->getClientOriginalExtension();
                    $file->move('storage/deposit_salary_tax/', $custom_name);
                    array_push($attach_file, $custom_name);
                }
            }
            $tax->attachment = json_encode($attach_file);
            $tax->save();
            return redirect('deposit-salary-tax')->with('message','Files Uploaded Successfully!');
        }
        return view('transactions.payroll.deposit_salary_tax.upload_file',compact('tax_id'));
    }

    public function deposit_salary_tax_print_frontside($tax_id) {
        $code_no                = GeneralSetting::where('company_id',Auth::user()->company_id)->first();
        if($code_no != "") {
            if($code_no->tax_chalan_code) {
                $code_no = $code_no->tax_chalan_code;
            }else{
                return redirect('deposit-salary-tax')->with('error','Please Update Your General Settings First!');
            }
        }else{
            return redirect('deposit-salary-tax')->with('error','Please Update Your General Settings First!');
        }

        $tax = DepositSalaryTax::where('id',$tax_id)->first();
        $from           = date('Y-m-01',strtotime($tax->from));
        $to             = date('Y-m-31',strtotime($tax->to));
        $total_tax      = 0;
        $total_taka     = 0;
        $total_poisa    = 0;

        $employees      = EmploymentInfo::orderBy('id','asc');

        if($tax->department_id != "") {
            $employees  = $employees->where('department_id',$tax->department_id);
        }

        if($tax->project_id !="") {
            $employees  = $employees->where('project_id',$tax->project_id);
        }

        if($tax->branch_id !="") {
            $employees  = $employees->where('branch_id',$tax->branch_id);
        }

        $employees      = $employees->get();

        $employee_ids   = array();

        foreach($employees as $employee) {
            $employee_ids[] = $employee->employee_id;
        }

        $income_taxes   = IncomeTax::where('company_id',Auth::user()->company_id)->whereIn('employee_id',$employee_ids)
                        ->whereBetween('query_date', [$from, $to]);

        if($tax->currency_id !="") {
            $income_taxes  = $income_taxes->where('currency_id',$tax->currency_id);
        }

        $income_taxes  = $income_taxes->get();

        foreach($income_taxes as $income_tax) {
            $total_tax = $total_tax + $income_tax->amount;
        }
        $total_taka  = floor($total_tax);
        $poisa = ($total_tax) - $total_taka;
        if($poisa > 0) {
            $final = substr($poisa,2);
            $length = strlen($final);
            if($length > 2) {
                $cutting = $length - 2;
                $full_final = substr($final,0,-$cutting);
                $total_poisa = $full_final;
            }else{
                $total_poisa = $final;
            }
        }else{
            $total_poisa = 00;
        }

        return view('transactions.payroll.deposit_salary_tax.print_front_side',compact('tax','code_no','total_poisa','total_taka','total_tax'));
    }

    public function deposit_salary_tax_print_backside($tax_id) {
        $tax = DepositSalaryTax::where('id',$tax_id)->first();
        $from           = date('Y-m-01',strtotime($tax->from));
        $to             = date('Y-m-31',strtotime($tax->to));

        $employment_infos       = EmploymentInfo::orderBy('income_taxes.query_date','asc')
                                ->select('employees.name','employees.employee_id as original_employee_id','employment_infos.employee_id','employment_infos.department_id','employment_infos.project_id','employment_infos.branch_id','income_taxes.*')
                                ->join('income_taxes','income_taxes.employee_id','employment_infos.employee_id')
                                ->join('employees','employees.id','employment_infos.employee_id')
                                ->where('employees.company_id',Auth::user()->company_id);

        if($tax->department_id != ""){
        $employment_infos   = $employment_infos->where('department_id',$tax->department_id);
        }

        if($tax->project_id != ""){
            $employment_infos   = $employment_infos->where('project_id',$tax->project_id);
        }

        if($tax->branch_id != ""){
            $employment_infos   = $employment_infos->where('branch_id',$tax->branch_id);
        }

        if($tax->currency_id != ""){
            $employment_infos   = $employment_infos->where('currency_id',$tax->currency_id);
        }

        $employment_infos   = $employment_infos->whereBetween('query_date', [$from, $to])->get();

        return view('transactions.payroll.deposit_salary_tax.print_back_side',compact('employment_infos'));
    }
}
