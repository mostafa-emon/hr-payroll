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
        <th colspan="10" style="font-size:15px;text-align:center;border:none;">Late Report-Individual</th>
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
          <th style="text-align: center;">Last Time To Enter</th>
          <th style="text-align: center;">Actual In Time</th>
          <th style="text-align: center;">Late Minutes</th>
          <th style="text-align: left;">Note</th>
      </tr>
  </thead>

  <tbody>
    @php $total_late_minutes = 0; @endphp
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
            @if($employee->in_time != "")
            {{date('h:i A',strtotime($employee->in_time))}}
            @endif
          </td>
          <td style="text-align: center;">
            @php $total_late_minutes = $total_late_minutes + $employee->late; @endphp
            {{gmdate("H:i", $employee->late * 60)}}
          </td>
          <td style="text-align: left;">{{$employee->note}}</td>
      </tr>
    @endforeach
      <tr>
        <td colspan="4" style="text-align: right;">Total Late Time</td>
        <td style="text-align: center;">{{gmdate("H:i", $total_late_minutes * 60)}}</td>
        <td colspan="1">Hours</td>
      </tr>
  </tbody>
</table>


