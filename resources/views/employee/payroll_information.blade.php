<style>
    .remove-space{ padding:0px;padding-right:5px; }
</style>

<form method="POST" action="{{url('employee/add-payroll-info')}}">
{{ csrf_field() }}
<input type="hidden" name="employee_id" value="{{$employee_id}}"/>

<div style="font-weight:bold;background:black;color:white;margin-left:-12px;width:12%;text-align:center;">
    EARNINGS
</div>

<div id="earnings">
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
</div>

<div style="font-weight:bold;background:black;color:white;margin-top:25px;margin-left:-12px;width:12%;text-align:center;">
    DEDUCTIONS
</div>

<div id="deductions">
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
</div>

<div style="font-weight:bold;background:black;color:white;margin-top:25px;margin-left:-12px;width:12%;text-align:center;">
    Others
</div>

<div class="row">
    <div class="col-md-4 mg-t-10 remove-space">
        <select class="form-control" name="company_pf_on_salary_statement">
            <option value="" label>Company PF on Salary Statement</option>
            <option value="1">Yes</option>
            <option value="0">No</option>
        </select>
    </div>

    <div class="col-md-4 mg-t-10 remove-space">
        <input type="text" class="form-control" name="festival_bonus_per_festival" placeholder="Festival Bonus"/>
    </div>

    <div class="col-md-4 mg-t-10 remove-space">
        <input type="text" class="form-control" name="gratuity_amount" placeholder="Gratuity Amount"/>
    </div>

    <div class="col-md-4 mg-t-10 remove-space">
        <input type="text" class="form-control" name="investment_amount" placeholder="Investment Amount"/>
    </div>

    <div class="col-md-4 mg-t-10 remove-space">
        <select class="form-control" name="ot_allowed">
            <option value="" label>Allow OT</option>
            <option value="1">Yes</option>
            <option value="0">No</option>
        </select>
    </div>

    <div class="col-md-4 mg-t-10 remove-space">
        <input type="text" class="form-control" name="hourly_ot_rate" placeholder="Hourly OT Rate"/>
    </div>

    <div class="col-md-4 mg-t-10 remove-space">
        <select name="currency_id" class="form-control select2-no-search col-md-12 pa" required>
            <option value="" label>Salary Currency</option>
            @foreach($currencies as $currency)
                <option value="{{$currency->id}}">{{$currency->currency_name}}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-4 mg-t-10 remove-space">
        <select name="mark_overtime_if_work_in_holiday" class="form-control select2-no-search col-md-12 pa">
            <option value="" label>OT if Work on Holiday</option>
            <option value="1">Yes</option>
            <option value="0">No</option>
        </select>
    </div>

    <div class="col-md-4 mg-t-10 remove-space">
        <select name="mark_overtime_if_work_in_leave_day" class="form-control select2-no-search col-md-12 pa">
            <option value="" label>OT if Work on Leave Day</option>
            <option value="1">Yes</option>
            <option value="0">No</option>
        </select>
    </div>

</div>

<div class="row pd-t-30">
    <input type="submit" value="Submit" class="btn btn-primary"/>
</div>

</form>

<script>
    var earnings    = 1;
    var deductions  = 1;
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