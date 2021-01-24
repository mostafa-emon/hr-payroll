@extends('layouts.master')

@section('content')

        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)" style="color:#6c757d;">Salary Sheet Details</a></li>
            </ol>
            </div>
        </div>

    <div class="row row-sm">

        <!--div-->
        <div class="col-xl-12">
            <div class="card">

                <div class="card-header">
                    @if(session()->has('message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session()->get('message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                    @endif

                    @if(session()->has('error_message'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session()->get('error_message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                    @endif
                    
                    <div class="row">
                        <div class="col-md-6" style="padding-top:5px">
                            <h4 class="card-title mg-b-0">Pay Provident Fund</h4>
                        </div>
                        <div class="col-md-6 text-right">
                            <button class="btn btn-success" onclick="printElem()">Print</button>
                        </div>
                    </div>

                    <br>
                    <div class="table-responsive">
                        <div>
                            <table style="width:100%;" class="table table-striped table-bordered mg-b-0 text-md-nowrap">
                                <thead>
                                    {{--<tr class="visibility: hidden">
                                        <th colspan="5" style="font-size:17px;text-align:center;border:none">{{get_company_name(Auth::user()->company_id)}}</th>
                                    </tr>
                                    <tr class="visibility: hidden">
                                        <th colspan="5" style="font-size:15px;text-align:center;;border:none">Provident Fund</th>
                                    </tr>
                                    <tr class="visibility: hidden">
                                        <th colspan="5" style="font-size:15px;text-align:center;;border:none">Employee ID:{{$festival_details->employee_id}} <b>{{employee_name($festival_details->employee_id)}}</b></th>
                                    </tr>
                                    <tr class="visibility: hidden">
                                        <th colspan="5" style="font-size:15px;text-align:center;;border:none">{{employee_designation($festival_details->employee_id)}}</th>
                                    </tr>
                                    <tr class="visibility: hidden">
                                        <th colspan="5" style="font-size:15px;text-align:center;;border:none">Department: {{employee_department($festival_details->employee_id)}}</th>
                                    </tr>--}}
                                    <tr>
                                        <th style="width:5%;vertical-align: middle;text-align:center;">SL</th>
                                        <th style="width:12%;vertical-align: middle;text-align:center;">Component Type</th>
                                        <th style="width:15%;vertical-align: middle;text-align:center;">Applicable Month</th>
                                        <th style="width:20%;vertical-align: middle;text-align:center;">Component Name</th>
                                        <th style="width:12%;vertical-align: middle;text-align:center;">Total Amount</th>
                                        <th style="width:12%;vertical-align: middle;text-align:center;">Increase Amount</th>
                                        <th style="width:12%;vertical-align: middle;text-align:center;">Decrease Amount</th>
                                        <th style="width:12%;vertical-align: middle;text-align:right;">Payable Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $total_earning_amount = 0; $total_deduction_amount = 0; $festival_bonus = 0; $total_salary = 0; @endphp
                                    @foreach($earning_details as $earning)
                                    <tr>
                                        <td style="vertical-align: middle;text-align:center;">{{$loop->iteration}}</td>
                                        <td style="vertical-align: middle;text-align:center;">{{$earning->component_type}}</td>
                                        <td style="vertical-align: middle;text-align:center;">{{$earning->month}} {{$earning->year}}</td>
                                        <td style="vertical-align: middle;text-align:center;">{{$earning->component_name}}</td>
                                        <td style="vertical-align: middle;text-align:center;">{{$earning->actual_amount}}</td>
                                        <td style="vertical-align: middle;text-align:center;">{{$earning->increase_adjustment}}</td>
                                        <td style="vertical-align: middle;text-align:center;">{{$earning->decrease_adjustment}}</td>

                                        <td style="vertical-align: middle;text-align:right;">
                                            {{$earning->payable_amount}}
                                            @php $total_earning_amount = $total_earning_amount + $earning->payable_amount; @endphp
                                        </td>
                                    </tr>
                                    @endforeach

                                    <tr>
                                        <td style="text-align:right;font-weight:bold;" colspan="7">Total Earning Amount</td>
                                        <td style="vertical-align: middle;text-align:right;font-weight:bold;">{{ $total_earning_amount }}</td>
                                    </tr>

                                    @if($festival_details != "")
                                        <tr><td style="text-align:right;font-weight:bold;" colspan="8">&nbsp</td></tr>

                                        <tr>
                                            <td style="vertical-align: middle;text-align:center;">1</td>
                                            <td style="vertical-align: middle;text-align:center;">{{$festival_details->component_type}}</td>
                                            <td style="vertical-align: middle;text-align:center;">{{$festival_details->month}} {{$festival_details->year}}</td>
                                            <td style="vertical-align: middle;text-align:center;">{{$festival_details->component_name}}</td>
                                            <td style="vertical-align: middle;text-align:center;">{{$festival_details->actual_amount}}</td>
                                            <td style="vertical-align: middle;text-align:center;">{{$festival_details->increase_adjustment}}</td>
                                            <td style="vertical-align: middle;text-align:center;">{{$festival_details->decrease_adjustment}}</td>

                                            <td style="vertical-align: middle;text-align:right;">
                                                {{$festival_details->payable_amount}}
                                                @php $festival_bonus = $festival_details->payable_amount @endphp
                                            </td>
                                        </tr>
                                    @endif

                                    <tr><td style="text-align:right;font-weight:bold;" colspan="8">&nbsp</td></tr>

                                    @foreach($deduction_details as $deduction)
                                    <tr>
                                        <td style="vertical-align: middle;text-align:center;">{{$loop->iteration}}</td>
                                        <td style="vertical-align: middle;text-align:center;">{{$deduction->component_type}}</td>
                                        <td style="vertical-align: middle;text-align:center;">{{$deduction->month}} {{$deduction->year}}</td>
                                        <td style="vertical-align: middle;text-align:center;">{{$deduction->component_name}}</td>
                                        <td style="vertical-align: middle;text-align:center;">{{$deduction->actual_amount}}</td>
                                        <td style="vertical-align: middle;text-align:center;">{{$deduction->increase_adjustment}}</td>
                                        <td style="vertical-align: middle;text-align:center;">{{$deduction->decrease_adjustment}}</td>

                                        <td style="vertical-align: middle;text-align:right;">
                                            {{$deduction->payable_amount}}
                                            @php $total_deduction_amount = $total_deduction_amount + $deduction->payable_amount; @endphp
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td style="text-align:right;font-weight:bold;" colspan="7">Total Deduction Amount</td>
                                        <td style="vertical-align: middle;text-align:right;font-weight:bold;">{{ $total_deduction_amount }}</td>
                                    </tr>

                                    <tr><td style="text-align:right;font-weight:bold;" colspan="8">&nbsp</td></tr>

                                    <tr>
                                        <td style="text-align:right;font-weight:bold;" colspan="7">Total Salary</td>
                                        <td style="vertical-align: middle;text-align:right;font-weight:bold;">
                                            @php 
                                                $total_salary = $total_salary + $total_earning_amount + $festival_bonus + $total_deduction_amount;
                                            @endphp
                                            {{$total_salary}}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div id="printArea" class="visibility: hidden">
                        <div>
                            <div style="text-align:center;font-family: Arial;font-weight:bold;font-size:20px;">
                                ABC Company Limited
                            </div>
                        
                            <br>
                        
                            <div style="text-align:center;font-family: Arial;font-weight:bold;">
                                Salary Sheet
                            </div>
                        
                            <br>
                        
                            <div style="text-align:center;font-family: Arial;">
                                For the Month of Dec-2020
                            </div>
                        </div>
            
                        <br>
            
                        <div style="font-family: Arial;">
                            Department: <b>Finance</b>
                        </div>
            
                        <br>
            
                        <div style="text-align:center;font-family: Arial;">
                            <table style="width:100%;border: 1px solid black;border-collapse: collapse;">
                                <tr>
                                  <th rowspan="2" style="border-right: 1px solid black;padding:5px;width:7%;">Employee ID</th>
                                  <th rowspan="2" style="border-right: 1px solid black;padding:5px;width:13%;">Name</th>
                                  <th rowspan="2" style="border-right: 1px solid black;padding:5px;width:10%;">Designation</th>
                                  <th colspan="6" style="text-align:center;border-bottom: 1px solid black;border-right: 1px solid black;padding:5px;width:25%;">Earnings</th>
                                  <th rowspan="2" style="border-right: 1px solid black;padding:5px;width:5%;">Total Earnings</th>
                                  <th colspan="3" style="text-align:center;border-bottom: 1px solid black;border-right: 1px solid black;padding:5px;width:25%;">Deductions</th>
                                  <th rowspan="2" style="border-right: 1px solid black;padding:5px;width:5%;">Total Deductions</th>
                                  <th rowspan="2" style="border-right: 1px solid black;padding:5px;width:5%;">Net Salary</th>
                                  <th rowspan="2" style="border-right: 1px solid black;padding:5px;width:5%;">Revenue Stamp</th>
                                </tr>
            
                                <tr>
                                  <td style="border-right: 1px solid black;padding:5px;font-weight:bold;">Basic</td>
                                  <td style="border-right: 1px solid black;padding:5px;font-weight:bold;">House Rent</td>
                                  <td style="border-right: 1px solid black;padding:5px;font-weight:bold;">Conveyance</td>
                                  <td style="border-right: 1px solid black;padding:5px;font-weight:bold;">Medical</td>
                                  <td style="border-right: 1px solid black;padding:5px;font-weight:bold;">Festival Bonus</td>
                                  <td style="border-right: 1px solid black;padding:5px;font-weight:bold;">Other Adj.</td>
            
                                  <td style="border-right: 1px solid black;padding:5px;font-weight:bold;">Income Tax</td>
                                  <td style="border-right: 1px solid black;padding:5px;font-weight:bold;">Absent</td>
                                  <td style="border-right: 1px solid black;padding:5px;font-weight:bold;">Other</td>
                                </tr>
            
                                <tr>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">968647</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">Md. Hafijur Rahman</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">Manager Finance</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">30,000.00</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">15,000.00</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">3,000.00</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">2,000.00</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">30,000.00</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">1,000.00</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">81,000.00</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">3,000.00</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">4,000.00</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">500.00</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">7,500.00</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">73,500.00</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                </tr>
            
                                <tr>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                </tr>
            
                                <tr>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                </tr>
            
                                <tr>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                </tr>
            
                                <tr>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                    <td style="border-top: 1px solid black;border-right: 1px solid black;padding:5px;">&nbsp</td>
                                </tr>
                                
                                <tr>
                                    <td colspan="3" style="border-top: 1px solid black;border-bottom: 1px solid black;border-right: 1px solid black;padding:5px;text-align:right;font-weight:bold;">Total</td>
                                    <td style="border-top: 1px solid black;border-bottom: 1px solid black;border-right: 1px solid black;padding:5px;font-weight:bold;">30,000.00</td>
                                    <td style="border-top: 1px solid black;border-bottom: 1px solid black;border-right: 1px solid black;padding:5px;font-weight:bold;">15,000.00</td>
                                    <td style="border-top: 1px solid black;border-bottom: 1px solid black;border-right: 1px solid black;padding:5px;font-weight:bold;">3,000.00</td>
                                    <td style="border-top: 1px solid black;border-bottom: 1px solid black;border-right: 1px solid black;padding:5px;font-weight:bold;">2,000.00</td>
                                    <td style="border-top: 1px solid black;border-bottom: 1px solid black;border-right: 1px solid black;padding:5px;font-weight:bold;">30,000.00</td>
                                    <td style="border-top: 1px solid black;border-bottom: 1px solid black;border-right: 1px solid black;padding:5px;font-weight:bold;">1,000.00</td>
                                    <td style="border-top: 1px solid black;border-bottom: 1px solid black;border-right: 1px solid black;padding:5px;font-weight:bold;">81,000.00</td>
                                    <td style="border-top: 1px solid black;border-bottom: 1px solid black;border-right: 1px solid black;padding:5px;font-weight:bold;">3,000.00</td>
                                    <td style="border-top: 1px solid black;border-bottom: 1px solid black;border-right: 1px solid black;padding:5px;font-weight:bold;">4,000.00</td>
                                    <td style="border-top: 1px solid black;border-bottom: 1px solid black;border-right: 1px solid black;padding:5px;font-weight:bold;">500.00</td>
                                    <td style="border-top: 1px solid black;border-bottom: 1px solid black;border-right: 1px solid black;padding:5px;font-weight:bold;">7,500.00</td>
                                    <td style="border-top: 1px solid black;border-bottom: 1px solid black;border-right: 1px solid black;padding:5px;font-weight:bold;">73,500.00</td>
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

                </div>
                
            </div>
        </div>

    </div>

    <style>
        table {
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            font-family:arial;
            font-size:13px;
            padding:5px;
        }
    </style>

    <script>
        function get_employee() {
            var department_id = $('#department_id').val();
            var project_id = $('#project_id').val();
            var branch_id = $('#branch_id').val();

            if(department_id == "") {department_id = 0;}
            if(project_id == "") {project_id = 0;}
            if(branch_id == "") {branch_id = 0;}

            var url = '/search-employee/'+department_id;
            if(project_id != "") { url = url +'/'+ project_id;} else { url = url + '/0';}
            if(branch_id != "") { url = url +'/'+ branch_id;} else { url = url + '/0';}

            $.ajax({
                type:'GET',
                url:url,
                success:function(data) {
                    console.log(data)
                    $('#employee_id').html('');
                    $('#employee_id').append('<option value="" selected>Choose Employee</option>');
                    $('#employee_id').append(data);
                }
            });
        }

        function printElem(){
            var mywindow = window.open('', 'PRINT');
            mywindow.document.write('<style>table {border-collapse: collapse;} th, td {border: 1px solid black;font-family:arial;font-size:13px;padding:7px;} .div-padding-30{padding:30px;} body {zoom:80%;}</style>');
            mywindow.document.write(document.getElementById('printArea').innerHTML);

            setTimeout(function () {
                mywindow.focus();
                mywindow.print();
                mywindow.close();

                //window.location = "/mr"
            }, 1000);
        }

    </script>

@endsection