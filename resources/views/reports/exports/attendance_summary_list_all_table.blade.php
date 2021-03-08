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
          <th colspan="13" style="font-size:15px;text-align:center;border:none;">Attendance Summary Report</th>
        </tr>
        
        <tr>
          <th colspan="13" style="font-size:15px;text-align:center;border:none;">From {{date('d-M-Y',strtotime($from_date))}} to {{date('d-M-Y',strtotime($to_date))}}</th>
        </tr>
    </thead>

  </table>

  <table style="width:100%;">
    @php $old_department_id = ''; $sl = 0; @endphp
    @foreach($employees as $employee)
    @php
      $employee_info    = get_employee_info($employee->employee_id);
      $employment_info  = get_employment_info($employee->employee_id);
      $attendance_days  = calculate_attendance_days($employee->employee_id,$from_date,$to_date);

      list($ok_days,$leave_days,$late_days,$absent_days,$day_off_days,$govt_holidays) = explode("_",$attendance_days);

    @endphp
    @if($old_department_id != $employment_info->department_id)
    @php $sl = 0; @endphp
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
            <th style="text-align: center;">OK <br> Days</th>
            <th style="text-align: center;">Leave <br> Days</th>
            <th style="text-align: center;">Late <br> Days</th>
            <th style="text-align: center;">Absent <br> Days</th>
            <th style="text-align: center;">Days Off <br> Days</th>
            <th style="text-align: center;">Gov't Holidays <br> Days</th>
        </tr>

    </thead>
    @endif

    <tbody>
        <tr>
            <td style="text-align:center;">{{$sl = $sl + 1}}</td>
            <td>{{$employee_info->employee_id}}</td>
            <td>{{$employee_info->name}}</td>
            <td>{{designation_name($employment_info->designation_id)}}</td>
            <td style="text-align: center;">{{$ok_days}}</td>
            <td style="text-align: center;">{{$leave_days}}</td>
            <td style="text-align: center;">{{$late_days}}</td>
            <td style="text-align: center;">{{$absent_days}}</td>
            <td style="text-align: center;">{{$day_off_days}}</td>
            <td style="text-align: center;">{{$govt_holidays}}</td>
        </tr>
        
    </tbody>

      @php $old_department_id = $employment_info->department_id; @endphp
    @endforeach
  </table>
</div>


