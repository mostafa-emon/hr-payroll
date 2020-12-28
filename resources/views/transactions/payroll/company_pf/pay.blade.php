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
                            @if($employee_id !='')
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
                        @if($employee_id =='')
                            <div class="row">
                                <div class="col-md-3 text-left">
                                    <input class="btn btn-main-primary" style="width:100px;" type="submit" value="Search"/>
                                </div>
                            </div>
                        @endif
                    </form>

                    @if($employee_id !='')
                        <br>
                        <div class="table-responsive">
                            <form method="post" action="{{url('store-company-pf')}}">
                                {{ csrf_field() }}

                                <div id="printArea">
                                    <table class="table table-striped table-bordered mg-b-0 text-md-nowrap">
                                        <thead>
                                            <tr>
                                                <th class="text-center" style="width:5%;">SL</th>
                                                <th style="width:20%;">Employee Name</th>
                                                <th class="text-center" style="width:15%;">Employee ID</th>
                                                <th class="text-center" style="width:20%;">Department</th>
                                                <th class="text-center" style="width:20%;">Designation</th>
                                                <th class="text-center" style="width:10%;">PF Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $total_pf_amount = 0; @endphp
                                            @foreach($company_pfs as $pf)
                                            @php 
                                                $employee = get_employee_info($pf->employee_id);
                                            @endphp
                                            <tr>
                                                <td class="text-center" style="vertical-align: middle">{{$loop->iteration}}</td>
                                                <td style="vertical-align: middle">{{$employee->name}}</td>
                                                <td class="text-center" style="vertical-align: middle">{{$employee->employee_id}}</td>
                                                <td class="text-center" style="vertical-align: middle">{{employee_department($employee->id)}}</td>
                                                <td class="text-center" style="vertical-align: middle">{{employee_designation($employee->id)}}</td>
                                                <td class="text-center" style="vertical-align: middle">
                                                    {{$pf->amount}}
                                                    @php $total_pf_amount = $total_pf_amount + $pf->amount; @endphp
                                                </td>
                                            </tr>
                                            @endforeach
                                            <tr>
                                                <td class="text-center" colspan="5">Total PF Amount</td>
                                                <td class="text-center" style="vertical-align: middle">{{ $total_pf_amount }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="pd-t-15 text-center">
                                    <input class="btn btn-main-primary" style="width:100px;" type="submit" value="Submit"/>
                                </div>
                            </form>
                        </div>
                    @endif

                </div>
                
            </div>
        </div>

    </div>

    <script>
        function get_employee() {
            var department_id = $('#department_id').val();
            var project_id = $('#project_id').val();
            var branch_id = $('#branch_id').val();

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