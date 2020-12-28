@extends('layouts.master')

@section('content')

        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('/company-pf')}}" style="color:#6c757d; font-weight: bold">Company PF</a></li>
                <li class="breadcrumb-item active"><a href="{{url('/company-pf-create')}}" style="color:#6c757d;">Create</a></li>
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
                            <h4 class="card-title mg-b-0">Create Company PF</h4>
                        </div>
                        <div class="col-md-6 text-right">
                        </div>
                    </div>
                    <hr>
                    <form action="{{ url('company-pf-create') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-4">
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
                            <div class="col-md-4">
                                <input type="text" name="year" class="form-control" placeholder="Year; Ex:2010" value="{{$year}}" required/>
                            </div>
                            <div class="col-md-4">
                                <select name="department_id" id="department_id" class="form-control select2-no-search">
                                    <option label="Department"></option>
                                    @foreach($departments as $department)
                                        <option value="{{$department->id}}" @if($department_id == $department->id) selected @endif>{{$department->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-4">
                                <select name="project_id" id="project_id" class="form-control select2-no-search">
                                    <option label="Choose Project"></option>
                                    @foreach($projects as $project)
                                        <option value="{{$project->id}}" @if($project_id == $project->id) selected @endif>{{$project->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select name="branch_id" id="branch_id" class="form-control select2-no-search">
                                    <option label="Choose Branch"></option>
                                    @foreach($branches as $branch)
                                        <option value="{{$branch->id}}" @if($branch_id == $branch->id) selected @endif>{{$branch->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select name="currency_id" id="currency_id" class="form-control select2-no-search" required>
                                    @foreach($currencies as $currency)
                                        <option value="{{$currency->id}}" @if($currency_id == $currency->id) selected @endif>{{$currency->currency_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-3 text-left">
                                <input class="btn btn-main-primary" style="width:100px;" type="submit" value="Search"/>
                            </div>
                        </div>
                    </form>

                    @if($month !='')
                        <br>
                        <div class="table-responsive">
                            <form method="post" action="{{url('store-company-pf')}}">
                                {{ csrf_field() }}
                                <input type="text" name="store_month" value="{{$month}}"/>
                                <input type="text" name="store_year" value="{{$year}}"/>
                                <input type="text" name="store_currency_id" value="{{$currency_id}}"/>

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
                                        @foreach($employment_infos as $employee)
                                        <tr>
                                            <td class="text-center" style="vertical-align: middle">{{$loop->iteration}}</td>
                                            <td style="vertical-align: middle">{{$employee->name}}</td>
                                            <td class="text-center" style="vertical-align: middle">{{$employee->employee_id}}</td>
                                            <td class="text-center" style="vertical-align: middle">{{department_name($employee->department_id)}}</td>
                                            <td class="text-center" style="vertical-align: middle">{{designation_name($employee->designation_id)}}</td>
                                            <td style="vertical-align: middle">
                                                <input type="text" name="employee_id[]" class="form-control" value="{{get_auto_increment_employee_id($employee->employee_id)}}">
                                                <input type="text" name="pf_amount[]" class="form-control" placeholder="PF Amount" value="{{get_pf_amount($employee->employee_id)}}">
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

@endsection