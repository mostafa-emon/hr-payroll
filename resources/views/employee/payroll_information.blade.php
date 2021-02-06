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
            <select class="form-control" id="earning_component_1" name="salary_component_id[]" onchange="set_earnings_amount_class(1,this.value)">
                <option value="" label>Component</option>
                @foreach($earning_components as $component)
                    <option value="{{$component->id}}">{{$component->component_name}}</option>
                @endforeach
            </select>
        </div>
    
        <div class="col-md-2 remove-space" id="cal_type_1"> 
            <select class="form-control" name="fixed_or_percentage[]" id="fixed_or_percentage_1" onchange="fixed_or_percentage(this.value,1)">
                <option value="fixed">Fixed Amount</option>
                <option value="variable">Variable Amount</option>
            </select>
        </div>
    
        <div class="col-md-2 remove-space" id="percentage_1" style="display:none">
            <input type="text" class="form-control" id="percentage_amount_1" name="percentage_amount[]" placeholder="Percentage, Ex:5" oninput="is_basic_salary(1)"/>
        </div>
    
        <div class="col-md-2 remove-space" id="of_component_1" style="display:none">
            <select class="form-control" name="of_component_id[]" onchange="calculate_earnings_percentage_amount(1,this.value)">
                <option value="" label>% of Component</option>
                @foreach($earning_components as $component)
                    <option value="{{$component->id}}">{{$component->component_name}}</option>
                @endforeach
            </select>
        </div>
    
        <div class="col-md-1 remove-space" style="display:none" id="earnings_percentage_final_amount_div_1">
            <input type="text" class="form-control" id="earnings_percentage_final_amount_1" name="earnings_percentage_final_amount[]" placeholder="Amount"/>
        </div>

        <div class="col-md-5 remove-space" id="amount_1">
            <input type="text" id="earnings_final_amount_1" class="form-control" name="final_amount[]" placeholder="Amount" oninput="is_basic_salary(1)"/>
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
            <select class="form-control" name="ded_salary_component_id[]" onchange="set_deduction_amount_class(1,this.value)">
                <option value="" label>Component</option>
                @foreach($deduction_components as $component)
                    <option value="{{$component->id}}">{{$component->component_name}}</option>
                @endforeach
            </select>
        </div>
    
        <div class="col-md-2 remove-space" id="ded_cal_type_1"> 
            <select class="form-control" name="ded_fixed_or_percentage[]" id="ded_fixed_or_percentage_1" onchange="ded_fixed_or_percentage(this.value,1)">
                <option value="fixed">Fixed Amount</option>
                <option value="variable">Variable Amount</option>
            </select>
        </div>
    
        <div class="col-md-2 remove-space" id="ded_percentage_1" style="display:none;">
            <input type="text" class="form-control" id="ded_percentage_amount_1" name="ded_percentage_amount[]" placeholder="Percentage, Ex:5"/>
        </div>
    
        <div class="col-md-2 remove-space" id="ded_of_component_1" style="display:none">
            <select class="form-control" name="ded_of_component_id[]" onchange="calculate_deduction_percentage_amount(1,this.value)">
                <option value="" label>% of Component</option>
                @foreach($earning_components as $component)
                    <option value="{{$component->id}}">{{$component->component_name}}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-1 remove-space" style="display:none" id="deduction_percentage_final_amount_div_1">
            <input type="text" class="form-control" id="deduction_percentage_final_amount_1" name="deduction_percentage_final_amount[]" placeholder="Amount"/>
        </div>
    
        <div class="col-md-5 remove-space" id="ded_amount_1">
            <input type="text" class="form-control" id="deduction_final_amount_1" name="ded_final_amount[]" placeholder="Amount"/>
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
        <label for="festival_bonus_per_festival" style="font-weight:bold;" class="col-form-label">Festival Bonus*:</label>
        <input type="text" class="form-control" name="festival_bonus_per_festival" placeholder="Festival Bonus*" required/>
    </div>

    <div class="col-md-4 mg-t-10 remove-space">
        <label for="gratuity_amount" style="font-weight:bold;" class="col-form-label">Gratuity Amount*:</label>
        <input type="text" class="form-control" id="gratuity_amount" name="gratuity_amount" placeholder="Gratuity Amount*" required/>
    </div>

    <div class="col-md-4 mg-t-10 remove-space">
        <label for="company_pf_opening_balance" style="font-weight:bold;" class="col-form-label">Company PF Opening Balance*:</label>
        <input type="text" class="form-control" id="company_pf_opening_balance" name="company_pf_opening_balance" placeholder="Company PF Opening Balance*" required/>
    </div>

    <div class="col-md-4 mg-t-10 remove-space">
        <label for="employee_pf_opening_balance" style="font-weight:bold;" class="col-form-label">Employee PF Opening Balance*:</label>
        <input type="text" class="form-control" id="employee_pf_opening_balance" name="employee_pf_opening_balance" placeholder="Employee PF Opening Balance*" required/>
    </div>

    <div class="col-md-4 mg-t-10 remove-space">
        <label for="investment_amount" style="font-weight:bold;" class="col-form-label">Investment Amount*:</label>
        <input type="text" class="form-control" name="investment_amount" placeholder="Investment Amount*" required/>
    </div>

    <div class="col-md-4 mg-t-10 remove-space">
        <label for="ot_allowed" style="font-weight:bold;" class="col-form-label">Allow OT*:</label>
        <select class="form-control" name="ot_allowed" required>
            <option value="" label>Allow OT*</option>
            <option value="1">Yes</option>
            <option value="0">No</option>
        </select>
    </div>

    <div class="col-md-4 mg-t-10 remove-space">
        <label for="hourly_ot_rate" style="font-weight:bold;" class="col-form-label">Hourly OT Rate*:</label>
        <input type="text" class="form-control" name="hourly_ot_rate" placeholder="Hourly OT Rate*" required/>
    </div>

    <div class="col-md-4 mg-t-10 remove-space">
        <label for="ot_allowed" style="font-weight:bold;" class="col-form-label">Salary Currency*:</label>
        <select name="currency_id" class="form-control select2-no-search col-md-12 pa" required>
            <option value="" label>Salary Currency*</option>
            @foreach($currencies as $currency)
                <option value="{{$currency->id}}" @if($currency->id == $default_currency->id) selected @endif>{{$currency->currency_name}}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-4 mg-t-10 remove-space">
        <label for="ot_allowed" style="font-weight:bold;" class="col-form-label">OT if Work on Holiday*:</label>
        <select name="mark_overtime_if_work_in_holiday" class="form-control select2-no-search col-md-12 pa" required>
            <option value="" label>OT if Work on Holiday*</option>
            <option value="1">Yes</option>
            <option value="0">No</option>
        </select>
    </div>

    <div class="col-md-4 mg-t-10 remove-space">
        <label for="ot_allowed" style="font-weight:bold;" class="col-form-label">OT if Work on Leave Day*:</label>
        <select name="mark_overtime_if_work_in_leave_day" class="form-control select2-no-search col-md-12 pa" required>
            <option value="" label>OT if Work on Leave Day*</option>
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
        $('#earnings').append('<div class="row pd-t-10" id="earnings_'+earnings+'"><div class="col-md-4 remove-space" id="component_'+earnings+'"><select class="form-control" id="earning_component_'+earnings+'" name="salary_component_id[]" onchange="set_earnings_amount_class('+earnings+',this.value)"><option value="" label>Component</option>@foreach($earning_components as $component)<option value="{{$component->id}}">{{$component->component_name}}</option>@endforeach</select></div><div class="col-md-2 remove-space" id="cal_type_'+earnings+'"><select class="form-control" name="fixed_or_percentage[]" id="fixed_or_percentage_'+earnings+'" onchange="fixed_or_percentage(this.value,'+earnings+')"><option value="fixed">Fixed Amount</option><option value="variable">Variable Amount</option></select></div><div class="col-md-2 remove-space" id="percentage_'+earnings+'" style="display:none"><input type="text" class="form-control" id="percentage_amount_'+earnings+'" name="percentage_amount[]" oninput="is_basic_salary('+earnings+')" placeholder="Percentage, Ex:5"/></div><div class="col-md-2 remove-space" id="of_component_'+earnings+'" style="display:none"><select class="form-control" name="of_component_id[]" onchange="calculate_earnings_percentage_amount('+earnings+',this.value)"><option value="" label>% of Component</option>@foreach($earning_components as $component)<option value="{{$component->id}}">{{$component->component_name}}</option>@endforeach</select></div><div class="col-md-1 remove-space" style="display:none" id="earnings_percentage_final_amount_div_'+earnings+'"><input type="text" class="form-control" id="earnings_percentage_final_amount_'+earnings+'" name="earnings_percentage_final_amount[]" placeholder="Amount"/></div><div class="col-md-5 remove-space" id="amount_'+earnings+'"><input type="text" class="form-control" id="earnings_final_amount_'+earnings+'" name="final_amount[]" placeholder="Amount" oninput="is_basic_salary('+earnings+')"/></div><div class="col-md-1" style="padding:0px;"><a href="javascript:void(0)" class="btn btn-success" onclick="add_earning_row()" style="width:15px;padding-left:7px;margin-left:3px;margin-right:5px"><i class="fa fa-plus-circle"></i></a><a href="javascript:void(0)" class="btn btn-danger" onclick="remove_earning_row('+earnings+')" style="width:15px;padding-left:7px;"><i class="fa fa-minus-circle"></i></a></div></div>');
    }

    function remove_earning_row(idValue) {
        var myobj = document.getElementById("earnings_"+idValue);
        myobj.remove();
    }

    function add_deduction_row(){
        deductions = deductions + 1;
        $('#deductions').append('<div class="row pd-t-10" id="deductions_'+deductions+'"><div class="col-md-4 remove-space" id="ded_component_'+deductions+'"><select class="form-control" name="ded_salary_component_id[]" onchange="set_deduction_amount_class('+deductions+',this.value)"><option value="" label>Component</option>@foreach($deduction_components as $component)<option value="{{$component->id}}">{{$component->component_name}}</option>@endforeach</select></div><div class="col-md-2 remove-space" id="ded_cal_type_'+deductions+'"><select class="form-control" name="ded_fixed_or_percentage[]" id="ded_fixed_or_percentage_'+deductions+'" onchange="ded_fixed_or_percentage(this.value,'+deductions+')"><option value="fixed">Fixed Amount</option><option value="variable">Variable Amount</option></select></div><div class="col-md-2 remove-space" id="ded_percentage_'+deductions+'" style="display:none"><input type="text" class="form-control" id="ded_percentage_amount_'+deductions+'" name="ded_percentage_amount[]" placeholder="Percentage, Ex:5"/></div><div class="col-md-2 remove-space" id="ded_of_component_'+deductions+'" style="display:none"><select class="form-control" name="ded_of_component_id[]" onchange="calculate_deduction_percentage_amount('+deductions+',this.value)"><option value="" label>% of Component</option>@foreach($earning_components as $component)<option value="{{$component->id}}">{{$component->component_name}}</option>@endforeach</select></div><div class="col-md-1 remove-space" style="display:none" id="deduction_percentage_final_amount_div_'+deductions+'"><input type="text" class="form-control" id="deduction_percentage_final_amount_'+deductions+'" name="deduction_percentage_final_amount[]" placeholder="Amount"/></div><div class="col-md-5 remove-space" id="ded_amount_'+deductions+'"><input type="text" class="form-control" id="deduction_final_amount_'+deductions+'" name="ded_final_amount[]" placeholder="Amount"/></div><div class="col-md-1" style="padding:0px;"><a href="javascript:void(0)" class="btn btn-success" onclick="add_deduction_row()" style="width:15px;padding-left:7px;margin-left:3px;margin-right:5px"><i class="fa fa-plus-circle"></i></a><a href="javascript:void(0)" class="btn btn-danger" onclick="remove_deduction_row('+deductions+')" style="width:15px;padding-left:7px;"><i class="fa fa-minus-circle"></i></a></div></div>');
    }

    function remove_deduction_row(idValue) {
        var myobj = document.getElementById("deductions_"+idValue);
        myobj.remove();
    }

    function fixed_or_percentage(selection,idValue){
        if(selection == "variable") {
            $('#percentage_'+idValue).show();
            $('#of_component_'+idValue).show();
            $('#earnings_percentage_final_amount_div_'+idValue).show();
            $('#amount_'+idValue).hide();
        }else{
            $('#percentage_'+idValue).hide();
            $('#of_component_'+idValue).hide();
            $('#earnings_percentage_final_amount_div_'+idValue).hide();
            $('#amount_'+idValue).show();
        }
    }

    function ded_fixed_or_percentage(selection,idValue){
        if(selection == "variable") {
            $('#ded_percentage_'+idValue).show();
            $('#ded_of_component_'+idValue).show();
            $('#deduction_percentage_final_amount_div_'+idValue).show();
            $('#ded_amount_'+idValue).hide();
        }else{
            $('#ded_percentage_'+idValue).hide();
            $('#ded_of_component_'+idValue).hide();
            $('#deduction_percentage_final_amount_div_'+idValue).hide();
            $('#ded_amount_'+idValue).show();
        }
    }

    function calculate_earnings_percentage_amount(row_id,component_id) {
        var fixed_amount = $('.earnings_final_amount_component_'+component_id).val();
        var percentage = $('#percentage_amount_'+row_id).val();

        if(fixed_amount == "") {
            fixed_amount = 0;
        } 
        if(percentage == "") {
            percentage = 0;
        } 
        var is_fixed_amount_num = /^\d+$/.test(fixed_amount);
        var is_percentage_num = /^\d+$/.test(fixed_amount);

        if(!is_fixed_amount_num || !is_percentage_num) {
            var percentage_final_amount = 0;
        } else {
            var percentage_final_amount = Math.round((percentage/100)*fixed_amount);
        }
        
        $('#earnings_percentage_final_amount_'+row_id).val(percentage_final_amount)

        var main_component_id = $('#earning_component_'+row_id).val();
        var url = '/component-reference/'+main_component_id;
        $.ajax({
            type:'GET',
            url:url,
            success:function(response) {
                if(response == "Basic Salary") {
                    var fixed_or_perct = $('#fixed_or_percentage_'+row_id).val();
                    if(fixed_or_perct == "variable") {
                        $('#gratuity_amount').val(percentage_final_amount);
                    }
                }
            }
        });
    }

    function set_earnings_amount_class(row_id,component_id) {
        $('#earnings_final_amount_'+row_id).addClass('earnings_final_amount_component_'+component_id);
    }

    function calculate_deduction_percentage_amount(row_id,component_id) {
        var fixed_amount = $('.earnings_final_amount_component_'+component_id).val();
        var percentage = $('#ded_percentage_amount_'+row_id).val();

        if(fixed_amount == "") {
            fixed_amount = 0;
        } 
        if(percentage == "") {
            percentage = 0;
        } 
        var is_fixed_amount_num = /^\d+$/.test(fixed_amount);
        var is_percentage_num = /^\d+$/.test(fixed_amount);

        if(!is_fixed_amount_num || !is_percentage_num) {
            var percentage_final_amount = 0;
        } else {
            var percentage_final_amount = Math.round((percentage/100)*fixed_amount);
        }
        
        $('#deduction_percentage_final_amount_'+row_id).val(percentage_final_amount)
    }

    function set_deduction_amount_class(row_id,component_id) {
        $('#deduction_final_amount_'+row_id).addClass('deduction_final_amount_component_'+component_id);
    }

    function is_basic_salary(row_value) {
        var component_id = $('#earning_component_'+row_value).val();
        var url = '/component-reference/'+component_id;
        $.ajax({
            type:'GET',
            url:url,
            success:function(response) {
                if(response == "Basic Salary") {
                    var fixed_or_perct = $('#fixed_or_percentage_'+row_value).val();
                    if(fixed_or_perct == "fixed") {
                        var final_gratuity_amount = $('#earnings_final_amount_'+row_value).val();
                        $('#gratuity_amount').val(final_gratuity_amount);
                    }
                    
                }
            }
        });
    }
</script>