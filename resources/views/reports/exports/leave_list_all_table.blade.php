<div class="table-responsive">
  <table style="width:100%;">
    <thead>
        @php 
          $company = get_company_info(Auth::user()->company_id);
        @endphp
        <tr>
          <th colspan="{{count($leave_types) + 6}}" style="font-size:17px;text-align:center;border:none;">{{$company->name}}</th>
        </tr>

        @if($company->address_line_1 != "")
        <tr>
          <th colspan="{{count($leave_types) + 6}}" style="font-size:15px;text-align:center;border:none;">{{$company->address_line_1}}</th>
        </tr>
        @endif

        @if($company->address_line_2 != "")
        <tr>
          <th colspan="{{count($leave_types) + 6}}" style="font-size:15px;text-align:center;border:none;">{{$company->address_line_2}}</th>
        </tr>
        @endif

        <tr>
          <th colspan="{{count($leave_types) + 6}}" style="font-size:15px;text-align:center;border:none;">OT Summary Report</th>
        </tr>
        
        <tr>
          <th colspan="{{count($leave_types) + 6}}" style="font-size:15px;text-align:center;border:none;">From {{date('d-M-Y',strtotime($from_date))}} to {{date('d-M-Y',strtotime($to_date))}}</th>
        </tr>
    </thead>

  </table>
</div>

