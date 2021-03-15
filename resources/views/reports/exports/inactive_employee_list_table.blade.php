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
          <th colspan="13" style="font-size:15px;text-align:center;border:none;">Employee List</th>
        </tr>
    </thead>

  </table>
</div>

<div class="table-responsive">

  <table style="width:100%;">
    @php $old_department_id = ''; $sl = 0; $total_salary = 0; @endphp
    @foreach($employees as $employee)
    
    @if($old_department_id != $employee->department_id)
    @php $sl = 0; @endphp
    @php $sl = 0; @endphp
    @if($sl == 0 && $old_department_id != '')
      <tbody>
        <tr>
          <td colspan="11" style="text-align: right;font-weight:bold;">Total</td>
          <td style="text-align: right;font-weight:bold;">{{$total_salary}}</td>
          <td></td>
          <td></td>
        </tr>
      <tbody>
    @endif
    @php $total_salary = 0; @endphp
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
            <th style="text-align: left;">Employee Name</th>
            <th style="text-align: left;">Designation</th>
            <th style="text-align: left;">DOJ</th>
            <th style="text-align: left;">DOC</th>
            <th style="text-align: left;">DOB</th>
            <th style="text-align: center;">Sex</th>
            <th style="text-align: center;">Religion</th>
            <th style="text-align: center;">Phone</th>
            <th style="text-align: center;">NID</th>
            <th style="text-align: right;">Gross Salary</th>
            <th style="text-align: left;">Date Of Resign</th>
            <th style="text-align: left;">Reason</th>
        </tr>
    </thead>
    @endif

    <tbody>
        <tr>
            <td style="text-align:center;">{{$sl = $sl + 1}}</td>
            <td>{{$employee->string_employee_id}}</td>
            <td>{{$employee->name}}</td>
            <td>{{designation_name($employee->designation_id)}}</td>
            <td>
              @if($employee->date_of_joining != "")
                {{date('d-M-Y',strtotime($employee->date_of_joining))}}
              @endif
            </td>
            <td>
              @if($employee->date_of_confirmation != "")
              {{date('d-M-Y',strtotime($employee->date_of_confirmation))}}
              @endif
            </td>
            <td>
              @if($employee->date_of_birth != "")
              {{date('d-M-Y',strtotime($employee->date_of_birth))}}
              @endif
            </td>
            <td style="text-align: center;">{{$employee->gender}}</td>
            <td style="text-align: center;">{{$employee->religion}}</td>
            <td style="text-align: center;">{{$employee->phone_1}}</td>
            <td style="text-align: center;">{{$employee->nid_number}}</td>
            <td style="text-align: right;">
              @php
              echo $gross_salary  = gross_salary($employee->employee_id);
              $total_salary       = $total_salary + $gross_salary;
              @endphp
            </td>
            <td>
              @if($employee->date_of_resign != "")
              {{date('d-M-Y',strtotime($employee->date_of_resign))}}
              @endif
            </td>
            <td>{{$employee->reason_for_resign}}</td>
        </tr>
    </tbody>

      @php $old_department_id = $employee->department_id; @endphp
    @endforeach
    <tbody>
      <tr>
        <td colspan="11" style="text-align: right;font-weight:bold;">Total</td>
        <td style="text-align: right;font-weight:bold;">{{$total_salary}}</td>
        <td></td>
        <td></td>
      </tr>
      <tbody>
  </table>
</div>

