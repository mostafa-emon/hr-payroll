<style>
    .remove-space{ padding:0px;padding-right:5px; }
</style>

<form method="POST" action="{{url('employee/update-payroll-info/'.$employee_id)}}">
{{ csrf_field() }}
<input type="hidden" name="employee_id" value="{{$employee_id}}"/>

<div style="font-weight:bold;background:black;color:white;margin-left:-12px;width:12%;text-align:center;">
    EARNINGS
</div>

<div id="earnings">
    @if(count($earnings) > 0) @php $sl = 0; @endphp
        @foreach($earnings as $earning) @php $sl = $sl + 1; @endphp
        <div class="row pd-t-10" id="earnings_{{$sl}}">
            <div class="col-md-4 remove-space" id="component_{{$sl}}">
                <select class="form-control" name="salary_component_id[]">
                    <option value="" label>component</option>
                    @foreach($earning_components as $component)
                        <option value="{{$component->id}}" @if($component->id == $earning->salary_component_id) selected @endif>{{$component->component_name}}</option>
                    @endforeach
                </select>
            </div>
        
            <div class="col-md-2 remove-space" id="cal_type_{{$sl}}"> 
                <select class="form-control" name="fixed_or_percentage[]" id="fixed_or_percentage_1" onchange="fixed_or_percentage(this.value,'{{$sl}}')">
                    <option value="fixed" @if($earning->fixed_or_percentage == "fixed") selected @endif>fixed amount</option>
                    <option value="variable" @if($earning->fixed_or_percentage == "variable") selected @endif>variable amount</option>
                </select>
            </div>
        
            <div class="col-md-2 remove-space" id="percentage_{{$sl}}" @if($earning->fixed_or_percentage == "fixed") style="display:none" @endif>
                <input type="text" class="form-control" name="percentage_amount[]" placeholder="percentage, Ex:5" value="{{$earning->percentage_amount}}"/>
            </div>
        
            <div class="col-md-3 remove-space" id="of_component_{{$sl}}" @if($earning->fixed_or_percentage == "fixed") style="display:none" @endif>
                <select class="form-control" name="of_component_id[]">
                    <option value="" label>% of component</option>
                    @foreach($earning_components as $component)
                        <option value="{{$component->id}}" @if($earning->of_component_id == $component->id) selected @endif>{{$component->component_name}}</option>
                    @endforeach
                </select>
            </div>
        
            <div class="col-md-5 remove-space" id="amount_{{$sl}}" @if($earning->fixed_or_percentage != "fixed") style="display:none" @endif>
                <input type="text" class="form-control" name="final_amount[]" placeholder="amount" value="{{$earning->final_amount}}"/>
            </div>
        
            <div class="col-md-1" style="padding:0px;">
                <a href="javascript:void(0)" class="btn btn-success" onclick="add_earning_row()" style="width:15px;padding-left:7px;margin-left:3px"><i class="fa fa-plus-circle"></i></a>
                <a href="javascript:void(0)" class="btn btn-danger" onclick="remove_earning_row('{{$sl}}')" style="width:15px;padding-left:7px;"><i class="fa fa-minus-circle"></i></a>
            </div>
        </div>
        @endforeach
    @else
    <div class="row pd-t-10" id="earnings_1">
        <div class="col-md-4 remove-space" id="component_1">
            <select class="form-control" name="salary_component_id[]">
                <option value="" label>component</option>
                @foreach($earning_components as $component)
                    <option value="{{$component->id}}">{{$component->component_name}}</option>
                @endforeach
            </select>
        </div>
    
        <div class="col-md-2 remove-space" id="cal_type_1"> 
            <select class="form-control" name="fixed_or_percentage[]" id="fixed_or_percentage_1" onchange="fixed_or_percentage(this.value,1)">
                <option value="fixed">fixed amount</option>
                <option value="variable">variable amount</option>
            </select>
        </div>
    
        <div class="col-md-2 remove-space" id="percentage_1" style="display:none">
            <input type="text" class="form-control" name="percentage_amount[]" placeholder="percentage, Ex:5"/>
        </div>
    
        <div class="col-md-3 remove-space" id="of_component_1" style="display:none">
            <select class="form-control" name="of_component_id[]">
                <option value="" label>% of component</option>
                @foreach($earning_components as $component)
                    <option value="{{$component->id}}">{{$component->component_name}}</option>
                @endforeach
            </select>
        </div>
    
        <div class="col-md-5 remove-space" id="amount_1">
            <input type="text" class="form-control" name="final_amount[]" placeholder="amount"/>
        </div>
    
        <div class="col-md-1" style="padding:0px;">
            <a href="javascript:void(0)" class="btn btn-success" onclick="add_earning_row()" style="width:15px;padding-left:7px;margin-left:3px"><i class="fa fa-plus-circle"></i></a>
            <a href="javascript:void(0)" class="btn btn-danger" onclick="remove_earning_row(1)" style="width:15px;padding-left:7px;"><i class="fa fa-minus-circle"></i></a>
        </div>
    </div>
    @endif
