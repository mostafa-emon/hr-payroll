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
          <th colspan="13" style="font-size:15px;text-align:center;border:none;">PF Summary Report</th>
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
      $old_department_id = ''; $sl = 0;
      $total_previous_own_portion = 0; $total_previous_company_portion  = 0; $grand_total_previous_portion  = 0;
      $total_present_own_portion  = 0; $total_present_company_portion   = 0; $grand_total_present_portion   = 0;
      $total_closing_own_portion  = 0; $total_closing_company_portion   = 0; $grand_total_closing_portion   = 0;
    @endphp
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
          <td colspan="6" style="text-align: right;font-weight:bold;">Total</td>
  
          @if($show_previous_balance == 'Yes')
            <td style="text-align: center;font-weight:bold;">{{$total_previous_own_portion}}</td>
            <td style="text-align: center;font-weight:bold;">{{$total_previous_company_portion}}</td>
            <td style="text-align: center;font-weight:bold;">{{$grand_total_previous_portion}}</td>
          @endif
  
          @if($show_current_period == 'Yes')
            <td style="text-align: center;font-weight:bold;">{{$total_present_own_portion}}</td>
            <td style="text-align: center;font-weight:bold;">{{$total_present_company_portion}}</td>
            <td style="text-align: center;font-weight:bold;">{{$grand_total_present_portion}}</td>
          @endif
  
          @if($show_closing_balance == 'Yes')
            <td style="text-align: center;font-weight:bold;">{{$total_closing_own_portion}}</td>
            <td style="text-align: center;font-weight:bold;">{{$total_closing_company_portion}}</td>
            <td style="text-align: center;font-weight:bold;">{{$grand_total_closing_portion}}</td>
          @endif
        </tr>
      <tbody>
    @endif
    @php
      $total_previous_own_portion = 0; $total_previous_company_portion  = 0; $grand_total_previous_portion  = 0;
      $total_present_own_portion  = 0; $total_present_company_portion   = 0; $grand_total_present_portion   = 0;
      $total_closing_own_portion  = 0; $total_closing_company_portion   = 0; $grand_total_closing_portion   = 0;
    @endphp
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
          <th rowspan="2" style="text-align: left;">Name</th>
          <th rowspan="2" style="text-align: left;">Designation</th>
          <th rowspan="2" style="text-align: center;">DOJ</th>
          <th rowspan="2" style="text-align: center;">DOC</th>
          @if($show_previous_balance == 'Yes')
            <th colspan="3" style="text-align: center;">Previous Balance</th>
          @endif
          @if($show_current_period == 'Yes')
            <th colspan="3" style="text-align: center;">Current Period</th>
          @endif
          @if($show_closing_balance == 'Yes')
            <th colspan="3" style="text-align: center;">Closing Balance</th>
          @endif
        </tr>
        <tr>
          @if($show_previous_balance == 'Yes')
            <th style="text-align: center;">Own</th>
            <th style="text-align: center;">Company</th>
            <th style="text-align: center;">Total</th>
          @endif

          @if($show_current_period == 'Yes')
            <th style="text-align: center;">Own</th>
            <th style="text-align: center;">Company</th>
            <th style="text-align: center;">Total</th>
          @endif

          @if($show_closing_balance == 'Yes')
            <th style="text-align: center;">Own</th>
            <th style="text-align: center;">Company</th>
            <th style="text-align: center;">Total</th>
          @endif
        </tr>

    </thead>
    @endif

    <tbody>
        <tr>
            <td style="text-align:center;">{{$sl = $sl + 1}}</td>
            <td>{{$employee_info->employee_id}}</td>
            <td>{{$employee_info->name}}</td>
            <td>{{designation_name($employment_info->designation_id)}}</td>
            <td>
              @if($employment_info->date_of_joining != "")
                {{date('d-M-Y',strtotime($employment_info->date_of_joining))}}
              @endif
            </td>
            <td>
              @if($employment_info->date_of_confirmation != "")
              {{date('d-M-Y',strtotime($employment_info->date_of_confirmation))}}
              @endif
            </td>

            @if($show_previous_balance == 'Yes')
              <td style="text-align: center;">
                @php 
                  echo $previous_own_portion      = previous_own_portion($from_date,$employee->employee_id); 
                  $total_previous_own_portion     = $total_previous_own_portion + $previous_own_portion;
                @endphp
              </td>
              <td style="text-align: center;">
                @php 
                  echo $previous_company_portion  = previous_company_portion($from_date,$employee->employee_id);
                  $total_previous_company_portion = $total_previous_company_portion + $previous_company_portion;
                @endphp
              </td>
              <td style="text-align: center;">
                @php 
                  echo $total_previous_portion    = $previous_own_portion + $previous_company_portion;
                  $grand_total_previous_portion   = $grand_total_previous_portion + $total_previous_portion;
                @endphp
              </td>
            @endif

            @if($show_current_period == 'Yes')
              <td style="text-align: center;">
                @php 
                  echo $present_own_portion       = present_own_portion($from_date,$to_date,$employee->employee_id);
                  $total_present_own_portion      = $total_present_own_portion + $present_own_portion;
                @endphp
              </td>
              <td style="text-align: center;">
                @php 
                  echo $present_company_portion   = present_company_portion($from_date,$to_date,$employee->employee_id);
                  $total_present_company_portion  = $total_present_company_portion + $present_company_portion;
                @endphp
              </td>

              <td style="text-align: center;">
                @php 
                  echo $total_present_portion     = $present_own_portion + $present_company_portion;
                  $grand_total_present_portion    = $grand_total_present_portion + $total_present_portion;
                @endphp
              </td>
            @endif

            @if($show_closing_balance == 'Yes')
              <td style="text-align: center;">
                @php 
                  echo $closing_own_portion       = closing_own_portion($to_date,$employee->employee_id);
                  $total_closing_own_portion      = $total_closing_own_portion + $closing_own_portion;
                @endphp
              </td>
              <td style="text-align: center;">
                @php 
                  echo $closing_company_portion   = closing_company_portion($to_date,$employee->employee_id);
                  $total_closing_company_portion  = $total_closing_company_portion + $closing_company_portion;
                @endphp
              </td>
              <td style="text-align: center;">
                @php
                  echo $total_closing_portion    = $closing_own_portion + $closing_company_portion;
                  $grand_total_closing_portion   = $grand_total_closing_portion + $total_closing_portion;
                @endphp
              </td>
            @endif
        </tr>
        
    </tbody>

      @php $old_department_id = $employment_info->department_id; @endphp
    @endforeach
    <tbody>
      <tr>
        <td colspan="6" style="text-align: right;font-weight:bold;">Total</td>

        @if($show_previous_balance == 'Yes')
          <td style="text-align: center;font-weight:bold;">{{$total_previous_own_portion}}</td>
          <td style="text-align: center;font-weight:bold;">{{$total_previous_company_portion}}</td>
          <td style="text-align: center;font-weight:bold;">{{$grand_total_previous_portion}}</td>
        @endif

        @if($show_current_period == 'Yes')
          <td style="text-align: center;font-weight:bold;">{{$total_present_own_portion}}</td>
          <td style="text-align: center;font-weight:bold;">{{$total_present_company_portion}}</td>
          <td style="text-align: center;font-weight:bold;">{{$grand_total_present_portion}}</td>
        @endif

        @if($show_closing_balance == 'Yes')
          <td style="text-align: center;font-weight:bold;">{{$total_closing_own_portion}}</td>
          <td style="text-align: center;font-weight:bold;">{{$total_closing_company_portion}}</td>
          <td style="text-align: center;font-weight:bold;">{{$grand_total_closing_portion}}</td>
        @endif
      </tr>
      <tr>
        <td colspan="9" style="border:none;">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="9" style="border:none;">&nbsp;</td>
      </tr>
      <tbody>
  </table>
</div>