<div class="table-responsive">

  <table style="width:100%;">
    @php $old_department_id = ''; $sl = 0; $total_ot_minutes = 0; $total_ot_amount = 0; $all_employee_total_leave = 0; $all_employee_total_balance = 0; @endphp
    @foreach($employees as $employee)

      @php
        $employee_info                  = get_employee_info($employee->employee_id);
        $employment_info                = get_employment_info($employee->employee_id);
        $single_employee_total_leave    = 0;
        $single_employee_total_balance  = 0;
      @endphp

      @if($old_department_id != $employment_info->department_id)

        @php $sl = 0; @endphp

        @if($sl == 0 && $old_department_id != '')
          <tbody>
          <tr>
            <td colspan="4" style="text-align: right;font-weight:bold;">Total</td>

            @foreach($leave_types as $type)
              @php $total_leave = 0; @endphp
              @foreach($employees as $employee_list)
                @if($employee_list->department_id == $old_department_id)
                  @php 
                    $leave_days = leave_days($employee_list->employee_id,$type->id,$from_date,$to_date);
                    $total_leave = $total_leave + $leave_days;
                  @endphp
                @endif
              @endforeach
              <td style="text-align: center;font-weight:bold;">{{$total_leave}}</td>
            @endforeach

            <td style="text-align: center;font-weight:bold;">{{$all_employee_total_leave}}</td>
            @foreach($leave_types as $type)
              @php $total_balance = 0; @endphp
              @foreach($employees as $employee_list)
                @if($employee_list->department_id == $old_department_id)
                  @php
                    $leave_info_id     = get_leave_info_id($employee_list->employee_id,$type->id);
                    if($leave_info_id != "") {
                      $leave_balances = leave_balance_left($leave_info_id,$employee_list->employee_id,date('Y'));
                      $total_balance = $total_balance + $leave_balances;
                    }
                  @endphp
                @endif
              @endforeach
              <td style="text-align: center;font-weight:bold;">{{$total_balance}}</td>
            @endforeach
            <td style="text-align: center;font-weight:bold;">{{$all_employee_total_balance}}</td>
          </tr>
          <tbody>
        @endif

        @php $total_ot_minutes = 0; $total_ot_amount = 0; $all_employee_total_leave = 0; $all_employee_total_balance = 0; @endphp

        <thead>
          <tr>
            <th colspan="13" style="font-size:15px;text-align:left;border:none;"></th>
          </tr>
          <tr>
            <th colspan="13" style="font-size:15px;text-align:left;border:none;"></th>
          </tr>
          <tr>
            <th colspan="13" style="font-size:15px;text-align:left;border:none;">Department: <b>{{department_name($employment_info->department_id)}}</b></th>
          </tr>
          <tr>
            <th rowspan="2" style="text-align: center;">Sl</th>
            <th rowspan="2" style="text-align: left;">Employee ID</th>
            <th rowspan="2" style="text-align: left;">Employee Name</th>
            <th rowspan="2" style="text-align: left;">Designation</th>
            <th colspan="{{count($leave_types)}}" style="text-align: center;">Leave Enjoyed</th>
            <th rowspan="2" style="text-align: center;">Total</th>
            <th colspan="{{count($leave_types)}}" style="text-align: center;">Leave Balances</th>
            <th rowspan="2" style="text-align: center;">Total Balance</th>
          </tr>
          <tr>
            @foreach($leave_types as $leave_type)
              <th style="text-align: center;">{{$leave_type->leave_name}}</th>
            @endforeach
            @foreach($leave_types as $leave_type)
              <th style="text-align: center;">{{$leave_type->leave_name}}</th>
            @endforeach
          </tr>
        </thead>
      @endif

      <tbody>
        <tr>
          <td style="text-align:center;">{{$sl = $sl + 1}}</td>
          <td>{{$employee_info->employee_id}}</td>
          <td>{{$employee_info->name}}</td>
          <td>{{designation_name($employment_info->designation_id)}} {{$employment_info->department_id}}</td>

          @foreach($leave_types as $type)
            <td style="text-align: center;">
              @php 
                echo $leave_days = leave_days($employee->employee_id,$type->id,$from_date,$to_date);
                $single_employee_total_leave = $single_employee_total_leave + $leave_days;
                $all_employee_total_leave    = $all_employee_total_leave + $leave_days;
              @endphp
            </td>
          @endforeach

          <td style="text-align: center;font-weight:bold;">{{$single_employee_total_leave}}</td>

          @foreach($leave_types as $type)
            <td style="text-align: center;">
              @php
                $leave_info_id     = get_leave_info_id($employee->employee_id,$type->id);
                if($leave_info_id != "") {
                  echo $leave_balances = leave_balance_left($leave_info_id,$employee->employee_id,date('Y'));
                  $single_employee_total_balance = $single_employee_total_balance + $leave_balances;
                  $all_employee_total_balance    = $all_employee_total_balance + $leave_balances;
                }else{
                  echo 0;
                }
              @endphp
            </td>
          @endforeach

          <td style="text-align: center;font-weight:bold;">{{$single_employee_total_balance}}</td>
        </tr>
          
      </tbody>

      @php $old_department_id = $employment_info->department_id; @endphp
    @endforeach
    <tbody>
      <tr>
        <td colspan="4" style="text-align: right;font-weight:bold;">Total</td>
        
        @foreach($leave_types as $type)
          @php $total_leave = 0; @endphp
          @foreach($employees as $employee)
            @if($employee->department_id == $old_department_id)
              @php 
                $leave_days = leave_days($employee->employee_id,$type->id,$from_date,$to_date);
                $total_leave = $total_leave + $leave_days;
              @endphp
            @endif
          @endforeach
          <td style="text-align: center;font-weight:bold;">{{$total_leave}}</td>
        @endforeach

        <td style="text-align: center;font-weight:bold;">{{$all_employee_total_leave}}</td>

        @foreach($leave_types as $type)
          @php $total_balance = 0; @endphp
          @foreach($employees as $employee)
            @if($employee->department_id == $old_department_id)
              @php
                $leave_info_id     = get_leave_info_id($employee->employee_id,$type->id);
                if($leave_info_id != "") {
                  $leave_balances = leave_balance_left($leave_info_id,$employee->employee_id,date('Y'));
                  $total_balance = $total_balance + $leave_balances;
                }
              @endphp
            @endif
          @endforeach
          <td style="text-align: center;font-weight:bold;">{{$total_balance}}</td>
        @endforeach

        <td style="text-align: center;font-weight:bold;">{{$all_employee_total_balance}}</td>
      </tr>
      <tr>
        <td colspan="7" style="border:none;">&nbsp;</td>
      </tr>
    <tbody>
  </table>
</div>


