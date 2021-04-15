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
          <th colspan="13" style="font-size:15px;text-align:center;border:none;">OT Summary Report</th>
        </tr>
        
        <tr>
          <th colspan="13" style="font-size:15px;text-align:center;border:none;">From {{date('d-M-Y',strtotime($from_date))}} to {{date('d-M-Y',strtotime($to_date))}}</th>
        </tr>
    </thead>

  </table>
</div>

<div class="table-responsive">

  <table style="width:100%;">
    @php $old_department_id = ''; $sl = 0; $total_ot_minutes = 0; $total_ot_amount = 0; $grand_total_ot_minutes = 0; $grand_total_ot_amount = 0; @endphp
    @foreach($employees as $employee)
    @php
      $employee_info    = get_employee_info($employee->employee_id);
      $employment_info  = get_employment_info($employee->employee_id);
    @endphp
    @if($old_department_id != $employment_info->department_id)
    @php $sl = 0; @endphp
    @if($sl == 0 && $old_department_id != '')
      <tbody>
      <tr>
        <td colspan="4" style="text-align: right;">Total</td>
        <td style="text-align: center;">{{gmdate("H:i", $total_ot_minutes * 60)}}</td>
        <td></td>
        <td style="text-align: center;">{{number_formatting($total_ot_amount)}}</td>
      </tr>
      <tbody>
    @endif
    @php $total_ot_minutes = 0; $total_ot_amount = 0; @endphp
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
            <th style="text-align: center;">Sl</th>
            <th style="text-align: left;">Employee ID</th>
            <th style="text-align: left;">Name</th>
            <th style="text-align: left;">Designation</th>
            <th style="text-align: center;">OT Hours</th>
            <th style="text-align: center;">OT Rate</th>
            <th style="text-align: center;">OT Amount</th>
        </tr>

    </thead>
    @endif

    <tbody>
        <tr>
            <td style="text-align:center;">{{$sl = $sl + 1}}</td>
            <td>{{$employee_info->employee_id}}</td>
            <td>{{$employee_info->name}}</td>
            <td>{{designation_name($employment_info->designation_id)}}</td>
            <td style="text-align: center;">
              {{gmdate("H:i", $employee->over_time * 60)}}
              @php 
                $total_ot_minutes       = $total_ot_minutes + $employee->over_time;
                $grand_total_ot_minutes = $grand_total_ot_minutes + $employee->over_time;
              @endphp
            </td>
            <td style="text-align: center;">
            @php
              $hourly_ot_rate = hourly_ot_rate($employee_info->id);
              echo number_formatting($hourly_ot_rate);
            @endphp
            </td>
            <td style="text-align: center;">
              @php
                $ot_hour = $employee->over_time / 60;
                $amount = round($ot_hour * $hourly_ot_rate);
                echo number_formatting($amount);
                $total_ot_amount        = $total_ot_amount + $amount;
                $grand_total_ot_amount  = $grand_total_ot_amount + $amount;
              @endphp
            </td>
        </tr>
        
    </tbody>

      @php $old_department_id = $employment_info->department_id; @endphp
    @endforeach
    <tbody>
      <tr>
        <td colspan="4" style="text-align: right;">Total</td>
        <td style="text-align: center;">{{gmdate("H:i", $total_ot_minutes * 60)}}</td>
        <td></td>
        <td style="text-align: center;">{{number_formatting($total_ot_amount)}}</td>
      </tr>
      <tr>
        <td colspan="7" style="border:none;">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" style="text-align: right;font-weight:bold;">Grand Total</td>
        <td style="text-align: center;font-weight:bold;">{{gmdate("H:i", $grand_total_ot_minutes * 60)}}</td>
        <td></td>
        <td style="text-align: center;font-weight:bold;">{{number_formatting($grand_total_ot_amount)}}</td>
      </tr>
      <tr>
        <td colspan="7" style="border:none;">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="7" style="text-align:left;border:none;">
            <b>Amount in word:</b> {{amount_in_word($grand_total_ot_amount)}}
        </td>
      </tr>
      <tbody>
  </table>
</div>


