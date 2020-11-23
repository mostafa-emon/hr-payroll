<style>
    .remove-space{ padding:0px;padding-right:5px; }
</style>

<form method="POST" action="{{url('employee/add-leave-info')}}">
{{ csrf_field() }}
<input type="hidden" name="employee_id" value="{{$employee_id}}"/>

<div id="leaves">
    <div class="row pd-t-10" id="leaves_1">
        <div class="col-md-2 remove-space" id="type_1">
            <select class="form-control" name="leave_type_id[]">
                <option value="" label>Leave Type</option>
                @foreach($leave_types as $leave_type)
                    <option value="{{$leave_type->id}}">{{$leave_type->leave_name}}</option>
                @endforeach
            </select>
        </div>
    
        <div class="col-md-2 remove-space" id="allotment_1">
            <input type="text" class="form-control" name="yearly_allotment[]" placeholder="Yearly Allotment"/>
        </div>

        <div class="col-md-2 remove-space" id="opening_date_1">
            <input type="text" class="form-control dtpicker" name="opening_balance_date[]" placeholder="Opening Date" autocomplete="off"/>
        </div>

        <div class="col-md-2 remove-space" id="opening_balance_1">
            <input type="text" class="form-control" name="opening_balance[]" placeholder="Opening Balance"/>
        </div>

        <div class="col-md-2 remove-space" id="carry_forward_1">
            <select class="form-control" name="carry_forward[]">
                <option value="" label>Carry Forward</option>
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
        </div>

        <div class="col-md-1 remove-space" id="max_carry_forward_1">
            <input type="text" class="form-control" name="max_carry_forward[]" placeholder="Max C.F"/>
        </div>
    
        <div class="col-md-1" style="padding:0px;">
            <a href="javascript:void(0)" class="btn btn-success" onclick="add_leave_row()" style="width:15px;padding-left:7px;margin-left:3px"><i class="fa fa-plus-circle"></i></a>
            <a href="javascript:void(0)" class="btn btn-danger" onclick="remove_leave_row(1)" style="width:15px;padding-left:7px;"><i class="fa fa-minus-circle"></i></a>
        </div>
    </div>
</div>

<div class="row pd-t-30">
    <input type="submit" value="Submit" class="btn btn-primary"/>
</div>

</form>

<script>
    

    var leaves    = 1;
    function add_leave_row(){
        leaves = leaves + 1;
        $('#leaves').append('<div id="leaves"><div class="row pd-t-10" id="leaves_'+leaves+'"><div class="col-md-2 remove-space" id="type_'+leaves+'"><select class="form-control" name="leave_type_id[]"><option value="" label>Leave Type</option>@foreach($leave_types as $leave_type)<option value="{{$leave_type->id}}">{{$leave_type->leave_name}}</option>@endforeach</select></div><div class="col-md-2 remove-space" id="allotment_'+leaves+'"><input type="text" class="form-control" name="yearly_allotment[]" placeholder="Yearly Allotment"/></div><div class="col-md-2 remove-space" id="opening_date_'+leaves+'"><input type="text" class="form-control" id="dtpick_'+leaves+'" name="opening_balance_date[]" placeholder="Opening Date" autocomplete="off"/></div><div class="col-md-2 remove-space" id="opening_balance_'+leaves+'"><input type="text" class="form-control" name="opening_balance[]" placeholder="Opening Balance,Ex:12"/></div><div class="col-md-2 remove-space" id="carry_forward_'+leaves+'"><select class="form-control" name="carry_forward[]"><option value="" label>Carry Forward</option><option value="1">Yes</option><option value="0">No</option></select></div><div class="col-md-1 remove-space" id="max_carry_forward_'+leaves+'"><input type="text" class="form-control" name="max_carry_forward[]" placeholder="Max C.F"/></div><div class="col-md-1" style="padding:0px;"><a href="javascript:void(0)" class="btn btn-success" onclick="add_leave_row()" style="width:15px;padding-left:7px;margin-left:3px;margin-right:5px;"><i class="fa fa-plus-circle"></i></a><a href="javascript:void(0)" class="btn btn-danger" onclick="remove_leave_row('+leaves+')" style="width:15px;padding-left:7px;"><i class="fa fa-minus-circle"></i></a></div></div></div>');

        $('#dtpick_'+leaves).datepicker({
            dateFormat: 'dd-mm-yy'
        });
    }

    function remove_leave_row(idValue) {
        var myobj = document.getElementById("leaves_"+idValue);
        myobj.remove();
    }

</script>