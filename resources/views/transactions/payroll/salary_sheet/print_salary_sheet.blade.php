<div class="visibility: hidden" id="printArea">
    <div>
        <div style="text-align:center;font-family: Arial;font-weight:bold;font-size:20px;">
            {{ get_company_name(auth()->user()->company_id ) }}
        </div>
    
        <br>
    
        <div style="text-align:center;font-family: Arial;font-weight:bold;">
            Salary Sheet
        </div>
    
        <br>
    
        <div style="text-align:center;font-family: Arial;">
            For the Month of {{$month}}-{{$year}}
        </div>
    </div>

    <br>

    <div style="font-family: Arial;">
        @if($department != "")Department: <b>{{$department}}</b> &nbsp;@endif
        @if($project != "")Project: <b>{{$project}}</b> &nbsp;@endif
        @if($branch != "")Branch: <b>{{$branch}}</b> &nbsp;@endif
        @if($currency != "")Currency: <b>{{$currency}}</b> &nbsp;@endif
    </div>

    <br>

    <div style="text-align:center;font-family: Arial;">
        <table style="width:100%;border: 1px solid black;border-collapse: collapse;">
            <tr>
              <th rowspan="2" style="border-right: 1px solid black;padding:5px;width:7%;">Employee ID</th>
              <th rowspan="2" style="border-right: 1px solid black;padding:5px;width:13%;text-align:left">Name</th>
              <th rowspan="2" style="border-right: 1px solid black;padding:5px;width:10%;text-align:left">Designation</th>
              <th colspan="{{count($earning_comps)}}" style="text-align:center;border-bottom: 1px solid black;border-right: 1px solid black;padding:5px;width:25%;">Earnings</th>
              <th rowspan="2" style="border-right: 1px solid black;padding:5px;width:5%;">Total Earnings</th>
              <th colspan="{{count($deduction_comps)}}" style="text-align:center;border-bottom: 1px solid black;border-right: 1px solid black;padding:5px;width:25%;">Deductions</th>
              <th rowspan="2" style="border-right: 1px solid black;padding:5px;width:5%;">Total Deductions</th>
              <th rowspan="2" style="border-right: 1px solid black;padding:5px;width:5%;">Net Salary</th>
              <th rowspan="2" style="border-right: 1px solid black;padding:5px;width:5%;">Revenue Stamp</th>
            </tr>

            <tr>
            @foreach($earning_comps as $component)
              <td style="border-right: 1px solid black;padding:5px;font-weight:bold;text-align:left;">{{$component['component_name']}}</td>
            @endforeach
            @foreach($deduction_comps as $component)
              <td style="border-right: 1px solid black;padding:5px;font-weight:bold;text-align:left;">{{$component['component_name']}}</td>
            @endforeach
            </tr>

            @foreach($employment_infos as $employee)
            <tr>
                <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">{{$employee['original_employee_id']}}</td>
                <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">{{$employee['name']}}</td>
                <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">{{designation_name($employee['designation_id'])}}</td>
                
                @php $total_earnings = 0; @endphp
                @foreach($earning_comps as $component)
                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;text-align:right;">
                    @php 
                        echo $earning = get_salary_component_amount($month,$year,$employee['employee_id'],$component['component_id']);
                        if($earning != "") {
                            $total_earnings = $total_earnings + $earning;
                        }
                    @endphp
                    </td>
                @endforeach
                <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;text-align:right;">{{$total_earnings}}</td>
                @php $total_deduction = 0; @endphp
                @foreach($deduction_comps as $component)
                <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;text-align:right;">
                    @php
                        echo $deduction = get_salary_component_amount($month,$year,$employee['employee_id'],$component['component_id']);
                        if($deduction != "") {
                            $total_deduction = $total_deduction + $deduction;
                        }
                    @endphp
                </td>
                @endforeach
                <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;text-align:right;">{{$total_deduction}}</td>
                <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;text-align:right;">{{$total_earnings - $total_deduction}}</td>
                <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;padding-top:40px;padding-bottom:40px;">&nbsp;</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="3" style="border-top: 1px solid black;border-bottom: 1px solid black;border-right: 1px solid black;padding:5px;text-align:right;font-weight:bold;">Total</td>
                @php $grand_total_earnings = 0; @endphp
                @foreach($earning_comps as $component)
                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;text-align:right;">
                        @php 
                            echo $comp_wise_earning = get_salary_sheet_component_total($month,$year,$component['component_id'],$employee_ids);
                            if($comp_wise_earning  != "" || $comp_wise_earning != 0) {
                                $grand_total_earnings = $grand_total_earnings + $comp_wise_earning;
                            }
                        @endphp
                    </td>
                @endforeach
                <td style="border-top: 1px solid black;border-bottom: 1px solid black;border-right: 1px solid black;padding:5px;font-weight:bold;text-align:right">{{$grand_total_earnings}}</td>
                
                @php $grand_total_deduction = 0; @endphp
                @foreach($deduction_comps as $component)
                <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;text-align:right;">
                    @php 
                        echo $comp_wise_earning = get_salary_sheet_component_total($month,$year,$component['component_id'],$employee_ids);
                        if($comp_wise_earning  != "" || $comp_wise_earning != 0) {
                            $grand_total_deduction = $grand_total_deduction + $comp_wise_earning;
                        }
                    @endphp
                </td>
                @endforeach
                <td style="border-top: 1px solid black;border-bottom: 1px solid black;border-right: 1px solid black;padding:5px;font-weight:bold;text-align:right">{{$grand_total_deduction}}</td>
                <td style="border-top: 1px solid black;border-bottom: 1px solid black;border-right: 1px solid black;padding:5px;font-weight:bold;text-align:right">{{$grand_total_earnings - $grand_total_deduction}}</td>
                <td style="border-top: 1px solid black;border-bottom: 1px solid black;border-right: 1px solid black;padding:5px;font-weight:bold;">&nbsp</td>
            </tr>
        </table>

        <table style="width:100%;margin-top:50px;">
            <tr>
                <td style="padding-top:25px;padding-bottom:15px;">
                    <div style="text-align:center;">__________________<br>Prepared By</div>
                </td>
                <td style="padding-top:25px;padding-bottom:15px;">
                    <div style="text-align:center;">__________________<br>Checked By</div>
                </td>
                <td style="padding-top:25px;padding-bottom:15px;">
                    <div style="text-align:center;">__________________<br>Approved By</div>
                </td>
            </tr>
        </table>
    </div>
</div>

<script>
    var mywindow = window.open('', 'PRINT');
    mywindow.document.write('<style>body {zoom:80%;}</style>');
    mywindow.document.write(document.getElementById('printArea').innerHTML);

    setTimeout(function () {
        mywindow.focus();
        mywindow.print();
        mywindow.close();
        window.history.back();
    }, 500);

</script>