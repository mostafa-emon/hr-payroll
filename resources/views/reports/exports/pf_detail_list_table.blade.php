<div class="table-responsive">
  <table style="width:100%;">
    <thead>
        @php 
          $company = get_company_info(Auth::user()->company_id);
        @endphp
        <tr>
          <th colspan="5" style="font-size:17px;text-align:center;border:none;">{{$company->name}}</th>
        </tr>

        @if($company->address_line_1 != "")
        <tr>
          <th colspan="5" style="font-size:15px;text-align:center;border:none;">{{$company->address_line_1}}</th>
        </tr>
        @endif

        @if($company->address_line_2 != "")
        <tr>
          <th colspan="5" style="font-size:15px;text-align:center;border:none;">{{$company->address_line_2}}</th>
        </tr>
        @endif

        <tr>
          <th colspan="5" style="font-size:15px;text-align:center;border:none;">PF Detail Report Individual</th>
        </tr>
        
        <tr>
          <th colspan="5" style="font-size:15px;text-align:center;border:none;">From {{date('M-Y',strtotime($from_date))}} to {{date('M-Y',strtotime($to_date))}}</th>
        </tr>

        <tr>
          <th colspan="5" style="border:none;">&nbsp;</th>
        </tr>
    </thead>
  </table>
</div>
        
<div class="table-responsive">
  <table style="width:100%;">
    <thead>
      <tr>
        <th colspan="5" rowspan="6" style="font-size:15px;border:none;text-align:left;">
          @php $employment_info = get_employment_info($employee_selection->id); @endphp
          Employee Name : {{$employee_selection->name}} <br>
          Employee ID   : {{$employee_selection->employee_id}} <br>
          Department    : {{department_name($employment_info->department_id)}} <br>
          Designation   : {{designation_name($employment_info->designation_id)}}
        </th>
        <th colspan="4" rowspan="6" style="font-size:15px;border:none;text-align:left;">
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
          <th style="text-align: center;">Salary Month</th>
          <th style="text-align: center;">Description</th>
          <th style="text-align: center;">Own Portion</th>
          <th style="text-align: center;">Company Portion</th>
          <th style="text-align: center;">Total</th>
        </tr>
      </thead>

    <tbody>
      @php 
      $grand_total = 0; $total_own_portion = 0; $total_company_portion = 0; $previous_own_portion = 0; $previous_company_portion = 0; $total_previous_portion = 0;
      @endphp
      @if($show_previous_balance == 'Yes')
      <tr>
        <td colspan="2" style="text-align:right;font-weight:bold;">Previous Balance</td>
        <td style="text-align: center;font-weight:bold;">@php echo $previous_own_portion     = $previous_own_portion + previous_own_portion($from_date,$employee_selection->id); @endphp</td>
        <td style="text-align: center;font-weight:bold;">@php echo $previous_company_portion = $previous_company_portion + previous_company_portion($from_date,$employee_selection->id); @endphp</td>
        <td style="text-align: center;font-weight:bold;">@php echo $total_previous_portion   = $total_previous_portion + $previous_own_portion + $previous_company_portion; @endphp</td>
      </tr>
      @endif
      @foreach($employees as $employee)
        <tr>
            <td style="text-align: center;">{{date('M-Y',strtotime($employee->query_date))}}</td>
            <td style="text-align: center;"></td>
            <td style="text-align: center;">
              @php 
                echo $own_portion      = own_portion($employee->month,$employee->year,$employee->employee_id);
                $total_own_portion     = $total_own_portion + $own_portion;
              @endphp
            </td>
            <td style="text-align: center;">
              @php 
                echo $company_portion  = company_portion($employee->month,$employee->year,$employee->employee_id);
                $total_company_portion = $total_company_portion + $company_portion;
              @endphp
            </td>
            <td style="text-align: center;">
              @php 
                echo $total_portion    = $own_portion + $company_portion;
                $grand_total           = $grand_total + $own_portion + $company_portion;
              @endphp
            </td>
        </tr>
      @endforeach
      <tr>
        <td colspan="2" style="text-align:right;font-weight:bold;">Total</td>
        <td style="text-align: center;font-weight:bold;">{{$total_own_portion + $previous_own_portion}}</td>
        <td style="text-align: center;font-weight:bold;">{{$total_company_portion + $previous_company_portion}}</td>
        <td style="text-align: center;font-weight:bold;">{{$grand_total + $total_previous_portion}}</td>
      </tr>
    </tbody>
  </table>
</div>


