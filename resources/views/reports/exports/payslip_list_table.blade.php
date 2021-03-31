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
          <th colspan="13" style="font-size:15px;text-align:center;border:none;">Pay Slip Report</th>
        </tr>
        
        <tr>
          <th colspan="13" style="font-size:15px;text-align:center;border:none;">Month: {{$month}} {{$year}}</th>
        </tr>
    </thead>

  </table>
</div>

<br>
<div class="table-responsive">

  <table style="width:100%;" class="table table-striped table-bordered mg-b-0 text-md-nowrap">
    @php $old_department_id = ''; $sl = 0; @endphp
    @foreach($employment_infos as $employee)
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
          <th style="text-align:center;">SL</th>
          <th>Employee Name</th>
          <th style="text-align:center;">Employee ID</th>
          <th>Department</th>
          <th>Project</th>
          <th>Branch</th>
          <th>Currency</th>
          <th>Bank Account</th>
          <th style="text-align:center;">Payable Salary</th>
          @if($hide_detail_btn != 'Yes')
            <th style="text-align:center;vertical-align:middle;">Details</th>
            <th style="text-align:center;vertical-align:middle;">Pay Slip</th>
          @endif
        </tr>

    </thead>
    @endif

    <tbody>
        <tr>
            <td style="text-align:center;">{{$sl = $sl + 1}}</td>
            <td>{{$employee->name}}</td>
            <td style="text-align:center;">{{$employee->original_employee_id}}</td>
            <td>{{department_name($employee->department_id)}}</td>
            <td>{{project_name($employee->project_id)}}</td>
            <td>{{branch_name($employee->branch_id)}}</td>
            <td>{{currency_name($employee->currency_id)}}</td>
            <td style="text-align:center;">{{$employee->bank_account_no}}</td>
            <td style="text-align:center;">{{$employee->total_salary}}</td>
            @if($hide_detail_btn != 'Yes')
              <td style="text-align:center;vertical-align:middle;">
                <a href="{{ url('salary-sheet/details/'.$employee->employee_id.'/'.$month.'/'.$year) }}" class="btn btn-success btn-sm">Details</a>
              </td>
              <td style="text-align:center;vertical-align:middle;">
                <a href="{{url('salary-sheet-details-print/'.$employee->employee_id.'/'.$month.'/'.$year)}}" class="btn btn-primary btn-sm">PaySlip</a>
              </td>
            @endif
        </tr>
        
    </tbody>

      @php $old_department_id = $employee->department_id; @endphp
    @endforeach
  </table>
</div>

