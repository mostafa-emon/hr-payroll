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

<div class="row pd-t-30">
    <input type="submit" value="Submit" class="btn btn-primary"/>
</div>

</form>

<script>
    var earnings = 1;
    function add_earning_row(){
        earnings = earnings + 1;
        $('#earnings').append('<div class="row pd-t-10" id="earnings_'+earnings+'"><div class="col-md-4 remove-space" id="component_'+earnings+'"><select class="form-control" name="salary_component_id[]"><option value="" label>component</option>@foreach($earning_components as $component)<option value="{{$component->id}}">{{$component->component_name}}</option>@endforeach</select></div><div class="col-md-2 remove-space" id="cal_type_'+earnings+'"><select class="form-control" name="fixed_or_percentage[]" id="fixed_or_percentage_'+earnings+'" onchange="fixed_or_percentage(this.value,'+earnings+')"><option value="fixed">fixed amount</option><option value="variable">variable amount</option></select></div><div class="col-md-2 remove-space" id="percentage_'+earnings+'" style="display:none"><input type="text" class="form-control" name="percentage_amount[]" placeholder="percentage, Ex:5"/></div><div class="col-md-3 remove-space" id="of_component_'+earnings+'" style="display:none"><select class="form-control" name="of_component_id[]"><option value="" label>% of component</option>@foreach($earning_components as $component)<option value="{{$component->id}}">{{$component->component_name}}</option>@endforeach</select></div><div class="col-md-5 remove-space" id="amount_'+earnings+'"><input type="text" class="form-control" name="final_amount[]" placeholder="amount"/></div><div class="col-md-1" style="padding:0px;"><a href="javascript:void(0)" class="btn btn-success" onclick="add_earning_row()" style="width:15px;padding-left:7px;margin-left:3px;margin-right:5px"><i class="fa fa-plus-circle"></i></a><a href="javascript:void(0)" class="btn btn-danger" onclick="remove_earning_row('+earnings+')" style="width:15px;padding-left:7px;"><i class="fa fa-minus-circle"></i></a></div></div>');
    }

    function remove_earning_row(idValue) {
        var myobj = document.getElementById("earnings_"+idValue);
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
</script>