</div>




<div style="font-weight:bold;background:black;color:white;margin-top:25px;margin-left:-12px;width:12%;text-align:center;">
    DEDUCTIONS
</div>

<div id="deductions">
    @if(count($deductions) > 0) @php $serial = 0; @endphp
        @foreach($deductions as $deduction) @php $serial = $serial + 1; @endphp
        <div class="row pd-t-10" id="deductions_{{$serial}}">
            <div class="col-md-4 remove-space" id="ded_component_{{$serial}}">
                <select class="form-control" name="ded_salary_component_id[]">
                    <option value="" label>component</option>
                    @foreach($deduction_components as $component)
                        <option value="{{$component->id}}" @if($component->id == $deduction->salary_component_id) selected @endif>{{$component->component_name}}</option>
                    @endforeach
                </select>
            </div>
        
            <div class="col-md-2 remove-space" id="ded_cal_type_{{$serial}}"> 
                <select class="form-control" name="ded_fixed_or_percentage[]" id="ded_fixed_or_percentage_1" onchange="ded_fixed_or_percentage(this.value,'{{$serial}}')">
                    <option value="fixed" @if($deduction->fixed_or_percentage == "fixed") selected @endif>fixed amount</option>
                    <option value="variable" @if($deduction->fixed_or_percentage == "variable") selected @endif>variable amount</option>
                </select>
            </div>
        
            <div class="col-md-2 remove-space" id="ded_percentage_{{$serial}}" @if($deduction->fixed_or_percentage == "fixed") style="display:none" @endif>
                <input type="text" class="form-control" name="ded_percentage_amount[]" placeholder="percentage, Ex:5" value="{{$deduction->percentage_amount}}"/>
            </div>
        
            <div class="col-md-3 remove-space" id="ded_of_component_{{$serial}}" @if($deduction->fixed_or_percentage == "fixed") style="display:none" @endif>
                <select class="form-control" name="ded_of_component_id[]">
                    <option value="" label>% of component</option>
                    @foreach($earning_components as $component)
                        <option value="{{$component->id}}" @if($deduction->of_component_id == $component->id) selected @endif>{{$component->component_name}}</option>
                    @endforeach
                </select>
            </div>
        
            <div class="col-md-5 remove-space" id="ded_amount_{{$serial}}" @if($deduction->fixed_or_percentage != "fixed") style="display:none" @endif>
                <input type="text" class="form-control" name="ded_final_amount[]" placeholder="amount" value="{{$deduction->final_amount}}"/>
            </div>
        
            <div class="col-md-1" style="padding:0px;">
                <a href="javascript:void(0)" class="btn btn-success" onclick="add_deduction_row()" style="width:15px;padding-left:7px;margin-left:3px"><i class="fa fa-plus-circle"></i></a>
                <a href="javascript:void(0)" class="btn btn-danger" onclick="remove_deduction_row('{{$serial}}')" style="width:15px;padding-left:7px;"><i class="fa fa-minus-circle"></i></a>
            </div>
        </div>
        @endforeach
    @else
        <div class="row pd-t-10" id="deductions_1">
            <div class="col-md-4 remove-space" id="ded_component_1">
                <select class="form-control" name="ded_salary_component_id[]">
                    <option value="" label>component</option>
                    @foreach($deduction_components as $component)
                        <option value="{{$component->id}}">{{$component->component_name}}</option>
                    @endforeach
                </select>
            </div>
        
            <div class="col-md-2 remove-space" id="ded_cal_type_1"> 
                <select class="form-control" name="ded_fixed_or_percentage[]" id="ded_fixed_or_percentage_1" onchange="ded_fixed_or_percentage(this.value,1)">
                    <option value="fixed">fixed amount</option>
                    <option value="variable">variable amount</option>
                </select>
            </div>
        
            <div class="col-md-2 remove-space" id="ded_percentage_1" style="display:none;">
                <input type="text" class="form-control" name="ded_percentage_amount[]" placeholder="percentage, Ex:5"/>
            </div>
        
            <div class="col-md-3 remove-space" id="ded_of_component_1" style="display:none">
                <select class="form-control" name="ded_of_component_id[]">
                    <option value="" label>% of component</option>
                    @foreach($earning_components as $component)
                        <option value="{{$component->id}}">{{$component->component_name}}</option>
                    @endforeach
                </select>
            </div>
        
            <div class="col-md-5 remove-space" id="ded_amount_1">
                <input type="text" class="form-control" name="ded_final_amount[]" placeholder="amount"/>
            </div>
        
            <div class="col-md-1" style="padding:0px;">
                <a href="javascript:void(0)" class="btn btn-success" onclick="add_deduction_row()" style="width:15px;padding-left:7px;margin-left:3px"><i class="fa fa-plus-circle"></i></a>
                <a href="javascript:void(0)" class="btn btn-danger" onclick="remove_deduction_row(1)" style="width:15px;padding-left:7px;"><i class="fa fa-minus-circle"></i></a>
            </div>
        </div>
    @endif
