@extends('layouts.master')

@section('content')

    <style>
        .ui-datepicker-calendar {
            display: none;
        }
        .ui-datepicker-prev {
            display: none;
        }
        .ui-datepicker-next {
            display: none;
        }
    </style>

    <div class="row mb-2">
        <div class="col-sm-6"></div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
            <li class="breadcrumb-item"><a href="{{url('/salary-sheet')}}" style="color:#6c757d; font-weight: bold">Salary Sheet</a></li>
            <li class="breadcrumb-item active"><a href="{{ url('salary-sheet-details/'.$month.'/'.$year) }}" style="color:#6c757d;">Details</a></li>
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
                    <hr>
                    <form action="{{ url('salary-sheet-details/'.$month.'/'.$year) }}" method="POST">
                        {{ csrf_field() }}
                        <div class="row">

                            <div class="col-md-2">
                                <select name="department_id" id="department_id" class="form-control select2-no-search">
                                    <option label="Department"></option>
                                    @foreach($departments as $department)
                                        <option value="{{$department->id}}" @if($department_id == $department->id) selected @endif>{{$department->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2">
                                <select name="project_id" id="project_id" class="form-control select2-no-search">
                                    <option label="Choose Project"></option>
                                    @foreach($projects as $project)
                                        <option value="{{$project->id}}" @if($project_id == $project->id) selected @endif>{{$project->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="branch_id" id="branch_id" class="form-control select2-no-search">
                                    <option label="Choose Branch"></option>
                                    @foreach($branches as $branch)
                                        <option value="{{$branch->id}}" @if($branch_id == $branch->id) selected @endif>{{$branch->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="currency_id" id="currency_id" class="form-control select2-no-search">
                                    <option label="Choose Currency"></option>
                                    @foreach($currencies as $currency)
                                        <option value="{{$currency->id}}" @if($currency_id == $currency->id) selected @endif>{{$currency->currency_name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2">
                                <select name="bank_id" id="bank_id" class="form-control select2-no-search">
                                    <option label="Choose Bank"></option>
                                    @foreach($banks as $bank)
                                        <option value="{{$bank->id}}" @if($bank_id == $bank->id) selected @endif>{{$bank->bank_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-md-2 text-left">
                                <input class="btn btn-main-primary" style="width:100px;" type="submit" value="Search"/>
                            </div>
                        </div>
                    </form>

                    <br>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mg-b-0 text-md-nowrap">
                            <thead>
                                <tr>
                                    <th class="text-center" style="vertical-align: middle;width:5%;">SL</th>
                                    <th style="vertical-align: middle;width:15%;">Employee Name</th>
                                    <th class="text-center" style="vertical-align: middle;width:10%;">Employee ID</th>
                                    <th style="vertical-align: middle;width:10%;">Department</th>
                                    <th style="vertical-align: middle;width:10%;">Project</th>
                                    <th style="vertical-align: middle;width:10%;">Branch</th>
                                    <th class="text-center" style="vertical-align: middle;width:10%;">Currency</th>
                                    <th class="text-left" style="vertical-align: middle;width:10%;">Bank Account</th>
                                    <th class="text-center" style="vertical-align: middle;width:10%;">Payable Salary</th>
                                    <th class="text-center" style="vertical-align: middle;width:10%;">Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($employment_infos as $employee)
                                <tr>
                                    <td class="text-center" style="vertical-align: middle">{{$loop->iteration}}</td>
                                    <td style="vertical-align: middle">{{$employee->name}}</td>
                                    <td class="text-center" style="vertical-align: middle">{{$employee->original_employee_id}}</td>
                                    <td style="vertical-align: middle">{{department_name($employee->department_id)}}</td>
                                    <td style="vertical-align: middle">{{project_name($employee->project_id)}}</td>
                                    <td style="vertical-align: middle">{{branch_name($employee->branch_id)}}</td>
                                    <td class="text-center" style="vertical-align: middle">{{currency_name($employee->currency_id)}}</td>
                                    <td class="text-center" style="vertical-align: middle">{{$employee->bank_account_no}}</td>
                                    <td class="text-center" style="vertical-align: middle">{{$employee->total_salary}}</td>
                                    <td class="text-center" style="vertical-align:middle">
                                        <a style="font-size: 15px;" class="btn btn-success btn-sm" href="{{ url('salary-sheet/details/'.$employee->employee_id.'/'.$month.'/'.$year) }}">Details</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    
                    <div class="visibility: hidden" id="printArea">
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

    <script>

        function printElem(){
            var mywindow = window.open('', 'PRINT');
            mywindow.document.write('<style>body {zoom:80%;}</style>');
            mywindow.document.write(document.getElementById('printArea').innerHTML);
    
            setTimeout(function () {
                mywindow.focus();
                mywindow.print();
                mywindow.close();
            }, 1000);
        }
      </script>

@endsection