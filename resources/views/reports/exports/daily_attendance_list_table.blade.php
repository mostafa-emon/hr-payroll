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
          <th colspan="13" style="font-size:15px;text-align:center;border:none;">Daily Attendance Report</th>
        </tr>
        
        <tr>
          <th colspan="13" style="font-size:15px;text-align:center;border:none;">{{date('d/M/Y',strtotime($date))}}</th>
        </tr>
    </thead>

  </table>
</div>

<div class="table-responsive">
  <table style="width:100%;">
    @php $old_department_id = ''; $sl = 0; @endphp
    @foreach($employees as $employee)
    @if($old_department_id != $employee->department_id)
    @php $sl = 0; @endphp
    <thead>
        <tr>
          <th colspan="13" style="font-size:15px;text-align:left;border:none;"></th>
        </tr>
        <tr>
          <th colspan="13" style="font-size:15px;text-align:left;border:none;"></th>
        </tr>
        <tr>
          <th colspan="13" style="font-size:15px;text-align:left;border:none;">Department: <b>{{department_name($employee->department_id)}}</b></th>
        </tr>
        <tr>
            <th rowspan="2" style="text-align: center;">Sl</th>
            <th rowspan="2" style="text-align: left;">Employee ID</th>
            <th rowspan="2" style="text-align: left;">Name</th>
            <th rowspan="2" style="text-align: left;">Designation</th>
            <th rowspan="2" style="text-align: center;">Shift Name</th>
            <th colspan="2" style="text-align: center;">Shift Time</th>
            <th colspan="2" style="text-align: center;">Actual Time</th>
            <th rowspan="2" style="text-align: center;">Total Hours</th>
            <th rowspan="2" style="text-align: center;">OT Hours</th>
            <th rowspan="2" style="text-align: center;">Remark</th>
            <th rowspan="2" style="text-align: left;">Note</th>
        </tr>
        <tr>
          <th style="text-align: center;">In</th>
          <th style="text-align: center;">Out</th>
          <th style="text-align: center;">First In</th>
          <th style="text-align: center;">Last Out</th>
        </tr>
    </thead>
    @endif

    <tbody>
        <tr>
            <td style="text-align:center;">{{$sl = $sl + 1}}</td>
            <td>{{$employee->string_employee_id}}</td>
            <td>{{$employee->name}}</td>
            <td>{{designation_name($employee->designation_id)}}</td>
            <td style="text-align:center;">
              @if($employee->roster_employee == 1)
              {{shift_name_from_roster($employee->employee_id,date('Y-m-d',strtotime($date)))}}
              @else
              @endif
            </td>
            <td style="text-align: center;">{{$employee->actual_in_time}}</td>
            <td style="text-align: center;">{{$employee->actual_out_time}}</td>
            <td style="text-align: center;">{{$employee->in_time}}</td>
            <td style="text-align: center;">{{$employee->out_time}}</td>
            <td style="text-align: center;">
              {{gmdate("H:i", $employee->total_working_hour * 60)}}
            </td>
            <td style="text-align: center;">
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
                @elseif($employee->status == "ABSENT") {{attendance_remark($employee->employee_id,date('Y-m-d',strtotime($date)))}}
                @endif
              @endif
            </td>
            <td style="text-align: left;">{{$employee->note}}</td>
        </tr>
        
    </tbody>

      @php $old_department_id = $employee->department_id; @endphp
    @endforeach
  </table>
</div>


