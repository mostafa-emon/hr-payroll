<table style="width:100%;">
  <thead>
      @php 
        $company = get_company_info(Auth::user()->company_id);
      @endphp
      <tr>
        <th colspan="10" style="font-size:17px;text-align:center;border:none;">{{$company->name}}</th>
      </tr>

      @if($company->address_line_1 != "")
      <tr>
        <th colspan="10" style="font-size:15px;text-align:center;border:none;">{{$company->address_line_1}}</th>
      </tr>
      @endif

      @if($company->address_line_2 != "")
      <tr>
        <th colspan="10" style="font-size:15px;text-align:center;border:none;">{{$company->address_line_2}}</th>
      </tr>
      @endif

      <tr>
        <th colspan="10" style="font-size:15px;text-align:center;border:none;">Attendance Summary Report</th>
      </tr>
      
      <tr>
        <th colspan="10" style="font-size:15px;text-align:center;border:none;">From {{date('d-M-Y',strtotime($from_date))}} to {{date('d-M-Y',strtotime($to_date))}}</th>
      </tr>

      <tr>
        <th colspan="10" style="font-size:15px;text-align:center;border:none;">Name: {{$employee_selection->name}} Employee ID: {{$employee_selection->employee_id}}</th>
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
          <th style="text-align: center;">Status</th>
          <th style="text-align: left;">Note</th>
      </tr>
  </thead>

  <tbody>
    @php $total_ot_minutes = 0; @endphp
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
            @if($remark != "") {{$remark}} 
            @else
              @if($employee->status == "PRESENT" && $employee->late == 0) OK
              @elseif($employee->status == "PRESENT" && $employee->late > 0) Late
              @elseif($employee->status == "GOVT_HOLIDAY") Govt Holiday
              @elseif($employee->status == "WEEKLY_HOLIDAY") Day Off
              @elseif($employee->status == "PAID_LEAVE") Leave
              @elseif($employee->status == "ABSENT") {{attendance_remark($employee->employee_id,date('Y-m-d',strtotime($employee->date)))}}
              @endif
            @endif
          </td>
          <td style="text-align: left;">{{$employee->note}}</td>
      </tr>
    @endforeach
      <tr>
        <td colspan="7" style="text-align: right;">Total OT Hours</td>
        <td style="text-align: center;">{{gmdate("H:i", $total_ot_minutes * 60)}} Hours</td>
        <td colspan="2"></td>
      </tr>
  </tbody>
</table>


