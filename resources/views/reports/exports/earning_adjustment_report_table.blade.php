<div class="table-responsive">  
  <table style="width:100%;">
    <thead>
        @php 
          $company = get_company_info(Auth::user()->company_id);
        @endphp
        <tr>
          <th colspan="13" style="font-size:17px;text-align:center;border:none;">{{$company->name}}</th>
        </tr>

        @if($company->address_line_1 != "")
        <tr>
          <th colspan="13" style="font-size:15px;text-align:center;border:none;">{{$company->address_line_1}}</th>
        </tr>
        @endif

        @if($company->address_line_2 != "")
        <tr>
          <th colspan="13" style="font-size:15px;text-align:center;border:none;">{{$company->address_line_2}}</th>
        </tr>
        @endif

        <tr>
          <th colspan="13" style="font-size:15px;text-align:center;border:none;">Earnings Adjustment Report</th>
        </tr>

        <tr>
          <th colspan="13" style="font-size:15px;text-align:center;border:none;">From {{date('M-Y',strtotime($from_date))}} to {{date('M-Y',strtotime($to_date))}}</th>
        </tr>
    </thead>

  </table>
</div>

<div class="table-responsive">

  <table style="width:100%;">
    @php 
      $old_salary_component_id = ''; $sl = 0;

      $total_month = 0;
      foreach ($period as $dt) {
        $total_month = $total_month + 1;

        $dt->format("M-y") . "<br>\n";
      }

    @endphp
    @foreach($employees as $employee)
    @php $single_employee_total_component_amount = 0; $all_employee_component_amount = 0; @endphp
    
    @if($old_salary_component_id != $employee->salary_component_id)
    @php $sl = 0; @endphp

    @if($sl == 0 && $old_salary_component_id != '')
      <tbody>
        <tr>
          <td colspan="5" style="text-align: right;font-weight:bold;">Total</td>
          @foreach($period as $dt)
            @php $total_component_amount = 0; @endphp
            @foreach($employees as $employee_list)
              @if($employee_list->salary_component_id == $old_salary_component_id)
                @php 
                  $component_amount = get_earning_component_amount($employee_list->employee_id,$employee_list->salary_component_id,$dt->format("M-Y"));
                  $total_component_amount = $total_component_amount + $component_amount;
                  $all_employee_component_amount = $all_employee_component_amount + $component_amount;
                @endphp
              @endif
            @endforeach
            <td style="text-align: center;font-weight:bold;">{{$total_component_amount}}</td>
          @endforeach
          <td style="text-align: center;font-weight:bold;">{{$all_employee_component_amount}}</td>
        </tr>
      <tbody>
    @endif

    @php $all_employee_component_amount = 0; @endphp

    <thead>
        <tr>
          <th colspan="13" style="font-size:15px;text-align:left;border:none;"></th>
        </tr>
        <tr>
          <th colspan="13" style="font-size:15px;text-align:left;border:none;"></th>
        </tr>
        <tr>
          <th colspan="13" style="font-size:15px;text-align:left;border:none;">Component: <b>{{get_component_name($employee->salary_component_id)}}</b></th>
        </tr>
        <tr>
            <th rowspan="2" style="text-align: center;">Sl</th>
            <th rowspan="2" style="text-align: left;">Employee ID</th>
            <th rowspan="2" style="text-align: left;">Employee Name</th>
            <th rowspan="2" style="text-align: left;">Department</th>
            <th rowspan="2" style="text-align: left;">Designation</th>
            <th colspan="{{$total_month}}" style="text-align: center;">Salary Month</th>
            <th rowspan="2" style="text-align: center;">Total</th>
        </tr>
        <tr>
          @foreach($period as $dt)
            <th style="text-align: center;">{{$dt->format("M-y")}}</th>
          @endforeach
        </tr>
    </thead>
    @endif

    <tbody>
        <tr>
            <td style="text-align:center;">{{$sl = $sl + 1}}</td>
            <td>{{$employee->string_employee_id}}</td>
            <td>{{$employee->name}}</td>
            <td>{{department_name($employee->department_id)}}</td>
            <td>{{designation_name($employee->designation_id)}}</td>

            @foreach($period as $dt)
              <td style="text-align: center;">
                @php 
                  $component_amount = get_earning_component_amount($employee->employee_id,$employee->salary_component_id,$dt->format("M-Y"));
                  if($component_amount != 0) {
                    echo $component_amount;
                  }else{
                    echo "";
                  }
                  $single_employee_total_component_amount = $single_employee_total_component_amount + $component_amount;
                @endphp
              </td>
            @endforeach
            <td style="text-align: center;font-weight:bold;">{{$single_employee_total_component_amount}}</td>
        </tr>
    </tbody>

      @php $old_salary_component_id = $employee->salary_component_id; @endphp
    @endforeach

    <tbody>
      <tr>
        <td colspan="5" style="text-align: right;font-weight:bold;">Total</td>
        @foreach($period as $dt)
          @php $total_component_amount = 0; @endphp
          @foreach($employees as $employee_list)
            @if($employee_list->salary_component_id == $old_salary_component_id)
              @php 
                $component_amount = get_earning_component_amount($employee_list->employee_id,$employee_list->salary_component_id,$dt->format("M-Y"));
                $total_component_amount = $total_component_amount + $component_amount;
                $all_employee_component_amount = $all_employee_component_amount + $component_amount;
              @endphp
            @endif
          @endforeach
          <td style="text-align: center;font-weight:bold;">{{$total_component_amount}}</td>
        @endforeach
        <td style="text-align: center;font-weight:bold;">{{$all_employee_component_amount}}</td>
      </tr>
    <tbody>
  </table>
</div>

