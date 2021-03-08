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
          <th colspan="13" style="font-size:15px;text-align:center;border:none;">Daily Late Report</th>
        </tr>
        
        <tr>
          <th colspan="13" style="font-size:15px;text-align:center;border:none;">{{date('d/M/Y',strtotime($date))}}</th>
        </tr>
    </thead>

  </table>

  <table style="width:100%;">
    @php $old_department_id = ''; $sl = 0; $total_late_minutes = 0; @endphp
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
            <th style="text-align: center;">Sl</th>
            <th style="text-align: left;">Employee ID</th>
            <th style="text-align: left;">Name</th>
            <th style="text-align: left;">Designation</th>
            <th style="text-align: center;">Shift <br> Name</th>
            <th style="text-align: center;">Last Time To Enter</th>
            <th style="text-align: center;">Actual In Time</th>
            <th style="text-align: center;">Late Minutes</th>
            <th style="text-align: left;">Note</th>
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
            <td style="text-align: center;">
              @if($employee->actual_in_time != "")
              {{date('H:i',strtotime($employee->actual_in_time))}}
              @endif
            </td>
            <td style="text-align: center;">
              @if($employee->in_time != "")
              {{date('H:i',strtotime($employee->in_time))}}
              @endif
            </td>
            <td style="text-align: center;">
              @php $total_late_minutes = $total_late_minutes + $employee->late; @endphp
              {{gmdate("H:i", $employee->late * 60)}}
            </td>
            <td style="text-align: left;">{{$employee->note}}</td>
        </tr>
        
    </tbody>

      @php $old_department_id = $employee->department_id; @endphp
    @endforeach
  </table>
</div>

