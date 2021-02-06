<div id="printArea">
    <div>
        <div style="text-align:center;font-family: Arial;">
            {{$company_info->name}}
        </div>
    
        <br>
    
        <div style="text-align:center;font-family: Arial;">
            {{$company_info->address_line_1}} {{$company_info->address_line_2}}
        </div>
    
        <br>
    
        <div style="text-align:center;font-family: Arial;font-size:20px;">
            <b>Salary Pay Slip</b>
        </div>
    
        <br>
    
        <div style="text-align:center;font-family: Arial;">
            For The Month of {{date('M-Y',strtotime($month))}}
        </div>
    </div>

    <div style="float:right;padding-right:30px;padding-top:-100px;">
        <span style="font-family: Arial;font-size:25px;font-weight:bold;">
            Logo
            {{--<img src="{{ asset('storage/'.$company_info->logo) }}" height="80" width="80"/>--}}
        </span>
    </div>

    <br>

    <div style="text-align:center;font-family: Arial;border-top: 1px solid black;">
        <table style="width: 55%;border-left: 1px solid black;float:left;">
            <tr>
                <td style="padding-left:8px;padding-top:8px;text-align:left;">Empolyee Name</td>
                <td style="padding-left:8px;padding-top:8px;text-align:left;">
                    <span style="font-weight:bold;">:</span>
                    <span>{{$employee->name}}</span>
                </td>
            </tr>
            <tr>
                <td style="padding-left:8px;padding-top:8px;text-align:left;">Employee ID</td>
                <td style="padding-left:8px;padding-top:8px;text-align:left;">
                    <span style="font-weight:bold;">:</span> 
                    <span style="padding-top:2px;">{{$employee->employee_id}}</span>
                </td>
            </tr>
            <tr>
                <td style="padding-left:8px;padding-top:8px;text-align:left;">Department</td>
                <td style="padding-left:8px;padding-top:8px;text-align:left;">
                    <span style="font-weight:bold;">:</span> 
                    <span style="padding-top:2px;">{{department_name($employment_info->department_id)}}</span>
                </td>
            </tr>
            <tr>
                <td style="padding-left:8px;padding-top:8px;text-align:left;">Designation</td>
                <td style="padding-left:8px;padding-top:8px;text-align:left;">
                    <span style="font-weight:bold;">:</span>
                    <span style="padding-top:2px;">{{designation_name($employment_info->designation_id)}}</span>
                </td>
            </tr>
            <tr>
                <td style="padding-left:8px;padding-top:8px;text-align:left;">Date of Joining</td>
                <td style="padding-left:8px;padding-top:8px;text-align:left;">
                    <span style="font-weight:bold;">:</span> 
                    <span style="padding-top:2px;">{{date('d-M-y', strtotime($employment_info->date_of_joining))}}</span>
                </td>
            </tr>
            <tr>
                <td style="padding-left:8px;padding-top:8px;text-align:left;">Project</td>
                <td style="padding-left:8px;padding-top:8px;text-align:left;">
                    <span style="font-weight:bold;">:</span> 
                    <span style="padding-top:2px;">{{project_name($employment_info->project_id)}}</span>
                </td>
            </tr>
            <tr>
                <td style="padding-left:8px;padding-top:8px;text-align:left;">Branch</td>
                <td style="padding-left:8px;padding-top:8px;text-align:left;">
                    <span style="font-weight:bold;">:</span> 
                    <span style="padding-top:2px;">{{branch_name($employment_info->branch_id)}}</span>
                </td>
            </tr>
            <tr>
                <td style="padding-left:8px;padding-top:8px;text-align:left;">Payment Method</td>
                <td style="padding-left:8px;padding-top:8px;text-align:left;">
                    <span style="font-weight:bold;">:</span> 
                    <span style="padding-top:2px;">
                        @if($employment_info->salary_payment_method == "Bank") Bank Transfer
                        @else Cash
                        @endif
                    </span>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        </table>

        <table style="width: 45%;border-right: 1px solid black;float:right;">
            <tr>
                <td style="padding-left:80px;padding-top:8px;text-align:left;">Total Present Days</td>
                <td style="padding-right:8px;padding-top:8px;text-align:center;"><b>:</b></td>
                <td style="padding-right:8px;padding-top:8px;text-align:right;">
                    <span style="padding-top:2px;">{{$total_present_days}}</span>
                </td>
            </tr>
            <tr>
                <td style="padding-left:80px;padding-top:8px;text-align:left;">Total Day Off</td>
                <td style="padding-right:8px;padding-top:8px;text-align:center;"><b>:</b></td>
                <td style="padding-right:8px;padding-top:8px;text-align:right;">{{$total_day_off}}</td>
            </tr>
            <tr>
                <td style="padding-left:80px;padding-top:8px;text-align:left;">Total Leave Days</td>
                <td style="padding-right:8px;padding-top:8px;text-align:center;"><b>:</b></td>
                <td style="padding-right:8px;padding-top:8px;text-align:right;">{{$total_leave_days}}</td>
            </tr>
            <tr>
                <td style="padding-left:80px;padding-top:8px;text-align:left;">Total Holidays</td>
                <td style="padding-right:8px;padding-top:8px;text-align:center;"><b>:</b></td>
                <td style="padding-right:8px;padding-top:8px;text-align:right;">{{$total_holidays}}</td>
            </tr>
            <tr>
                <td style="padding-left:80px;padding-top:8px;text-align:left;">Total Late Days</td>
                <td style="padding-right:8px;padding-top:8px;text-align:center;"><b>:</b></td>
                <td style="padding-right:8px;padding-top:8px;text-align:right;">{{$total_late_days}}</td>
            </tr>
            <tr>
                <td style="padding-left:80px;padding-top:8px;text-align:left;">Total Absent Days</td>
                <td style="padding-right:8px;padding-top:8px;text-align:center;"><b>:</b></td>
                <td style="padding-right:8px;padding-top:8px;text-align:right;">{{$total_absent_days}}</td>
            </tr>
            <tr>
                <td style="padding-left:80px;padding-top:8px;text-align:left;">Net Payable Days</td>
                <td style="padding-right:8px;padding-top:8px;text-align:center;"><b>:</b></td>
                <td style="padding-right:8px;padding-top:8px;text-align:right;">{{$net_payable_days}}</td>
            </tr>
            <tr>
                <td style="padding-right:8px;padding-top:8px;text-align:left;">&nbsp;</td>
                <td style="padding-right:8px;padding-top:8px;text-align:left;">
                    <span style="font-weight:bold;">&nbsp;</span> 
                    <span style="padding-top:2px;">&nbsp;</span>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        </table>

        <table style="width: 100%;border: 1px solid black;border-collapse: collapse;margin-top:282px;">
            <tr>
                <th style="text-align:center;border-bottom: 1px solid black;border-right: 1px solid black;padding:5px;">Earnings</th>
                <th style="text-align:center;border-bottom: 1px solid black;border-right: 1px solid black;padding:5px;">Amount</th>
                <th style="text-align:center;border-bottom: 1px solid black;border-right: 1px solid black;padding:5px;">Deductions</th>
                <th style="text-align:center;border-bottom: 1px solid black;">Amount</th>
            </tr>
            @foreach($pay_slip_data as $row)
            <tr>
                <td style="text-align:left;border-right: 1px solid black;padding:5px;">{{$row['earning_component']}}</td>
                <td style="text-align:right;border-right: 1px solid black;padding:5px;">{{$row['earning_amount']}}</td>
                <td style="padding-left:8px;text-align:left;border-right: 1px solid black;">{{$row['deduction_component']}}</td>
                <td style="text-align:right;padding-right:6px;">{{$row['deduction_amount']}}</td>
            </tr>
            @endforeach
            <tr>
                <td style="text-align:center;border-right: 1px solid black;padding:5px;border-top: 1px solid black;">Total Earning</td>
                <td style="text-align:right;border-right: 1px solid black;padding:5px;border-top: 1px solid black;"><u>{{$total_earning}}</u></td>
                <td style="padding-left:8px;text-align:center;border-right: 1px solid black;border-top: 1px solid black;">Total Deduction</td>
                <td style="text-align:right;padding-right:6px;border-top: 1px solid black;"><u>{{$total_deduction}}</u></td>
            </tr>
            <tr>
                <td style="text-align:left;border-right: 1px solid black;padding:5px;border-top: 1px solid black;border-bottom: 1px solid black;">
                    @if($company_pf != 0) Company Contribution to PF @else &nbsp; @endif
                </td>
                <td style="text-align:right;border-right: 1px solid black;padding:5px;border-top: 1px solid black;border-bottom: 1px solid black;">@if($company_pf != 0) {{$company_pf}} @else &nbsp; @endif</td>
                <td style="padding-left:8px;text-align:left;border-right: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;">Net Salary</td>
                <td style="text-align:right;padding-right:6px;border-top: 1px solid black;border-bottom: 1px solid black;"><u>{{$total_earning - $total_deduction}}</u></td>
            </tr>
            <tr>
                <td colspan="4" style="text-align:left;border-right: 1px solid black;padding:8px;padding-top:15px;">
                    <b>Net Amount in word:</b> Forty-Four Thousand Nine Hundred Ninety-Seven Only.
                </td>
            </tr>
            <tr>
                <td colspan="1" style="padding-top:25px;padding-bottom:15px;">
                    <div style="text-align:center;">__________________<br>Prepared By</div>
                </td>
                <td colspan="2" style="padding-top:25px;padding-bottom:15px;">
                    <div style="text-align:center;">__________________<br>Checked By</div>
                </td>
                <td colspan="1" style="border-right: 1px solid black;padding-top:25px;padding-bottom:15px;padding-right:20px;">
                    <div style="text-align:center;">__________________<br>Approved By</div>
                </td>
            </tr>
        </table>
    </div>
</div>