</div>

<div style="font-weight:bold;background:black;color:white;margin-top:25px;margin-left:-12px;width:12%;text-align:center;">
    Others
</div>

<div class="row">
    <div class="col-md-4 mg-t-10 remove-space">
        <label for="company_pf_on_salary_statement" style="font-weight:bold;" class="col-form-label">Company PF on Salary Statement:</label>
        <select class="form-control" name="company_pf_on_salary_statement">
            <option value="" label>Company PF on Salary Statement</option>
            <option value="1" @if($payroll_info !="" && $payroll_info->company_pf_on_salary_statement == "1") selected @endif>Yes</option>
            <option value="0" @if($payroll_info !="" && $payroll_info->company_pf_on_salary_statement == "0") selected @endif>No</option>
        </select>
    </div>

    <div class="col-md-4 mg-t-10 remove-space">
        <label for="festival_bonus_per_festival" style="font-weight:bold;" class="col-form-label">Festival Bonus:</label>
        <input type="text" class="form-control" name="festival_bonus_per_festival" placeholder="Festival Bonus" @if($payroll_info !="") value="{{$payroll_info->festival_bonus_per_festival}}" @endif/>
    </div>

    <div class="col-md-4 mg-t-10 remove-space">
        <label for="gratuity_amount" style="font-weight:bold;" class="col-form-label">Gratuity Amount:</label>
        <input type="text" class="form-control" name="gratuity_amount" placeholder="Gratuity Amount" @if($payroll_info !="") value="{{$payroll_info->gratuity_amount}}" @endif/>
    </div>

    <div class="col-md-4 mg-t-10 remove-space">
        <label for="investment_amount" style="font-weight:bold;" class="col-form-label">Investment Amount:</label>
        <input type="text" class="form-control" name="investment_amount" placeholder="Investment Amount" @if($payroll_info !="") value="{{$payroll_info->investment_amount}}" @endif/>
    </div>

    <div class="col-md-4 mg-t-10 remove-space">
        <label for="ot_allowed" style="font-weight:bold;" class="col-form-label">Allow OT:</label>
        <select class="form-control" name="ot_allowed">
            <option value="" label>Allow OT</option>
            <option value="1" @if($payroll_info !="" && $payroll_info->ot_allowed == "1") selected @endif>Yes</option>
            <option value="0" @if($payroll_info !="" && $payroll_info->ot_allowed == "0") selected @endif>No</option>
        </select>
    </div>

    <div class="col-md-4 mg-t-10 remove-space">
        <label for="hourly_ot_rate" style="font-weight:bold;" class="col-form-label">Hourly OT Rate:</label>
        <input type="text" class="form-control" name="hourly_ot_rate" placeholder="Hourly OT Rate" @if($payroll_info !="") value="{{$payroll_info->hourly_ot_rate}}" @endif/>
    </div>
</div>

<div class="row">
    <div class="col-md-6 pd-t-10">
        <input type="submit" value="Update & Next" class="btn btn-primary"/>
    </div>

    <div class="col-md-6 pd-t-10 text-right">
        <a href="{{url('employee/update/leave/'.$employee_id)}}" style="font-size: 15px;" class="btn btn-primary">Next</a>
    </div>
</div>

</form>

