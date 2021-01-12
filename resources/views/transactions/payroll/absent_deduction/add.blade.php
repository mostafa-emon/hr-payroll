@extends('layouts.master')

@section('content')

        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('/absent-deduction')}}" style="color:#6c757d; font-weight: bold">Absent Deduction</a></li>
                <li class="breadcrumb-item active"><a href="{{url('/absent-deduction/create')}}" style="color:#6c757d;">Create</a></li>
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
                            <h4 class="card-title mg-b-0">Create Absent Deduction</h4>
                        </div>
                        <div class="col-md-6 text-right">
                            @if(count($employee_id) > 0)
                                <a href="{{url('absent-deduction/create')}}" class="btn btn-info">Reset</a>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <form action="{{ url('absent-deduction/create') }}" method="POST">
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
                                <select id="employee_id" name="employee_id[]" class="form-control employee_multiple" multiple="multiple" required>
                                    <option label="Employee Name"></option>
                                    @foreach($employment_infos as $employment_info)
                                        <option value="{{$employment_info->employee_id}}" {{ (collect($employee_id)->contains($employment_info->employee_id)) ? 'selected':'' }}>{{$employment_info->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="month" class="form-control select2-no-search" required>
                                    <option label="Month"></option>
                                    <option value="January" @if($month == "January") selected @endif>January</option>
                                    <option value="February" @if($month == "February") selected @endif>February</option>
                                    <option value="March" @if($month == "March") selected @endif>March</option>
                                    <option value="April" @if($month == "April") selected @endif>April</option>
                                    <option value="May" @if($month == "May") selected @endif>May</option>
                                    <option value="June" @if($month == "June") selected @endif>June</option>
                                    <option value="July" @if($month == "July") selected @endif>July</option>
                                    <option value="August" @if($month == "August") selected @endif>August</option>
                                    <option value="September" @if($month == "September") selected @endif>September</option>
                                    <option value="October" @if($month == "October") selected @endif>October</option>
                                    <option value="November" @if($month == "November") selected @endif>November</option>
                                    <option value="December" @if($month == "December") selected @endif>December</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="year" class="form-control" placeholder="Year" value="{{$year}}" required/>
                            </div>
                        </div>
                        @if(count($employee_id) == 0)
                        <br>
                        <div class="row">
                            <div class="col-md-2 text-left">
                                <input class="btn btn-main-primary" style="width:100px;" type="submit" value="Search"/>
                            </div>
                        </div>
                        @endif
                    </form>

                    @if(count($employee_id) > 0)
                    <div class="card-body">
                        <div class="table-responsive">
                            <form method="post" action="{{url('store-absent-deduction')}}">
                                {{ csrf_field() }}

                                <input type="hidden" name="store_month" value="{{$month}}"/>
                                <input type="hidden" name="store_year" value="{{$year}}"/>

                                <table class="table table-striped table-bordered mg-b-0 text-md-nowrap">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width:5%;">SL</th>
                                            <th style="width:25%;">Employee Name</th>
                                            <th class="text-center" style="width:20%;">Employee ID</th>
                                            <th class="text-center" style="width:25%;">Total Absent Days</th>
                                            <th class="text-center" style="width:25%;">Total Deduction</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($employment_infos as $employment_info)
                                        @php $employee = get_employee_info($employment_info->id); @endphp
                                        <tr>
                                            <td style="vertical-align: middle" class="text-center">{{$loop->iteration}}</td>
                                            <td style="vertical-align: middle">{{$employee->name}}</td>
                                            <td style="vertical-align: middle" class="text-center">
                                                {{$employee->employee_id}}
                                                <input type="hidden" name="employee_id[]" class="form-control" value="{{$employee->id}}">
                                            </td>
                                            <td style="vertical-align: middle" class="text-center">
                                                <input type="text" id="total_absent_days_{{$employee->id}}" name="total_absent_days[]" class="form-control total_absent_days" value="{{total_absent_days($employee->id,$month,$year)}}" oninput="calculateTotalDeduction('{{$employee->id}}')" required/>
                                            </td>
                                            <td style="vertical-align: middle" class="text-center">
                                                <input type="hidden" id="per_day_salary_{{$employee->id}}" name="per_day_salary[]" class="form-control per_day_salary" value="{{per_day_salary($employee->id,$month,$year)}}"/>
                                                <input type="text" id="deduction_{{$employee->id}}" name="deduction[]" class="form-control deduction" value="{{total_absent_days($employee->id,$month,$year) * per_day_salary($employee->id,$month,$year)}}" readonly/>
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
                $('#employee_id').append(data);
            }
        });
    }

    function calculateTotalDeduction(employee_id) {
        var per_day_salary = $("#per_day_salary_"+employee_id).val();
        var total_absent_days = $("#total_absent_days_"+employee_id).val();
        var total = per_day_salary * total_absent_days;
        $("#deduction_"+employee_id).val(total);
    }

    </script>

@endsection