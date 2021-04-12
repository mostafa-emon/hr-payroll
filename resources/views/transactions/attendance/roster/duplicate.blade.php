@extends('layouts.master')

@section('content')

        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('/roster')}}" style="color:#6c757d; font-weight: bold">Roster</a></li>
                <li class="breadcrumb-item active"><a href="{{url('roster-duplicate/'.$roster->id)}}" style="color:#6c757d;">Duplicate</a></li>
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
                            <h4 class="card-title mg-b-0">Duplicate Roster</h4>
                        </div>
                    </div>
                    <hr>
                    <form action="{{ url('create-roster') }}" method="POST">
                        {{ csrf_field() }}

                        @php 
                            $datepicker_format = datepicker_format();
                            $date_format = 'd-m-Y';
                            
                            if($datepicker_format == "MM-DD-YYYY") {
                                $date_format = 'm-d-Y';
                            }else if($datepicker_format == "YYYY/MM/DD") {
                                $date_format = 'Y/m/d';
                            }else if($datepicker_format == "DD-MMM-YY") {
                                $date_format = 'd-M-Y';
                            }
                        @endphp

                        <div class="row">
                            <div class="col-md-3">
                                <input type="text" name="roster_name" class="form-control" placeholder="Roster Title" value="{{$roster_name}}" required/>
                            </div>
                            <div style="display:none;" class="col-md-3">
                                <select name="department_id" id="department_id" class="form-control select2-no-search" onchange="get_employee()">
                                        <option label="Department"></option>
                                        @foreach($departments as $department)
                                            <option value="{{$department->id}}" @if($department_id == $department->id) selected @endif>{{$department->name}}</option>
                                        @endforeach
                                </select>
                            </div>
                            <div style="display:none;" class="col-md-3">
                                <select name="project_id" id="project_id" class="form-control select2-no-search" onchange="get_employee()">
                                        <option label="Choose Project"></option>
                                        @foreach($projects as $project)
                                            <option value="{{$project->id}}" @if($project_id == $project->id) selected @endif>{{$project->name}}</option>
                                        @endforeach
                                </select>
                            </div>
                            <div style="display:none;" class="col-md-3">
                                <select name="branch_id" id="branch_id" class="form-control select2-no-search" onchange="get_employee()">
                                        <option label="Choose Branch"></option>
                                        @foreach($branches as $branch)
                                            <option value="{{$branch->id}}" @if($branch_id == $branch->id) selected @endif>{{$branch->name}}</option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="from_date" class="form-control dtpicker" autocomplete="off" placeholder="From Date" value="@if($from_date != ""){{date($date_format,strtotime($from_date))}}@endif"/>
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="to_date" class="form-control dtpicker" autocomplete="off" placeholder="To Date" value="@if($from_date != ""){{date($date_format,strtotime($to_date))}}@endif"/>
                            </div>
                            <div class="col-md-3">
                                <input class="btn btn-main-primary" style="width:100px;" type="submit" value="Search"/>
                            </div>
                        </div>
                        <br> 
                        <div class="row">
                            <div style="display:none;" class="col-md-3">
                                <select id="employee_id" name="employee_id[]" class="form-control employee_multiple" multiple="multiple" required>
                                    <option label="Employee Name"></option>
                                    @foreach($employment_infos as $employment_info)
                                        <option value="{{$employment_info->employee_id}}" {{ (collect($employee_id)->contains($employment_info->employee_id)) ? 'selected':'' }}>{{$employment_info->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </form>

                </div>
                
            </div>
        </div>

    </div>
    
    <script>
        function get_employee() {
            var department_id = $('#department_id').val();
            var project_id = $('#project_id').val();
            var branch_id = $('#branch_id').val();

            var url = '/search-roster-employee/'+department_id;
            if(project_id != "") { url = url +'/'+ project_id;} else { url = url + '/0';}
            if(branch_id != "") { url = url +'/'+ branch_id;} else { url = url + '/0';}

            $.ajax({
                type:'GET',
                url:url,
                success:function(data) {
                    console.log(data)
                    $('#employee_id').html('');
                    $('#employee_id').append(data);
                }
            });
    }
    </script>

@endsection