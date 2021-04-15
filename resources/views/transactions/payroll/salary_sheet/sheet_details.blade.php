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
                            <h4 class="card-title mg-b-0">Salary Sheet Details</h4>
                        </div>
                        <div class="col-md-6 text-right">
                            <button class="btn btn-success" onclick="printElem()">Print</button>
                        </div>
                    </div>

                    <br>
                    <div class="table-responsive">
                        <div id="printArea">
                            <table style="width:100%;" class="table table-striped table-bordered mg-b-0 text-md-nowrap">
                                <thead>
                                    <tr class="visibility: hidden">
                                        <th colspan="8" style="font-size:17px;text-align:center;border:none">{{get_company_name(Auth::user()->company_id)}}</th>
                                    </tr>
                                    <tr class="visibility: hidden">
                                        <th colspan="8" style="font-size:15px;text-align:center;;border:none">Salary Sheet Details</th>
                                    </tr>
                                    <tr class="visibility: hidden">
                                        <th colspan="8" style="font-size:15px;text-align:center;;border:none">Employee Name: <b>{{employee_name_by_increment_id($employee_id)}}</b></th>
                                    </tr>
                                    <tr class="visibility: hidden">
                                        <th colspan="8" style="font-size:15px;text-align:center;;border:none">{{employee_designation($employee_id)}}</th>
                                    </tr>
                                    <tr class="visibility: hidden">
                                        <th colspan="8" style="font-size:15px;text-align:center;;border:none">Department: {{employee_department($employee_id)}}</th>
                                    </tr>
                                    <tr>
                                        <th style="width:5%;vertical-align: middle;text-align:center;">SL</th>
                                        <th style="width:12%;vertical-align: middle;text-align:center;">Component Type</th>
                                        <th style="width:15%;vertical-align: middle;text-align:center;">Applicable Month</th>
                                        <th style="width:20%;vertical-align: middle;">Component Name</th>
                                        <th style="width:12%;vertical-align: middle;text-align:center;">Total Amount</th>
                                        <th style="width:12%;vertical-align: middle;text-align:center;">Increase Amount</th>
                                        <th style="width:12%;vertical-align: middle;text-align:center;">Decrease Amount</th>
                                        <th style="width:12%;vertical-align: middle;text-align:right;">Payable Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $total_earning_amount = 0; $total_deduction_amount = 0; $festival_bonus = 0; $total_salary = 0; $festival_serial = 0; @endphp
                                    @if(count($earning_details) > 0)
                                        @foreach($earning_details as $earning)
                                        <tr>
                                            <td style="vertical-align: middle;text-align:center;">{{$loop->iteration}}</td>
                                            <td style="vertical-align: middle;text-align:center;">{{$earning->component_type}}</td>
                                            <td style="vertical-align: middle;text-align:center;">{{$earning->month}} {{$earning->year}}</td>
                                            <td style="vertical-align: middle;">{{$earning->component_name}}</td>
                                            <td style="vertical-align: middle;text-align:center;">{{number_formatting($earning->actual_amount)}}</td>
                                            <td style="vertical-align: middle;text-align:center;">{{number_formatting($earning->increase_adjustment)}}</td>
                                            <td style="vertical-align: middle;text-align:center;">{{number_formatting($earning->decrease_adjustment)}}</td>

                                            <td style="vertical-align: middle;text-align:right;">
                                                {{number_formatting($earning->payable_amount)}}
                                                @php 
                                                    $total_earning_amount   = $total_earning_amount + $earning->payable_amount;
                                                    $festival_serial        = $loop->iteration + 1;
                                                @endphp
                                            </td>
                                        </tr>
                                        @endforeach
                                    @endif

                                    @if($festival_details != "")
                                        <tr>
                                            <td style="vertical-align: middle;text-align:center;">{{$festival_serial}}</td>
                                            <td style="vertical-align: middle;text-align:center;">{{$festival_details->component_type}}</td>
                                            <td style="vertical-align: middle;text-align:center;">{{$festival_details->month}} {{$festival_details->year}}</td>
                                            <td style="vertical-align: middle;">{{$festival_details->component_name}}</td>
                                            <td style="vertical-align: middle;text-align:center;">{{number_formatting($festival_details->actual_amount)}}</td>
                                            <td style="vertical-align: middle;text-align:center;">{{number_formatting($festival_details->increase_adjustment)}}</td>
                                            <td style="vertical-align: middle;text-align:center;">{{number_formatting($festival_details->decrease_adjustment)}}</td>

                                            <td style="vertical-align: middle;text-align:right;">
                                                {{number_formatting($festival_details->payable_amount)}}
                                                @php $festival_bonus = $festival_details->payable_amount @endphp
                                            </td>
                                        </tr>
                                     @endif

                                    <tr>
                                        <td style="text-align:right;font-weight:bold;" colspan="7">Total Earning Amount</td>
                                        <td style="vertical-align: middle;text-align:right;font-weight:bold;">{{number_formatting($total_earning_amount + $festival_bonus)}}</td>
                                    </tr>


                                    <tr><td style="text-align:right;font-weight:bold;" colspan="8">&nbsp</td></tr>

                                    @if(count($deduction_details) > 0)
                                        @foreach($deduction_details as $deduction)
                                        <tr>
                                            <td style="vertical-align: middle;text-align:center;">{{$loop->iteration}}</td>
                                            <td style="vertical-align: middle;text-align:center;">{{$deduction->component_type}}</td>
                                            <td style="vertical-align: middle;text-align:center;">{{$deduction->month}} {{$deduction->year}}</td>
                                            <td style="vertical-align: middle;">{{$deduction->component_name}}</td>
                                            <td style="vertical-align: middle;text-align:center;">{{number_formatting($deduction->actual_amount)}}</td>
                                            <td style="vertical-align: middle;text-align:center;">{{number_formatting($deduction->increase_adjustment)}}</td>
                                            <td style="vertical-align: middle;text-align:center;">{{number_formatting($deduction->decrease_adjustment)}}</td>

                                            <td style="vertical-align: middle;text-align:right;">
                                                {{number_formatting($deduction->payable_amount)}}
                                                @php $total_deduction_amount = $total_deduction_amount + $deduction->payable_amount; @endphp
                                            </td>
                                        </tr>
                                        @endforeach
                                    @endif

                                    <tr>
                                        <td style="text-align:right;font-weight:bold;" colspan="7">Total Deduction Amount</td>
                                        <td style="vertical-align: middle;text-align:right;font-weight:bold;">{{ number_formatting($total_deduction_amount) }}</td>
                                    </tr>

                                    <tr><td style="text-align:right;font-weight:bold;" colspan="8">&nbsp</td></tr>
                                    

                                    <tr>
                                        <td style="text-align:right;font-weight:bold;" colspan="7">Total Salary</td>
                                        <td style="vertical-align: middle;text-align:right;font-weight:bold;">
                                            @php 
                                                $total_salary = ($total_salary + $total_earning_amount + $festival_bonus) - $total_deduction_amount;
                                            @endphp
                                            {{number_formatting($total_salary)}}
                                        </td>
                                    </tr>
                                </tbody>
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
            mywindow.document.write('<style>table {border-collapse: collapse;} th, td {border: 1px solid black;font-family:arial;font-size:13px;padding:7px;} .div-padding-30{padding:30px;}</style>');
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