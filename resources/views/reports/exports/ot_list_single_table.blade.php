<div class="table-responsive">
  <table style="width:100%;">
    <thead>
        @php 
          $company = get_company_info(Auth::user()->company_id);
        @endphp
        <tr>
          <th colspan="12" style="font-size:17px;text-align:center;border:none;">{{$company->name}}</th>
        </tr>

        @if($company->address_line_1 != "")
        <tr>
          <th colspan="12" style="font-size:15px;text-align:center;border:none;">{{$company->address_line_1}}</th>
        </tr>
        @endif

        @if($company->address_line_2 != "")
        <tr>
          <th colspan="12" style="font-size:15px;text-align:center;border:none;">{{$company->address_line_2}}</th>
        </tr>
        @endif

        <tr>
          <th colspan="12" style="font-size:15px;text-align:center;border:none;">OT Report Individual</th>
        </tr>
        
        <tr>
          <th colspan="12" style="font-size:15px;text-align:center;border:none;">From {{date('d-M-Y',strtotime($from_date))}} to {{date('d-M-Y',strtotime($to_date))}}</th>
        </tr>

        <tr>
          <th colspan="12" style="font-size:15px;text-align:center;border:none;">Employee ID: {{$employee_selection->employee_id}} Name: {{$employee_selection->name}}</th>
        </tr>
        <tr>
            <th style="text-align: left;">Date</th>
            <th style="text-align: center;">Shift <br> Name</th>
            <th style="text-align: center;">Shift <br> In</th>
            <th style="text-align: center;">Shift <br> Out</th>
            <th style="text-align: center;">First In</th>
            <th style="text-align: center;">Last Out</th>
            <th style="text-align: center;">Total Hours</th>
            <th style="text-align: center;">OT Hours</th>
            <th style="text-align: center;">OT Rate</th>
            <th style="text-align: center;">OT <br> Amount</th>
            <th style="text-align: center;">Status</th>
            <th style="text-align: left;">Note</th>
        </tr>
    </thead>

    <tbody>
      @php $total_ot_minutes = 0; $total_ot_amount = 0; @endphp
      @foreach($employees as $employee)
        <tr>
            <td>{{date('d-M-Y',strtotime($employee->date))}}</td>
            <td style="text-align:center;">
              @if($employee->roster_employee == 1)
              {{shift_name_from_roster($employee->employee_id,date('Y-m-d',strtotime($employee->date)))}}
              @else
              @endif
            </td>
            <td style="text-align: center;">
              @if($employee->actual_in_time != "")
              {{date('h:i A',strtotime($employee->actual_in_time))}}
              @endif
            </td>
            <td style="text-align: center;">
              @if($employee->actual_out_time != "")
              {{date('h:i A',strtotime($employee->actual_out_time))}}
              @endif
            </td>
            <td style="text-align: center;">
              @if($employee->in_time != "")
              {{date('h:i A',strtotime($employee->in_time))}}
              @endif
            </td>
            <td style="text-align: center;">
              @if($employee->out_time != "")
              {{date('h:i A',strtotime($employee->out_time))}}
              @endif
            </td>
            <td style="text-align: center;">
              {{gmdate("H:i", $employee->total_working_hour * 60)}}
            </td>
            <td style="text-align: center;">
              @php $total_ot_minutes = $total_ot_minutes + $employee->over_time; @endphp
              {{gmdate("H:i", $employee->over_time * 60)}}
            </td>
            <td style="text-align: center;">
              @php
                $hourly_ot_rate = hourly_ot_rate($employee->employee_id);
                echo number_formatting($hourly_ot_rate);
              @endphp
            </td>
            <td style="text-align: center;">
              @php
                $ot_hour = $employee->over_time / 60;
                $amount = round($ot_hour * $hourly_ot_rate);
                echo number_formatting($amount);
                $total_ot_amount        = $total_ot_amount + $amount;
              @endphp
            </td>
            <td style="text-align: center;">
              @if($remark != "")

                @if($remark == "OK") {{$remark}}
                @elseif($remark == "Late")         <div style="color:red;font-weight:bold;"> Late </div>
                @elseif($remark == "Govt Holiday") <div style="color:green;font-weight:bold;"> Govt Holiday </div>
                @elseif($remark == "Day Off")      <div style="color:green;font-weight:bold;"> Day Off </div>
                @elseif($remark == "Leave")        <div style="color:green;font-weight:bold;"> Leave </div>
                @elseif($remark == "Absent")       <div style="color:red;font-weight:bold;"> Absent </div>
                @endif
              @else
                @php $attendance_remark = attendance_special_remark($employee->employee_id,date('Y-m-d',strtotime($employee->date))); @endphp
                @if($attendance_remark == "OK") OK
                @elseif($attendance_remark == "Late")         <div style="color:red;font-weight:bold;"> Late </div>
                @elseif($attendance_remark == "Govt Holiday") <div style="color:green;font-weight:bold;"> Govt Holiday </div>
                @elseif($attendance_remark == "Absent")       <div style="color:red;font-weight:bold;"> Absent </div>
                @elseif($attendance_remark == "Day Off")      <div style="color:green;font-weight:bold;"> Day Off </div>
                @elseif($attendance_remark == "Leave")        <div style="color:green;font-weight:bold;"> Leave </div>
                @endif
              @endif
            </td>
            <td style="text-align: left;">{{$employee->note}}</td>
        </tr>
      @endforeach
        <tr>
          <td colspan="7" style="text-align: right;">Total OT</td>
          <td style="text-align: center;">{{gmdate("H:i", $total_ot_minutes * 60)}}</td>
          <td></td>
          <td style="text-align: center;">{{number_formatting($total_ot_amount)}}</td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td colspan="12" style="border:none;">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="12" style="text-align:left;border:none;">
              <b>Amount in word:</b> {{amount_in_word($total_ot_amount)}}
          </td>
        </tr>
    </tbody>
  </table>
</div>


