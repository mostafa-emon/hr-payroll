<div class="table-responsive">
  <table style="width:100%;">
    <thead>
        @php 
          $company = get_company_info(Auth::user()->company_id);
        @endphp
        <tr>
          <th colspan="{{count($leave_types) + 4}}" style="font-size:17px;text-align:center;border:none;">{{$company->name}}</th>
        </tr>

        @if($company->address_line_1 != "")
        <tr>
          <th colspan="{{count($leave_types) + 4}}" style="font-size:15px;text-align:center;border:none;">{{$company->address_line_1}}</th>
        </tr>
        @endif

        @if($company->address_line_2 != "")
        <tr>
          <th colspan="{{count($leave_types) + 4}}" style="font-size:15px;text-align:center;border:none;">{{$company->address_line_2}}</th>
        </tr>
        @endif

        <tr>
          <th colspan="{{count($leave_types) + 4}}" style="font-size:15px;text-align:center;border:none;">Leave Report Individual</th>
        </tr>
        
        <tr>
          <th colspan="{{count($leave_types) + 4}}" style="font-size:15px;text-align:center;border:none;">From {{date('d-M-Y',strtotime($from_date))}} to {{date('d-M-Y',strtotime($to_date))}}</th>
        </tr>

        <tr>
          <th colspan="{{count($leave_types) + 4}}" style="border:none;">&nbsp;</th>
        </tr>
    </thead>
  </table>
</div>
        
<div class="table-responsive">
  <table style="width:100%;">
    <thead>
      <tr>
        <th colspan="{{round(count($leave_types) + 4) + 1}}" rowspan="6" style="font-size:15px;border:none;text-align:left;">
          @php $employment_info = get_employment_info($employee_selection->id); @endphp
          Employee Name : {{$employee_selection->name}} <br>
          Employee ID   : {{$employee_selection->employee_id}} <br>
          Department    : {{department_name($employment_info->department_id)}} <br>
          Designation   : {{designation_name($employment_info->designation_id)}}
        </th>
        <th colspan="{{round(count($leave_types) + 4) - 1}}" rowspan="6" style="font-size:15px;border:none;text-align:left;">
          Date Of Joining: {{date('d-M-Y',strtotime($employment_info->date_of_joining))}} <br>
          Date Of Confirmation: {{date('d-M-Y',strtotime($employee_selection->date_of_confirmation))}} <br>
        </th>
      </tr>

      <tr>
        <th style="border:none;">&nbsp;</th>
      </tr>
      <tr>
        <th style="border:none;">&nbsp;</th>
      </tr>
      <tr>
        <th style="border:none;">&nbsp;</th>
      </tr>
      <tr>
        <th style="border:none;">&nbsp;</th>
      </tr>

    </thead>
  </table>
</div>

<div class="table-responsive">
  <table style="width:100%;">
      <thead>
        <tr>
          <th colspan="2" style="text-align: center;">Leave Days</th>
          <th colspan="{{count($leave_types)}}" style="text-align: center;">Leave Types</th>
          <th rowspan="2" style="text-align: center;">Total Leave</th>
          <th rowspan="2" style="text-align: center;">Reason For Leave</th>
        </tr>
        <tr>
            <th style="text-align: center;">From</th>
            <th style="text-align: center;">To</th>
            @foreach($leave_types as $leave_type)
              <th style="text-align: center;">{{$leave_type->leave_name}}</th>
            @endforeach
        </tr>
      </thead>

    <tbody>
      @foreach($employees as $employee)
        <tr>
            <td style="text-align: center;">{{date('d-M-Y',strtotime($employee->start_date))}}</td>
            <td style="text-align: center;">{{date('d-M-Y',strtotime($employee->end_date))}}</td>

            @foreach($leave_types as $type)
              <td style="text-align: center;">
                @if($employee->leave_type_id == $type->id)
                  {{$employee->leave_days}}
                @else 0
                @endif
              </td>
            @endforeach

            <td style="text-align: center;">
              @foreach($leave_types as $type)
                @if($employee->leave_type_id == $type->id) {{$employee->leave_days}} @endif
              @endforeach
            </td>
            <td style="text-align: center;">{{$employee->remark}}</td>
        </tr>
      @endforeach
      <tr>
        <td colspan="2" style="text-align:right;">Total</td>
        @php $grand_total = 0; @endphp
        @foreach($leave_types as $type)
          @php $total = 0; @endphp
          @foreach($employees as $employee)
            
                @if($employee->leave_type_id == $type->id)
                  @php $total = $total + $employee->leave_days; @endphp
                @endif
            
          @endforeach
          <td style="text-align: center;">
            {{$total}}
            @php $grand_total = $grand_total + $total; @endphp
          </td>
        @endforeach
        <td style="text-align: center;">{{$grand_total}}</td>
        <td style="text-align: center;">&nbsp;</td>
      </tr>
    </tbody>
  </table>
</div>


