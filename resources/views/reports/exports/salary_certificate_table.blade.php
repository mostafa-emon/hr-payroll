<div class="table-responsive">
  <table style="width:100%;">
    <thead>
        <tr>
          <th colspan="13" style="border:none;text-align:center;font-size:20px;font-weight:bold;">TO WHOM IT MAY CONCERN</th>
        </tr>

        <tr>
          <th colspan="13" style="border:none;font-size:16px;text-align:left;">This is to certify that {{$employee_selection->name}}, S/O. {{$employee_selection->fathers_name}}, has been under employment with our company. His basic employment details are as follows:</th>
        </tr>
    </thead>
  </table>
</div>
        
<div class="table-responsive">
  <table style="width:100%;">
    <thead>
      <tr>
        <th colspan="2" rowspan="6" style="font-size:15px;border:none;text-align:left;">
          @php $employment_info = get_employment_info($employee_selection->id); @endphp
          Employee Name : {{$employee_selection->name}} <br>
          Department    : {{department_name($employment_info->department_id)}} <br>
          Date Of Joining: {{date('d-M-Y',strtotime($employment_info->date_of_joining))}}
        </th>
        <th colspan="1" rowspan="6" style="font-size:15px;border:none;text-align:left;">
          E-TIN No: {{$employee_selection->tin_no}}
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
    <thead>
      <tr>
        <th colspan="3" style="font-size:15px;text-align:left;border:none;">From <b>{{date('M-Y',strtotime($from_date))}}</b> to <b>{{date('M-Y',strtotime($to_date))}}</b>, he has been paid as Salary and other benefits as following:</th>
      </tr>
    </thead>
  </table>
</div>

<div class="table-responsive">
  <table style="width:100%;">
      <thead>
        <tr>
            <th style="text-align: center;">Sl No</th>
            <th style="text-align: center;">Salary Components</th>
            <th style="text-align: center;">Amount(BDT)</th>
        </tr>
      </thead>

    <tbody>
      @php $sl = 0; $gross_salary = 0; @endphp
      @foreach($employees as $employee)
        <tr>
          <td style="text-align: center;">{{$sl = $sl + 1}}</td>
          <td>{{$employee->component_name}}</td>
          <td style="text-align: right;">
            @php
              echo $total_component_amount = total_component_amount($from_date,$to_date,$employee->id,$employee->component_id);
              $gross_salary                = $gross_salary + $total_component_amount;
            @endphp
          </td>
        </tr>
      @endforeach

      @php
        $company_portion            = present_company_portion($from_date,$to_date,$employee->id);
        $gross_salary               = $gross_salary + $company_portion;
      @endphp

      @if($company_portion != 0)
      <tr>
        <td style="text-align: center;">{{$sl = $sl + 1}}</td>
        <td>PF(Company Portion)</td>
        <td style="text-align: right;">{{$company_portion}}</td>
      </tr>
      @endif

      <tr>
        <td colspan="2" style="text-align:right;font-weight:bold;">Gross Salary (BDT)</td>
        <td style="text-align: right;font-weight:bold;">{{$gross_salary}}</td>
      </tr>

        @php 
          $employee_portion = present_own_portion($from_date,$to_date,$employee->id);
          $employee_deposit_tax = 0;
          if(count($deposit_taxes) > 0) {
            foreach($deposit_taxes as $deposit_tax) {
              $employee_deposit_tax = $employee_deposit_tax + $deposit_tax->amount;
            }
          }
        @endphp

        @if($employee_portion != 0 || $employee_deposit_tax != 0)
        <tr>
          <td colspan="3" style="border:none;">&nbsp;</td>
        </tr>
        
        <tr>
          <td colspan="3" style="border:none;font-size:15px;">
            Against the Above earnings, @if($employee_deposit_tax != 0)The Source Tax Amount <b>BDT {{$employee_deposit_tax}}</b> and @endif @if($employee_portion != 0)<b>P/F Amount BDT {{$employee_portion}}</b> @endif was deducted during this period, @if($employee_deposit_tax != 0)Tax amount was deposited the same into the Government Treasury, vide following challan Nos.: @endif      
          </td>
        <tr>

        <tr>
          <td colspan="3" style="border:none;">&nbsp;</td>
        </tr>
        @endif

    </tbody>
  </table>
</div>

@if(count($deposit_taxes) > 0)
<div class="table-responsive">
  <table style="width:100%;">
      <thead>
        <tr>
            <th style="text-align: center;">Sl</th>
            <th style="text-align: center;">Challan No</th>
            <th style="text-align: center;">Challan Date</th>
            <th style="text-align: center;">Bank Name</th>
            <th style="text-align: center;">Total Amount in the Challan</th>
            <th style="text-align: center;">Amount Relating to this Certificate</th>
            <th style="text-align: center;">Over Leaf Serial no.</th>
        </tr>
      </thead>

    <tbody>
      @php $total_tax = 0; @endphp
      @foreach($deposit_taxes as $tax)
        <tr>
          <td style="text-align: center;">{{$loop->iteration}}</td>
          <td style="text-align: center;">{{$tax->challan_no}}</td>
          <td style="text-align: center;">{{$tax->chalan_date}}</td>
          <td style="text-align: center;">{{$tax->bank_name}}</td>
          <td style="text-align: right;">{{total_deposit_tax_amount($tax->tax_id)}}</td>
          <td style="text-align: right;">
            {{$tax->amount}}
            @php $total_tax = $total_tax + $tax->amount; @endphp
          </td>
          <td style="text-align: center;">{{$tax->sl}}</td>
        </tr>
      @endforeach
        <tr>
          <td colspan="5" style="text-align:right;font-weight:bold;">Total Tax (BDT)</td>
          <td style="text-align: right;font-weight:bold;">{{$total_tax}}</td>
          <td style="text-align: right;font-weight:bold;">&nbsp;</td>
        </tr>
    </tbody>
  </table>
</div>
@endif

<div class="table-responsive">
  <table style="width:100%;">
    <tbody>
        <tr>
          <td colspan="13" style="border:none;text-align:left;font-size:15px;">&nbsp;</td>
        </tr>

        <tr>
          <td colspan="13" style="border:none;text-align:left;font-size:15px;">Certified that the information given above is correct and complete.</td>
        </tr>

        <tr>
          <td colspan="13" style="border:none;font-size:16px;text-align:left;">For and on behalf of</td>
        </tr>

        <tr>
          <td colspan="13" style="border:none;">&nbsp;</td>
        </tr>

        <tr>
          <td colspan="13" style="border:none;">&nbsp;</td>
        </tr>

        <tr>
          <td colspan="13" style="border:none;text-align:left;font-size:15px;">Manager Finance and Accounts <br> Business Data Automation</td>
        </tr>
    </tbody>
  </table>
</div>