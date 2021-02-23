@extends('layouts.master')

@section('content')

        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('/gratuity')}}" style="color:#6c757d; font-weight: bold">Gratuity</a></li>
                <li class="breadcrumb-item active"><a href="{{url('/gratuity-create')}}" style="color:#6c757d;">Create</a></li>
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
                            <h4 class="card-title mg-b-0">Create Gratuity</h4>
                        </div>
                        <div class="col-md-6 text-right">
                        </div>
                    </div>
                    <hr>
                    <form action="{{ url('gratuity-create') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-4">
                                <select name="department_id" id="department_id" class="form-control select2-no-search" onchange="get_employee()">
                                    <option label="Department"></option>
                                    @foreach($departments as $department)
                                        <option value="{{$department->id}}" @if($department_id == $department->id) selected @endif>{{$department->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select name="project_id" id="project_id" class="form-control select2-no-search" onchange="get_employee()">
                                    <option label="Choose Project"></option>
                                    @foreach($projects as $project)
                                        <option value="{{$project->id}}" @if($project_id == $project->id) selected @endif>{{$project->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select name="branch_id" id="branch_id" class="form-control select2-no-search" onchange="get_employee()">
                                    <option label="Choose Branch"></option>
                                    @foreach($branches as $branch)
                                        <option value="{{$branch->id}}" @if($branch_id == $branch->id) selected @endif>{{$branch->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-4">
                                <select id="employee_id" name="employee_id[]" class="form-control employee_multiple" multiple="multiple" required>
                                    <option label="Employee Name"></option>
                                    <option value="All" @if($all_employee !='') selected @endif>All</option>
                                    @foreach($employment_infos as $employment_info)
                                        <option value="{{$employment_info->employee_id}}" @if($all_employee =='') {{ (collect($employee_id)->contains($employment_info->employee_id)) ? 'selected':'' }} @endif>{{$employment_info->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="year" class="form-control" placeholder="Year; Ex:2010" value="{{$year}}" required/>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-3 text-left">
                                <input class="btn btn-main-primary" style="width:100px;" type="submit" value="Search"/>
                            </div>
                        </div>
                    </form>

                    @if($year !='')
                        <br>
                        <div class="table-responsive">
                            <form method="post" action="{{url('store-gratuity')}}">
                                {{ csrf_field() }}
                                <input type="hidden" name="store_year" value="{{$year}}"/>

                                <table class="table table-striped table-bordered mg-b-0 text-md-nowrap">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width:5%;vertical-align: middle;">SL</th>
                                            <th style="width:20%;vertical-align: middle;">Employee Name</th>
                                            <th class="text-center" style="width:15%;vertical-align: middle;">Employee ID</th>
                                            <th class="text-center" style="width:20%;vertical-align: middle;">Department</th>
                                            <th class="text-center" style="width:20%;vertical-align: middle;">Designation</th>
                                            <th class="text-center" style="width:10%;vertical-align: middle;">Gratuity Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($employment_infos as $employee)
                                        <tr>
                                            <td class="text-center" style="vertical-align: middle">{{$loop->iteration}}</td>
                                            <td style="vertical-align: middle">{{$employee->name}}</td>
                                            <td class="text-center" style="vertical-align: middle">{{$employee->employee_id}}</td>
                                            <td class="text-center" style="vertical-align: middle">{{department_name($employee->department_id)}}</td>
                                            <td class="text-center" style="vertical-align: middle">{{designation_name($employee->designation_id)}}</td>
                                            <td style="vertical-align: middle">
                                                <input type="hidden" name="employee_id[]" class="form-control" value="{{get_auto_increment_employee_id($employee->employee_id)}}">
                                                <input type="text" name="gratuity_amount[]" class="form-control" placeholder="Gratuity Amount" value="{{get_gratuity_amount($employee->employee_id)}}">
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
                    $('#employee_id').append('<option value="All">All</option>');
                    $('#employee_id').append(data);
                }
            });
        }
    </script>

@endsection