@extends('layouts.master')

@section('content')

        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('/roster')}}" style="color:#6c757d; font-weight: bold">Roster</a></li>
                <li class="breadcrumb-item active"><a href="{{url('/create-roster')}}" style="color:#6c757d;">Create</a></li>
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
                            <h4 class="card-title mg-b-0">Search Roster</h4>
                        </div>
                        <div class="col-md-6 text-right">
                            @if($department_id !="")
                                <a href="{{url('roster-search')}}" class="btn btn-info">Reset</a>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <form action="{{ url('roster-search') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-2">
                                <select name="department_id" id="department_id" class="form-control select2-no-search" onchange="get_employee()">
                                        <option label="Department"></option>
                                        @foreach($departments as $department)
                                            <option value="{{$department->id}}" @if($department_id == $department->id) selected @endif>{{$department->name}}</option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="project_id" id="project_id" class="form-control select2-no-search" onchange="get_employee()">
                                        <option label="Choose Project"></option>
                                        @foreach($projects as $project)
                                            <option value="{{$project->id}}" @if($project_id == $project->id) selected @endif>{{$project->name}}</option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="branch_id" id="branch_id" class="form-control select2-no-search" onchange="get_employee()">
                                        <option label="Choose Branch"></option>
                                        @foreach($branches as $branch)
                                            <option value="{{$branch->id}}" @if($branch_id == $branch->id) selected @endif>{{$branch->name}}</option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="employee_id" id="employee_id" class="form-control select2-no-search" required>
                                    <option label="Choose Employee"></option>
                                    @foreach($employment_infos as $employment_info)
                                        <option value="{{$employment_info->employee_id}}" @if($employee_id == $employment_info->employee_id) selected @endif>{{$employment_info->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="from_date" class="form-control dtpicker" autocomplete="off" placeholder="from date" value="@if($from_date != ""){{date('d-m-Y',strtotime($from_date))}}@endif" required/>
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="to_date" class="form-control dtpicker" autocomplete="off" placeholder="to date" value="@if($from_date != ""){{date('d-m-Y',strtotime($to_date))}}@endif" required/>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-3 text-left">
                                <input class="btn btn-main-primary" style="width:100px;" type="submit" value="Search"/>
                            </div>
                        </div>
                    </form>

                    @if($roster_employees !='')
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th style="width:7%;" class="text-center">SL</th>
                                        <th style="width:30%;">Employee Name</th>
                                        <th style="width:20%;">Date</th>
                                        <th style="width:20%;">Shift Name</th>
                                        <th style="width:10%;" class="text-center">Day Off</th>
                                        <th style="width:13%;" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($roster_employees as $employee)
                                        <tr>
                                            <td style="vertical-align: middle;" class="text-center">{{$loop->iteration}}</td>
                                            <td style="vertical-align: middle;">{{employee_name_by_increment_id($employee->employee_id)}}</td>
                                            <td style="vertical-align: middle">{{$employee->date}}</td>
                                            <td style="vertical-align: middle">{{shift_name($employee->shift_id)}}</td>
                                            <td style="vertical-align: middle" class="text-center">
                                                @if($employee->day_off == 1) Yes @else No @endif
                                            </td>
                                            <td style="vertical-align: middle" class="text-center">
                                                <button data-toggle="dropdown" class="btn btn-success btn-sm">Action <i class="icon ion-ios-arrow-down tx-11 mg-l-3"></i></button>
                                                <div class="dropdown-menu">
                                                    <a href="{{url('roster-employee/update/'.$employee->id)}}" class="dropdown-item">Update</a>
                                                    <a href="javascript:void(0)" class="dropdown-item" onclick="confirmDelete({{$employee->id}})">Delete</a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
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

                if(department_id == "") {department_id = 0;}
                if(project_id == "") {project_id = 0;}
                if(branch_id == "") {branch_id = 0;}

                var url = '/search-roster-employee/'+department_id;
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

        function confirmDelete(id) {
            var r = confirm("Are you confirm to delete?");
            if (r == true) {
            window.location = "/roster-employee/delete/"+id;
            }
        }
    </script>

@endsection