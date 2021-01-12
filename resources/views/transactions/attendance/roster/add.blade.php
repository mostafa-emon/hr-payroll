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
                            <h4 class="card-title mg-b-0">Create Roster</h4>
                        </div>
                        <div class="col-md-6 text-right">
                            @if(count($employee_id) > 0)
                            <a href="{{url('create-roster')}}" class="btn btn-info">Reset</a>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <form action="{{ url('create-roster') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-3">
                                <input type="text" name="roster_name" class="form-control" placeholder="Roster Name" value="{{$roster_name}}" @if($department_id != "") readonly @endif/>
                            </div>
                            <div class="col-md-3">
                                <select name="department_id" id="department_id" class="form-control select2-no-search" onchange="get_employee()" required @if($department_id != "") disabled @endif>
                                        <option label="Department"></option>
                                        @foreach($departments as $department)
                                            <option value="{{$department->id}}" @if($department_id == $department->id) selected @endif>{{$department->name}}</option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="project_id" id="project_id" class="form-control select2-no-search" onchange="get_employee()" @if($department_id != "") disabled @endif>
                                        <option label="Choose Project"></option>
                                        @foreach($projects as $project)
                                            <option value="{{$project->id}}" @if($project_id == $project->id) selected @endif>{{$project->name}}</option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="branch_id" id="branch_id" class="form-control select2-no-search" onchange="get_employee()" @if($department_id != "") disabled @endif>
                                        <option label="Choose Branch"></option>
                                        @foreach($branches as $branch)
                                            <option value="{{$branch->id}}" @if($branch_id == $branch->id) selected @endif>{{$branch->name}}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-3">
                                <select id="employee_id" name="employee_id[]" class="form-control employee_multiple" multiple="multiple" required @if($department_id != "") disabled @endif>
                                    <option label="Employee Name"></option>
                                    @foreach($employment_infos as $employment_info)
                                        <option value="{{$employment_info->employee_id}}" {{ (collect($employee_id)->contains($employment_info->employee_id)) ? 'selected':'' }}>{{$employment_info->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="from_date" class="form-control dtpicker" autocomplete="off" placeholder="from date" value="@if($from_date != ""){{date('d-m-Y',strtotime($from_date))}}@endif" @if($department_id != "") readonly @endif/>
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="to_date" class="form-control dtpicker" autocomplete="off" placeholder="to date" value="@if($from_date != ""){{date('d-m-Y',strtotime($to_date))}}@endif" @if($department_id != "") readonly @endif/>
                            </div>
                            @if($department_id == "")
                                <div class="col-md-3 text-left">
                                    <input class="btn btn-main-primary" style="width:100px;" type="submit" value="Search"/>
                                </div>
                            @endif
                        </div>
                    </form>

                    @if(count($employee_id) > 0)
                        @php
                            $store_employee_id = "";
                            foreach($employee_id as $row) {
                                $store_employee_id = $store_employee_id.$row.',';
                            }
                        @endphp
                        <br>
                        @php 
                            $formatted_from_date = new DateTime($from_date);
                            $formatted_to_date   = new DateTime($to_date);
                            $interval = $formatted_to_date->diff($formatted_from_date);
                            $interval = $interval->format('%a');
                        @endphp
                         <div class="table-responsive">
                            <form method="post" action="{{url('store-roster')}}">
                                {{ csrf_field() }}
                                <input type="hidden" name="roster_id" value="{{$roster_id}}"/>
                                <input type="hidden" name="store_from_date" value="{{date('Y-m-d',strtotime($from_date))}}"/>
                                <input type="hidden" name="store_to_date" value="{{date('Y-m-d',strtotime($to_date))}}"/>
                                <input type="hidden" name="store_employee_id" value="{{rtrim($store_employee_id, ',')}}"/>

                                <table class="table table-striped table-bordered mg-b-0 text-md-nowrap">
                                    <tr>
                                        <th class="text-center" style="width:33%">Date</th>
                                        <th class="text-center" style="width:33%">Shift</th>
                                        <th class="text-center" style="width:34%">Day Off</th>
                                    </tr>
                                    @for($i = 0; $i <= $interval; $i++)
                                        <tr>
                                            <td class="text-center">
                                                @php $holiday = find_holiday(date('Y-m-d',strtotime($from_date . "+".$i." days"))); @endphp
                                                <input type="text" class="form-control" style="@if($holiday !="")font-weight:bold;font-size:16px;@endif" name="date_{{$i}}" value="{{date('d-m-Y',strtotime($from_date . "+".$i." days"))}}" readonly/>
                                            </td>
                                            
                                            <td class="text-center">
                                                <select class="form-control" name="shift_id_{{$i}}">
                                                    @foreach($shifts as $shift)
                                                        <option value="{{$shift->id}}">{{$shift->name}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            
                                            <td class="text-center">
                                                <input type="checkbox" style="cursor:pointer; width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="day_off_{{$i}}"/>
                                            </td>
                                        </tr>
                                    @endfor
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
    </script>

@endsection