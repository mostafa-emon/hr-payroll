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
                        <td style="padding-right:8px;padding-top:8px;text-align:left;">{{$tax_rule->income_year_from}}-{{$tax_rule->income_year_to}}</td>
                    </tr>
                    <tr>
                        <td style="padding-left:80px;padding-top:8px;text-align:left;">Assessment Year</td>
                        <td style="padding-right:8px;padding-top:8px;text-align:center;"><b>:</b></td>
                        <td style="padding-right:8px;padding-top:8px;text-align:left;">{{$tax_rule->assesment_year_from}}-{{$tax_rule->assesment_year_to}}</td>
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

            @php 
                list($income_tax,$yearly_festival_bonus,$yearly_basic_salary,$yearly_house_rent,
                $yearly_house_rent_non_tax_limit,$yearly_conveyance,$yearly_conveyance_non_tax_limit,
                $yearly_medical,$yearly_medical_non_tax_limit,$yearly_company_pf,$yearly_other_allowance,
                $taxable_income,$first_slab_amount,$second_slab_amount,$third_slab_amount,$forth_slab_amount,
                $fifth_slab_amount,$rest_slab_amount,$first_slab_tax_amount,$second_slab_tax_amount,$third_slab_tax_amount,
                $forth_slab_tax_amount,$fifth_slab_tax_amount,$rest_slab_tax_amount,$tax_amount,$investment_amount,
                $investment_allow_amount,$income_tax) = explode("_",$tax_with_festival);

                $monthly_income = 0;
                $yearly_income  = 0;
                $non_tax_limit  = 0;
            @endphp
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
                        <td style="border-bottom: 1px solid black;text-align:center;border-right: 1px solid black;padding:5px;">{{$monthly_basic_salary = $yearly_basic_salary / 12}}</td>
                        <td style="border-bottom: 1px solid black;text-align:center;border-right: 1px solid black;padding:5px;">{{$yearly_basic_salary}}</td>
                        <td style="border-bottom: 1px solid black;text-align:center;border-right: 1px solid black;padding:5px;">0</td>
                        <td style="border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;">
                            {{$yearly_basic_salary}}
                            @php
                                $monthly_income = $monthly_income + $monthly_basic_salary;
                                $yearly_income  = $yearly_income  + $yearly_basic_salary;
                            @endphp
                        </td>
                    </tr>
                    <tr>
                        <td style="border-bottom: 1px solid black;text-align:left;border-right: 1px solid black;padding:5px;">House Rent</td>
                        <td style="border-bottom: 1px solid black;text-align:center;border-right: 1px solid black;padding:5px;">{{$monthly_house_rent = $yearly_house_rent / 12}}</td>
                        <td style="border-bottom: 1px solid black;text-align:center;border-right: 1px solid black;padding:5px;">{{$yearly_house_rent}}</td>
                        <td style="border-bottom: 1px solid black;text-align:center;border-right: 1px solid black;padding:5px;">{{$yearly_house_rent_non_tax_limit}}</td>
                        <td style="border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;">
                            {{$yearly_house_rent - $yearly_house_rent_non_tax_limit}}
                            @php
                                $monthly_income = $monthly_income + $monthly_house_rent;
                                $yearly_income  = $yearly_income  + $yearly_house_rent;
                                $non_tax_limit  = $non_tax_limit  + $yearly_house_rent_non_tax_limit;
                            @endphp
                        </td>
                    </tr>
                    <tr>
                        <td style="border-bottom: 1px solid black;text-align:left;border-right: 1px solid black;padding:5px;">Conveyance</td>
                        <td style="border-bottom: 1px solid black;text-align:center;border-right: 1px solid black;padding:5px;">{{$monthly_conveyance = $yearly_conveyance / 12}}</td>
                        <td style="border-bottom: 1px solid black;text-align:center;border-right: 1px solid black;padding:5px;">{{$yearly_conveyance}}</td>
                        <td style="border-bottom: 1px solid black;text-align:center;border-right: 1px solid black;padding:5px;">{{$yearly_conveyance_non_tax_limit}}</td>
                        <td style="border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;">
                            {{$yearly_conveyance - $yearly_conveyance_non_tax_limit}}
                            @php
                                $monthly_income = $monthly_income + $monthly_conveyance;
                                $yearly_income  = $yearly_income  + $yearly_conveyance;
                                $non_tax_limit  = $non_tax_limit  + $yearly_conveyance_non_tax_limit;
                            @endphp
                        </td>
                    </tr>
                    <tr>
                        <td style="border-bottom: 1px solid black;text-align:left;border-right: 1px solid black;padding:5px;">Medical</td>
                        <td style="border-bottom: 1px solid black;text-align:center;border-right: 1px solid black;padding:5px;">{{$monthly_medical = $yearly_medical / 12}}</td>
                        <td style="border-bottom: 1px solid black;text-align:center;border-right: 1px solid black;padding:5px;">{{$yearly_medical}}</td>
                        <td style="border-bottom: 1px solid black;text-align:center;border-right: 1px solid black;padding:5px;">{{$yearly_medical_non_tax_limit}}</td>
                        <td style="border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;">
                            {{$yearly_medical - $yearly_medical_non_tax_limit}}
                            @php
                                $monthly_income = $monthly_income + $monthly_medical;
                                $yearly_income  = $yearly_income  + $yearly_medical;
                                $non_tax_limit  = $non_tax_limit  + $yearly_medical_non_tax_limit;
                            @endphp
                        </td>
                    </tr>
                    <tr>
                        <td style="border-bottom: 1px solid black;text-align:left;border-right: 1px solid black;padding:5px;">Festival Bonus</td>
                        <td style="border-bottom: 1px solid black;text-align:center;border-right: 1px solid black;padding:5px;">{{$monthly_festival_bonus = $yearly_festival_bonus / 2}}</td>
                        <td style="border-bottom: 1px solid black;text-align:center;border-right: 1px solid black;padding:5px;">{{$yearly_festival_bonus}}</td>
                        <td style="border-bottom: 1px solid black;text-align:center;border-right: 1px solid black;padding:5px;">0</td>
                        <td style="border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;">
                            {{$yearly_festival_bonus}}
                            @php
                                $monthly_income = $monthly_income + $monthly_festival_bonus;
                                $yearly_income  = $yearly_income  + $yearly_festival_bonus;
                            @endphp
                        </td>
                    </tr>
                    <tr>
                        <td style="border-bottom: 1px solid black;text-align:left;border-right: 1px solid black;padding:5px;">Other Allowance</td>
                        <td style="border-bottom: 1px solid black;text-align:center;border-right: 1px solid black;padding:5px;">{{$monthly_other_allowance = $yearly_other_allowance / 12}}</td>
                        <td style="border-bottom: 1px solid black;text-align:center;border-right: 1px solid black;padding:5px;">{{$yearly_other_allowance}}</td>
                        <td style="border-bottom: 1px solid black;text-align:center;border-right: 1px solid black;padding:5px;">0</td>
                        <td style="border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;">
                            {{$yearly_other_allowance}}
                            @php
                                $monthly_income = $monthly_income + $monthly_other_allowance;
                                $yearly_income  = $yearly_income  + $yearly_other_allowance;
                            @endphp
                        </td>
                    </tr>
                    <tr>
                        <td style="border-bottom: 1px solid black;text-align:left;border-right: 1px solid black;padding:5px;">PF (Company Portion)</td>
                        <td style="border-bottom: 1px solid black;text-align:center;border-right: 1px solid black;padding:5px;">{{$monthly_company_pf = $yearly_company_pf / 12}}</td>
                        <td style="border-bottom: 1px solid black;text-align:center;border-right: 1px solid black;padding:5px;">{{$yearly_company_pf}}</td>
                        <td style="border-bottom: 1px solid black;text-align:center;border-right: 1px solid black;padding:5px;">0</td>
                        <td style="border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;">
                            {{$yearly_company_pf}}
                            @php
                                $monthly_income = $monthly_income + $monthly_company_pf;
                                $yearly_income  = $yearly_income  + $yearly_company_pf;
                            @endphp
                        </td>
                    </tr>
                    <tr>
                        <td style="border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;font-weight:bold;">Total Taxable Income</td>
                        <td style="border-bottom: 1px solid black;text-align:center;border-right: 1px solid black;padding:5px;font-weight:bold;">{{$monthly_income}}</td>
                        <td style="border-bottom: 1px solid black;text-align:center;border-right: 1px solid black;padding:5px;font-weight:bold;">{{$yearly_income}}</td>
                        <td style="border-bottom: 1px solid black;text-align:center;border-right: 1px solid black;padding:5px;font-weight:bold;">{{$non_tax_limit}}</td>
                        <td style="border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;font-weight:bold;">{{$taxable_income}}</td>
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
                        <td style="border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;">{{$first_slab_amount}}</td>
                        <td style="border-bottom: 1px solid black;text-align:center;border-right: 1px solid black;padding:5px;">{{$tax_rule->first_tax_rate_percent}}%</td>
                        <td style="border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;">-</td>
                    </tr>
                    <tr>
                        <td style="border-bottom: 1px solid black;text-align:center;border-right: 1px solid black;padding:5px;">Next</td>
                        <td style="border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;">@if($second_slab_amount > 0){{$second_slab_amount}}@else-@endif</td>
                        <td style="border-bottom: 1px solid black;text-align:center;border-right: 1px solid black;padding:5px;">{{$tax_rule->second_tax_rate_percent}}%</td>
                        <td style="border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;">@if($second_slab_tax_amount > 0){{$second_slab_tax_amount}}@else-@endif</td>
                    </tr>
                    <tr>
                        <td style="border-bottom: 1px solid black;text-align:center;border-right: 1px solid black;padding:5px;">Next</td>
                        <td style="border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;">@if($third_slab_amount > 0){{$third_slab_amount}}@else-@endif</td>
                        <td style="border-bottom: 1px solid black;text-align:center;border-right: 1px solid black;padding:5px;">{{$tax_rule->third_tax_rate_percent}}%</td>
                        <td style="border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;">@if($third_slab_tax_amount > 0){{$third_slab_tax_amount}}@else-@endif</td>
                    </tr>
                    <tr>
                        <td style="border-bottom: 1px solid black;text-align:center;border-right: 1px solid black;padding:5px;">Next</td>
                        <td style="border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;">@if($forth_slab_amount > 0){{$forth_slab_amount}}@else-@endif</td>
                        <td style="border-bottom: 1px solid black;text-align:center;border-right: 1px solid black;padding:5px;">{{$tax_rule->forth_tax_rate_percent}}%</td>
                        <td style="border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;">@if($forth_slab_tax_amount > 0){{$forth_slab_tax_amount}}@else-@endif</td>
                    </tr>
                    <tr>
                        <td style="border-bottom: 1px solid black;text-align:center;border-right: 1px solid black;padding:5px;">Next</td>
                        <td style="border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;">@if($fifth_slab_amount > 0){{$fifth_slab_amount}}@else-@endif</td>
                        <td style="border-bottom: 1px solid black;text-align:center;border-right: 1px solid black;padding:5px;">{{$tax_rule->fifth_tax_rate_percent}}%</td>
                        <td style="border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;">@if($fifth_slab_tax_amount > 0){{$fifth_slab_tax_amount}}@else-@endif</td>
                    </tr>
                    <tr>
                        <td style="border-bottom: 1px solid black;text-align:center;border-right: 1px solid black;padding:5px;">Rest</td>
                        <td style="border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;">@if($rest_slab_amount > 0){{$rest_slab_amount}}@else-@endif</td>
                        <td style="border-bottom: 1px solid black;text-align:center;border-right: 1px solid black;padding:5px;">{{$tax_rule->rest_tax_rate_percent}}%</td>
                        <td style="border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;">@if($rest_slab_tax_amount > 0){{$rest_slab_tax_amount}}@else-@endif</td>
                    </tr>
                    <tr>
                        <td colspan="3" style="border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;font-weight:bold;">Gross Tax Payable for this year</td>
                        <td style="border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;font-weight:bold;">{{$tax_amount}}</td>
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
                        <td style="border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;">{{($tax_amount * 25) / 100}}</td>
                    </tr>
                    <tr>
                        <td style="border-bottom: 1px solid black;text-align:left;border-right: 1px solid black;padding:5px;">B. Actual Investment Amount (Including PF)</td>
                        <td style="border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;">{{$investment_amount}}</td>
                    </tr>
                    <tr>
                        <td style="border-bottom: 1px solid black;text-align:left;border-right: 1px solid black;padding:5px;">C. Maximum Investment Amount Allowed</td>
                        <td style="border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;">{{$tax_rule->maximum_investment_amount_allowed_yearly}}</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="border-top: 1px solid black;border-bottom: 1px solid black;text-align:left;border-right: 1px solid black;padding:5px;font-weight:bold;">Investment Allowance Amount</td>
                        <td style="border-top: 1px solid black;border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;font-weight:bold;">{{$investment_allow_amount}}</td>
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
                        <td style="border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;">{{$tax_amount}}</td>
                    </tr>
                    <tr>
                        <td style="border-bottom: 1px solid black;text-align:left;border-right: 1px solid black;padding:5px;">Less: Rebate for Investment Allowance (As per Table-3)</td>
                        <td style="border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;">{{$investment_allow_amount}}</td>
                    </tr>
                    <tr>
                        <td style="border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;font-weight:bold;">Annual Gross Tax Payable After Rebate</td>
                        <td style="border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;">{{$income_tax}}</td>
                    </tr>
                    <tr>
                        <td style="border-bottom: 1px solid black;text-align:left;border-right: 1px solid black;padding:5px;">Less: Advance Tax Paid (U/S 64/68) for Vehicle Registration</td>
                        <td style="border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;">12000</td>
                    </tr>
                    <tr>
                        <td style="border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;font-weight:bold;">Annual Net Tax Payable After Advance Tax</td>
                        <td style="border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;">{{$ait = $income_tax - 12000}}</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="border-top: 1px solid black;border-bottom: 1px solid black;text-align:left;border-right: 1px solid black;padding:5px;font-weight:bold;">Tax to be deducted at source (TDS) per month</td>
                        <td style="border-top: 1px solid black;border-bottom: 1px solid black;text-align:right;border-right: 1px solid black;padding:5px;font-weight:bold;">{{$ait / 12}}</td>
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

    {{--<script>

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

    <button class="btn btn-primary" onclick="printElem()">Print</button>--}}

</html>