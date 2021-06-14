<!DOCTYPE html>
<html>
    <head>
    </head>

    <body>
        <div id="printArea">
            <div>
                <div style="text-align:center;font-family: Arial;font-size:20px;">
                    <b>Business Data Automation</b>
                </div>
            
                <br>
            
                <div style="text-align:center;font-family: Arial;">
                    <b>House # Ta-115 Gulshan-Badda Link Road, Middle Badda, Dhaka-1212.</b>
                </div>
            
                <br>
            
                <div style="text-align:center;font-family: Arial;font-size:20px;">
                    <b>TDS Calculation Report</b>
                </div>
            
                <br>
            
                <div style="text-align:center;font-family: Arial;">
                    <b>[As Per ITO-1984, U/S-21, Schedule-24/A]</b>
                </div>
            </div>

            <br>

            <div style="text-align:center;font-family: Arial;">
                <table style="width: 47%;float:left;">
                    <tr>
                        <td style="padding-left:8px;padding-top:8px;text-align:left;font-weight:bold;">Empolyee Name</td>
                        <td style="padding-left:8px;padding-top:8px;text-align:left;">
                            <span style="font-weight:bold;">:</span>
                            <span>{{$employee_info->name}}</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-left:8px;padding-top:8px;text-align:left;font-weight:bold;">Employee ID</td>
                        <td style="padding-left:8px;padding-top:8px;text-align:left;">
                            <span style="font-weight:bold;">:</span> 
                            <span style="padding-top:2px;">{{$employee_info->employee_id}}</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-left:8px;padding-top:8px;text-align:left;font-weight:bold;">Department</td>
                        <td style="padding-left:8px;padding-top:8px;text-align:left;">
                            <span style="font-weight:bold;">:</span> 
                            <span style="padding-top:2px;">{{department_name($employment_info->department_id)}}</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-left:8px;padding-top:8px;text-align:left;font-weight:bold;">Designation</td>
                        <td style="padding-left:8px;padding-top:8px;text-align:left;">
                            <span style="font-weight:bold;">:</span>
                            <span style="padding-top:2px;">{{designation_name($employment_info->designation_id)}}</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-left:8px;padding-top:8px;text-align:left;font-weight:bold;">TIN Number</td>
                        <td style="padding-left:8px;padding-top:8px;text-align:left;">
                            <span style="font-weight:bold;">:</span> 
                            <span style="padding-top:2px;">{{$employee_info->tin_no}}</span>
                        </td>
                    </tr>
                </table>

                <table style="width: 48%;float:right;">
                    <tr>
                        <td style="padding-left:80px;padding-top:8px;text-align:left;">Gender</td>
                        <td style="padding-right:8px;padding-top:8px;text-align:center;"><b>:</b></td>
                        <td style="padding-right:8px;padding-top:8px;text-align:left;">
                            <span style="padding-top:2px;">{{$employee_info->gender}}</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-left:80px;padding-top:8px;text-align:left;">Income Year</td>
                        <td style="padding-right:8px;padding-top:8px;text-align:center;"><b>:</b></td>
                        <td style="padding-right:8px;padding-top:8px;text-align:left;">2020-2021</td>
                    </tr>
                    <tr>
                        <td style="padding-left:80px;padding-top:8px;text-align:left;">Assessment Year</td>
                        <td style="padding-right:8px;padding-top:8px;text-align:center;"><b>:</b></td>
                        <td style="padding-right:8px;padding-top:8px;text-align:left;">2021-2022</td>
                    </tr>
                    <tr>
                        <td style="padding-left:80px;padding-top:8px;text-align:left;">Date of Joining</td>
                        <td style="padding-right:8px;padding-top:8px;text-align:center;"><b>:</b></td>
                        <td style="padding-right:8px;padding-top:8px;text-align:left;">{{date('d-M-Y',strtotime($employment_info->date_of_joining))}}</td>
                    </tr>
                    <tr>
                        <td style="padding-left:80px;padding-top:8px;text-align:left;">Date of Birth</td>
                        <td style="padding-right:8px;padding-top:8px;text-align:center;"><b>:</b></td>
                        <td style="padding-right:8px;padding-top:8px;text-align:left;">{{date('d-M-Y',strtotime($employee_info->date_of_birth))}}</td>
                    </tr>
                </table>

            </div>

            <br><br><br><br><br><br><br><br><br><br><br>
            <div style="font-family: Arial;font-weight:bold;">
                Table-1: Calculation of Taxable Income:
            </div>
            <div style="text-align:center;font-family: Arial;">
                <table style="width: 100%;border: 1px solid black;border-collapse: collapse;">
                    <tr>
                        <th style="text-align:center;border-bottom: 1px solid black;border-right: 1px solid black;padding:5px;">Salary Components</th>
                        <th style="text-align:center;border-bottom: 1px solid black;border-right: 1px solid black;padding:5px;">Per Month</th>
                        <th style="text-align:center;border-bottom: 1px solid black;border-right: 1px solid black;padding:5px;">Per Year</th>
                        <th style="text-align:center;border-bottom: 1px solid black;border-right: 1px solid black;padding:5px;">Non-Tax Limit</th>
                        <th style="text-align:center;border-bottom: 1px solid black;">Taxable Income</th>
                    </tr>
                    <tr>
                        <td style="border-bottom: 1px solid black;text-align:left;border-right: 1px solid black;padding:5px;">Basic Salary</td>
                        <td style="border-bottom: 1px solid black;text-align:center;border-right: 1px solid black;padding:5px;">70,000</td>
                        <td style="border-bottom: 1px solid black;text-align:center;border-right: 1px solid black;padding:5px;">8,40,000</td>
                        <td style="border-bottom: 1px solid black;text-align:center;border-right: 1px solid black;padding:5px;">0</td>
                        <td style="border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;">8,40,000</td>
                    </tr>
                    <tr>
                        <td style="border-bottom: 1px solid black;text-align:left;border-right: 1px solid black;padding:5px;">Basic Salary</td>
                        <td style="border-bottom: 1px solid black;text-align:center;border-right: 1px solid black;padding:5px;">70,000</td>
                        <td style="border-bottom: 1px solid black;text-align:center;border-right: 1px solid black;padding:5px;">8,40,000</td>
                        <td style="border-bottom: 1px solid black;text-align:center;border-right: 1px solid black;padding:5px;">0</td>
                        <td style="border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;">8,40,000</td>
                    </tr>
                    <tr>
                        <td style="border-bottom: 1px solid black;text-align:left;border-right: 1px solid black;padding:5px;">Basic Salary</td>
                        <td style="border-bottom: 1px solid black;text-align:center;border-right: 1px solid black;padding:5px;">70,000</td>
                        <td style="border-bottom: 1px solid black;text-align:center;border-right: 1px solid black;padding:5px;">8,40,000</td>
                        <td style="border-bottom: 1px solid black;text-align:center;border-right: 1px solid black;padding:5px;">0</td>
                        <td style="border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;">8,40,000</td>
                    </tr>
                    <tr>
                        <td style="border-bottom: 1px solid black;text-align:left;border-right: 1px solid black;padding:5px;">Basic Salary</td>
                        <td style="border-bottom: 1px solid black;text-align:center;border-right: 1px solid black;padding:5px;">70,000</td>
                        <td style="border-bottom: 1px solid black;text-align:center;border-right: 1px solid black;padding:5px;">8,40,000</td>
                        <td style="border-bottom: 1px solid black;text-align:center;border-right: 1px solid black;padding:5px;">0</td>
                        <td style="border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;">8,40,000</td>
                    </tr>
                    <tr>
                        <td style="border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;font-weight:bold;">Total Taxable Income</td>
                        <td style="border-bottom: 1px solid black;text-align:center;border-right: 1px solid black;padding:5px;font-weight:bold;">70,000</td>
                        <td style="border-bottom: 1px solid black;text-align:center;border-right: 1px solid black;padding:5px;font-weight:bold;">8,40,000</td>
                        <td style="border-bottom: 1px solid black;text-align:center;border-right: 1px solid black;padding:5px;font-weight:bold;">0</td>
                        <td style="border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;font-weight:bold;">8,40,000</td>
                    </tr>
                </table>
            </div>

            <br><br>
            <div style="font-family: Arial;font-weight:bold;">
                Table-2: Final Tax Calculation:
            </div>
            <div style="text-align:center;font-family: Arial;">
                <table style="width: 100%;border: 1px solid black;border-collapse: collapse;">
                    <tr>
                        <th style="text-align:center;border-bottom: 1px solid black;border-right: 1px solid black;padding:5px;">Slab</th>
                        <th style="text-align:center;border-bottom: 1px solid black;border-right: 1px solid black;padding:5px;">Total Income</th>
                        <th style="text-align:center;border-bottom: 1px solid black;border-right: 1px solid black;padding:5px;">Tax Rate</th>
                        <th style="text-align:center;border-bottom: 1px solid black;border-right: 1px solid black;padding:5px;">Tax Amount</th>
                    </tr>
                    <tr>
                        <td style="border-bottom: 1px solid black;text-align:center;border-right: 1px solid black;padding:5px;">First</td>
                        <td style="border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;">3,00,000</td>
                        <td style="border-bottom: 1px solid black;text-align:center;border-right: 1px solid black;padding:5px;">0%</td>
                        <td style="border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;">-</td>
                    </tr>
                    <tr>
                        <td style="border-bottom: 1px solid black;text-align:center;border-right: 1px solid black;padding:5px;">Next</td>
                        <td style="border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;">1,00,000</td>
                        <td style="border-bottom: 1px solid black;text-align:center;border-right: 1px solid black;padding:5px;">0%</td>
                        <td style="border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;">5,000.00</td>
                    </tr>
                    <tr>
                        <td style="border-bottom: 1px solid black;text-align:center;border-right: 1px solid black;padding:5px;">Next</td>
                        <td style="border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;">3,00,000</td>
                        <td style="border-bottom: 1px solid black;text-align:center;border-right: 1px solid black;padding:5px;">10%</td>
                        <td style="border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;">30,000.00</td>
                    </tr>
                    <tr>
                        <td style="border-bottom: 1px solid black;text-align:center;border-right: 1px solid black;padding:5px;">Next</td>
                        <td style="border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;">4,00,000</td>
                        <td style="border-bottom: 1px solid black;text-align:center;border-right: 1px solid black;padding:5px;">15%</td>
                        <td style="border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;">60,000.00</td>
                    </tr>
                    <tr>
                        <td style="border-bottom: 1px solid black;text-align:center;border-right: 1px solid black;padding:5px;">Next</td>
                        <td style="border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;">2,34,000</td>
                        <td style="border-bottom: 1px solid black;text-align:center;border-right: 1px solid black;padding:5px;">20%</td>
                        <td style="border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;">41,800.00</td>
                    </tr>
                    <tr>
                        <td style="border-bottom: 1px solid black;text-align:center;border-right: 1px solid black;padding:5px;">Rest</td>
                        <td style="border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;">-</td>
                        <td style="border-bottom: 1px solid black;text-align:center;border-right: 1px solid black;padding:5px;">25%</td>
                        <td style="border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;">-</td>
                    </tr>
                    <tr>
                        <td colspan="3" style="border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;font-weight:bold;">Gross Tax Payable for this year</td>
                        <td style="border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;font-weight:bold;">1,41,800.00</td>
                    </tr>
                </table>
            </div>

            <br><br>
            <div style="font-family: Arial;font-weight:bold;">
                Table-3: Calculation of Investment Allowances:
            </div>
            <div style="text-align:center;font-family: Arial;">
                <table style="width: 100%;border: 1px solid black;border-collapse: collapse;">
                    <tr>
                        <td style="border-bottom: 1px solid black;text-align:left;border-right: 1px solid black;padding:5px;">A. 25% of Total Income (Based on Table-1)</td>
                        <td style="border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;">35,450.00</td>
                    </tr>
                    <tr>
                        <td style="border-bottom: 1px solid black;text-align:left;border-right: 1px solid black;padding:5px;">B. Actual Investment Amount (Including PF)</td>
                        <td style="border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;">4,00,000.00</td>
                    </tr>
                    <tr>
                        <td style="border-bottom: 1px solid black;text-align:left;border-right: 1px solid black;padding:5px;">C. Maximum Investment Amount Allowed</td>
                        <td style="border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;">1,50,00,000.00</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="border-top: 1px solid black;border-bottom: 1px solid black;text-align:left;border-right: 1px solid black;padding:5px;font-weight:bold;">Investment Allowance Amount</td>
                        <td style="border-top: 1px solid black;border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;font-weight:bold;">5,317.50</td>
                    </tr>
                </table>
            </div>

            <br><br>
            <div style="font-family: Arial;font-weight:bold;">
                Table-4: Calculation of TDS per month
            </div>
            <div style="text-align:center;font-family: Arial;">
                <table style="width: 100%;border: 1px solid black;border-collapse: collapse;">
                    <tr>
                        <td style="border-bottom: 1px solid black;text-align:left;border-right: 1px solid black;padding:5px;">Annual Gross Tax Payable Before Rebate (As Per Table-2)</td>
                        <td style="border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;">35,450.00</td>
                    </tr>
                    <tr>
                        <td style="border-bottom: 1px solid black;text-align:left;border-right: 1px solid black;padding:5px;">Less: Rebate for Investment Allowance (As per Table-3)</td>
                        <td style="border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;">4,00,000.00</td>
                    </tr>
                    <tr>
                        <td style="border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;font-weight:bold;">Annual Gross Tax Payable After Rebate</td>
                        <td style="border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;">1,50,00,000.00</td>
                    </tr>
                    <tr>
                        <td style="border-bottom: 1px solid black;text-align:left;border-right: 1px solid black;padding:5px;">Less: Advance Tax Paid (U/S 64/68) for Vehicle Registration</td>
                        <td style="border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;">4,00,000.00</td>
                    </tr>
                    <tr>
                        <td style="border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;font-weight:bold;">Annual Net Tax Payable After Advance Tax</td>
                        <td style="border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;">1,24,482.50</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="border-top: 1px solid black;border-bottom: 1px solid black;text-align:left;border-right: 1px solid black;padding:5px;font-weight:bold;">Tax to be deducted at source (TDS) per month</td>
                        <td style="border-top: 1px solid black;border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;font-weight:bold;">5,317.50</td>
                    </tr>
                </table>
            </div>

            <div>
                <table style="width:100%;font-family: Arial;">
                    <tr>
                    <td colspan="1" style="padding-top:50px;padding-bottom:15px;border:none;">
                        <div style="text-align:center;">__________________<br>Prepared By</div>
                    </td>
                    <td colspan="2" style="padding-top:50px;padding-bottom:15px;border:none;">
                        <div style="text-align:center;">__________________<br>Checked By</div>
                    </td>
                    <td colspan="1" style="padding-top:50px;padding-bottom:15px;border:none;">
                        <div style="text-align:center;">__________________<br>Approved By</div>
                    </td>
                    </tr>
                </table>
            </div>
        </div>
    </body>

    <script>

        function printElem(){
            var mywindow = window.open('', 'PRINT');
            mywindow.document.write(document.getElementById('printArea').innerHTML);
    
            setTimeout(function () {
                mywindow.focus();
                mywindow.print();
                mywindow.close();
            }, 1000);
        }
      </script>

    <button class="btn btn-primary" onclick="printElem()">Print</button>

</html>