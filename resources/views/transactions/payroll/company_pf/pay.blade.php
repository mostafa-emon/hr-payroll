@extends('layouts.master')

@section('content')

        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('/company-pf')}}" style="color:#6c757d; font-weight: bold">Company PF</a></li>
                <li class="breadcrumb-item active"><a href="{{url('/company-pf-pay')}}" style="color:#6c757d;">Pay PF</a></li>
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
                            <h4 class="card-title mg-b-0">Pay Company PF</h4>
                        </div>
                        <div class="col-md-6 text-right">
                            @if(count($company_pfs) > 0)
                                <button class="btn btn-success" onclick="printElem()">Print</button>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <form action="{{ url('company-pf-pay') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-3">
                                <select name="department_id" id="department_id" class="form-control select2-no-search" onchange="get_employee()">
                                        <option label="Department"></option>
                                        @foreach($departments as $department)
                                            <option value="{{$department->id}}" @if($department_id == $department->id) selected @endif>{{$department->name}}</option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="project_id" id="project_id" class="form-control select2-no-search" onchange="get_employee()">
                                        <option label="Choose Project"></option>
                                        @foreach($projects as $project)
                                            <option value="{{$project->id}}" @if($project_id == $project->id) selected @endif>{{$project->name}}</option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="branch_id" id="branch_id" class="form-control select2-no-search" onchange="get_employee()">
                                        <option label="Choose Branch"></option>
                                        @foreach($branches as $branch)
                                            <option value="{{$branch->id}}" @if($branch_id == $branch->id) selected @endif>{{$branch->name}}</option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="employee_id" id="employee_id" class="form-control select2-no-search" required>
                                    <option label="Choose Employee"></option>
                                    @foreach($employment_infos as $employment_info)
                                        <option value="{{$employment_info->employee_id}}" @if($employee_id == $employment_info->employee_id) selected @endif>{{$employment_info->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        @if(count($company_pfs) == 0)
                            <div class="row">
                                <div class="col-md-3 text-left">
                                    <input class="btn btn-main-primary" style="width:100px;" type="submit" value="Search"/>
                                </div>
                            </div>
                        @endif
                    </form>

                    @if(count($company_pfs) > 0)
                        <br>
                        <div class="div-padding-30">
                            <div id="printArea">
                                <table style="width:100%;">
                                    <thead>
                                        @php 

                                        @endphp
                                        <tr>
                                            <th colspan="5" style="font-size:17px;text-align:center;border:none">{{get_company_name(Auth::user()->company_id)}}</th>
                                        </tr>
                                        <tr>
                                            <th colspan="5" style="font-size:15px;text-align:center;;border:none">Provident Fund</th>
                                        </tr>
                                        <tr>
                                            <th colspan="5" style="font-size:15px;text-align:center;;border:none">Employee ID:{{$employee_id}} <b>{{employee_name($employee_id)}}</b></th>
                                        </tr>
                                        @php $employee_auto_increment_id = get_auto_increment_employee_id($employee_id); @endphp
                                        <tr>
                                            <th colspan="5" style="font-size:15px;text-align:center;;border:none">{{employee_department($employee_auto_increment_id)}}</th>
                                        </tr>
                                        <tr>
                                            <th colspan="5" style="font-size:15px;text-align:center;;border:none">{{employee_designation($employee_auto_increment_id)}}</th>
                                        </tr>
                                        <tr>
                                            <th style="width:5%;vertical-align: middle;text-align:center;">SL</th>
                                            <th style="width:25%;vertical-align: middle;text-align:center;">Applicable Month</th>
                                            <th style="width:25%;vertical-align: middle;text-align:center;">Applicable Year</th>
                                            <th style="width:20%;vertical-align: middle;text-align:center;">PF Type</th>
                                            <th style="width:20%;vertical-align: middle;text-align:right;">PF Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $total_pf_amount = 0; @endphp
                                        @foreach($company_pfs as $pf)
                                        @php 
                                            $employee = get_employee_info($pf->employee_id);
                                        @endphp
                                        <tr>
                                            <td style="vertical-align: middle;text-align:center;">{{$loop->iteration}}</td>
                                            <td style="vertical-align: middle;text-align:center;">{{$pf->month}}</td>
                                            <td style="vertical-align: middle;text-align:center;">{{$pf->year}}</td>
                                            <td style="vertical-align: middle;text-align:center;">{{$pf->type}}</td>
                                            <td style="vertical-align: middle;text-align:right;">
                                                {{$pf->amount}}
                                                @php $total_pf_amount = $total_pf_amount + $pf->amount; @endphp
                                            </td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td style="text-align:right;font-weight:bold;" colspan="4">Total PF Amount</td>
                                            <td style="vertical-align: middle;text-align:right;font-weight:bold;">{{ $total_pf_amount }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="pd-t-15 text-center">
                                <button class="btn btn-primary" onclick="confirmpay({{$increment_employee_id}})">Submit</button>
                            </div>
                        </div>
                    @endif

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

        function confirmpay(id) {
            var r = confirm("Are you confirm to pay?");
            if (r == true) {
            window.location = "/company-pf-pay-store/"+id;
            }
        }
    </script>

@endsection