<script>
    var earnings    = {{count($earnings)}};
    if(earnings == "" || earnings == 0) { earnings = 1;}

    var deductions  = {{count($deductions)}};
    if(deductions == "" || deductions == 0) { deductions = 1;};

    function add_earning_row(){
        earnings = earnings + 1;
        $('#earnings').append('<div class="row pd-t-10" id="earnings_'+earnings+'"><div class="col-md-4 remove-space" id="component_'+earnings+'"><select class="form-control" name="salary_component_id[]"><option value="" label>component</option>@foreach($earning_components as $component)<option value="{{$component->id}}">{{$component->component_name}}</option>@endforeach</select></div><div class="col-md-2 remove-space" id="cal_type_'+earnings+'"><select class="form-control" name="fixed_or_percentage[]" id="fixed_or_percentage_'+earnings+'" onchange="fixed_or_percentage(this.value,'+earnings+')"><option value="fixed">fixed amount</option><option value="variable">variable amount</option></select></div><div class="col-md-2 remove-space" id="percentage_'+earnings+'" style="display:none"><input type="text" class="form-control" name="percentage_amount[]" placeholder="percentage, Ex:5"/></div><div class="col-md-3 remove-space" id="of_component_'+earnings+'" style="display:none"><select class="form-control" name="of_component_id[]"><option value="" label>% of component</option>@foreach($earning_components as $component)<option value="{{$component->id}}">{{$component->component_name}}</option>@endforeach</select></div><div class="col-md-5 remove-space" id="amount_'+earnings+'"><input type="text" class="form-control" name="final_amount[]" placeholder="amount"/></div><div class="col-md-1" style="padding:0px;"><a href="javascript:void(0)" class="btn btn-success" onclick="add_earning_row()" style="width:15px;padding-left:7px;margin-left:3px;margin-right:5px"><i class="fa fa-plus-circle"></i></a><a href="javascript:void(0)" class="btn btn-danger" onclick="remove_earning_row('+earnings+')" style="width:15px;padding-left:7px;"><i class="fa fa-minus-circle"></i></a></div></div>');
    }

    function remove_earning_row(idValue) {
        var myobj = document.getElementById("earnings_"+idValue);
        myobj.remove();
    }

    function add_deduction_row(){
        deductions = deductions + 1;
        $('#deductions').append('<div class="row pd-t-10" id="deductions_'+deductions+'"><div class="col-md-4 remove-space" id="ded_component_'+deductions+'"><select class="form-control" name="ded_salary_component_id[]"><option value="" label>component</option>@foreach($deduction_components as $component)<option value="{{$component->id}}">{{$component->component_name}}</option>@endforeach</select></div><div class="col-md-2 remove-space" id="ded_cal_type_'+deductions+'"><select class="form-control" name="ded_fixed_or_percentage[]" id="ded_fixed_or_percentage_'+deductions+'" onchange="ded_fixed_or_percentage(this.value,'+deductions+')"><option value="fixed">fixed amount</option><option value="variable">variable amount</option></select></div><div class="col-md-2 remove-space" id="ded_percentage_'+deductions+'" style="display:none"><input type="text" class="form-control" name="ded_percentage_amount[]" placeholder="percentage, Ex:5"/></div><div class="col-md-3 remove-space" id="ded_of_component_'+deductions+'" style="display:none"><select class="form-control" name="ded_of_component_id[]"><option value="" label>% of component</option>@foreach($earning_components as $component)<option value="{{$component->id}}">{{$component->component_name}}</option>@endforeach</select></div><div class="col-md-5 remove-space" id="ded_amount_'+deductions+'"><input type="text" class="form-control" name="ded_final_amount[]" placeholder="amount"/></div><div class="col-md-1" style="padding:0px;"><a href="javascript:void(0)" class="btn btn-success" onclick="add_deduction_row()" style="width:15px;padding-left:7px;margin-left:3px;margin-right:5px"><i class="fa fa-plus-circle"></i></a><a href="javascript:void(0)" class="btn btn-danger" onclick="remove_deduction_row('+deductions+')" style="width:15px;padding-left:7px;"><i class="fa fa-minus-circle"></i></a></div></div>');
    }

    function remove_deduction_row(idValue) {
        var myobj = document.getElementById("deductions_"+idValue);
        myobj.remove();
    }

    function fixed_or_percentage(selection,idValue){
        if(selection == "variable") {
            $('#percentage_'+idValue).show();
            $('#of_component_'+idValue).show();
            $('#amount_'+idValue).hide();
        }else{
            $('#percentage_'+idValue).hide();
            $('#of_component_'+idValue).hide();
            $('#amount_'+idValue).show();
        }
    }

    function ded_fixed_or_percentage(selection,idValue){
        if(selection == "variable") {
            $('#ded_percentage_'+idValue).show();
            $('#ded_of_component_'+idValue).show();
            $('#ded_amount_'+idValue).hide();
        }else{
            $('#ded_percentage_'+idValue).hide();
            $('#ded_of_component_'+idValue).hide();
            $('#ded_amount_'+idValue).show();
        }
    }
</script>