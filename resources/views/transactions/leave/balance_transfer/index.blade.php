@extends('layouts.master')

@section('content')

        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{url('/leave-balance-transfer')}}" style="color:#6c757d;">Leave Balance Transfer</a></li>
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
                            <h4 class="card-title mg-b-0">Leave Balance Transfer</h4>
                        </div>
                        <div class="col-md-6 text-right"></div>
                    </div>
                    <hr>
                    <form action="{{ url('leave-balance-transfer') }}" method="POST">
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
                                    <option value="All" @if($all_employee !='') selected @endif>All</option>
                                    @foreach($employment_infos as $employment_info)
                                        <option value="{{$employment_info->employee_id}}" @if($all_employee =='') {{ (collect($employee_id)->contains($employment_info->employee_id)) ? 'selected':'' }} @endif>{{$employment_info->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control" name="applicable_for" placeholder="Applicable For" value="@if($applicable_for != ""){{$applicable_for}}@else{{date('Y')}}@endif" required>
                            </div>
                            <div class="col-md-2">
                                <input class="btn btn-main-primary" style="width:100px;" type="submit" value="Search"/>
                            </div>
                        </div>
                    </form>
                </div>

                @if(count($leave_infos) > 0)
                <div class="card-body">
                    <div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="card">
								<div class="card-body">
                                    <form method="POST" action="{{url('transfer-leave-balance/'.$employee->id)}}">
                                        {{ csrf_field() }}

                                            <div>
                                                <div class="row pd-t-10">
                                                    <div class="col-form-label col-md-2 remove-space" style="font-weight:bold;">Applicable For:</div>
                                                    <div class="col-md-4 remove-space">
                                                        <input type="text" class="form-control" placeholder="Applicable For" value={{date($applicable_for)}}>
                                                    </div>
                                                    <div class="col-form-label col-md-2 remove-space" style="font-weight:bold;">Applicable Year:</div>
                                                    <div class="col-md-4 remove-space">
                                                        <input type="text" class="form-control" name="applicable_year" placeholder="Applicable Year" value={{date($applicable_for + 1)}}>
                                                    </div>
                                                </div>

                                                <br>

                                                <table class="table table-striped table-bordered mg-b-0 text-md-nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th style="vertical-align: middle" class="text-center">Employee ID</th>
                                                            <th style="vertical-align: middle">Employee Name</th>
                                                            <th style="vertical-align: middle">Designation</th>
                                                            <th style="vertical-align: middle" class="text-center">Leave Type</th>
                                                            <th style="vertical-align: middle" class="text-center">Remaining Balance</th>
                                                            <th style="vertical-align: middle" class="text-center">To Be Forwarded</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($leave_infos as $leave_info)
                                                        @php $employee = get_employee_info($leave_info->employee_id); @endphp
                                                        <tr>
                                                            <td style="vertical-align: middle" class="text-center">
                                                                {{$employee->employee_id}}
                                                                <input type="hidden" name="employee_id[]" class="form-control" value="{{$employee->id}}">
                                                            </td>
                                                            <td style="vertical-align: middle">{{$employee->name}}</td>
                                                            <td style="vertical-align: middle">{{employee_designation($employee->id)}}</td>
                                                            <td style="vertical-align: middle" class="text-center">
                                                                {{leave_type_name($leave_info->leave_type_id)}}
                                                                <input type="hidden" name="leave_type_id[]" class="form-control" value="{{$leave_info->leave_type_id}}">
                                                            </td>
                                                            <td style="vertical-align: middle">
                                                                <input type="text" class="form-control" placeholder="Balance Left" value="{{leave_balance_left($leave_info->id,$employee->id,$applicable_for)}}" readonly>
                                                            </td>
                                                            <td style="vertical-align: middle">
                                                                <input type="number" min="0" class="form-control" name="transfer_amount[]" placeholder="Transfer Amount" max="@if($leave_info->max_carry_forward < leave_balance_left($leave_info->id,$employee->id,$applicable_for)){{$leave_info->max_carry_forward}}@else{{leave_balance_left($leave_info->id,$employee->id,$applicable_for)}}@endif" value="@if($leave_info->max_carry_forward < leave_balance_left($leave_info->id,$employee->id,$applicable_for)){{$leave_info->max_carry_forward}}@else{{leave_balance_left($leave_info->id,$employee->id,$applicable_for)}}@endif">
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                        <div class="row pd-t-30">
                                            <div class="col-md-12 text-center">
                                                <input class="btn btn-main-primary" style="width:100px;" type="submit" value="Submit"/>
                                            </div>
                                        </div>
                                    </form>
								</div>
							</div>
						</div>
					</div>
                </div>
                @endif
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
                    $('#employee_id').append('<option value="" selected>Employee Name</option>');
                    $('#employee_id').append('<option value="All">All</option>');
                    $('#employee_id').append(data);
                }
            });
    }
    </script>

@endsection