@extends('layouts.master')

@section('content')

        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{url('/employee-list-report')}}" style="color:#6c757d;">Employee List</a></li>
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
                            <h4 class="card-title mg-b-0">Employee List</h4>
                        </div>
                        <div class="col-md-6 text-right">
                            @if(count($employees) > 0)
                            <a href="{{url('employee-list-report')}}" class="btn btn-info">Reset</a>
                            <a href="{{ url($excel_link) }}" class="btn btn-success">Export</a>&nbsp;
                            <button class="btn btn-primary" onclick="printElem()">Print</button>
                            @endif
                        </div>
                    </div>
                    <hr>
                    @if(count($employees) == 0)
                    <form action="{{ url('employee-list-report') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-3" style="display:none;">
                                <input type="text" class="form-control" name="job" value="1"/>
                            </div>
                            <div class="col-md-3">
                                <label for="Employee ID" style="font-weight:bold;" class="col-form-label">Employee ID:</label>
                                <input type="text" class="form-control" name="original_employee_id" placeholder="Employee ID" value="{{$original_employee_id}}"/>
                            </div>
                            <div class="col-md-3">
                                <label for="Department" style="font-weight:bold;" class="col-form-label">Department:</label>
                                <select name="department_id" id="department_id" class="form-control select2-no-search" @if(count($employees) > 0) disabled @endif>
                                        <option label="All"></option>
                                        @foreach($departments as $department)
                                            <option value="{{$department->id}}" @if($department_id == $department->id) selected @endif>{{$department->name}}</option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="Project" style="font-weight:bold;" class="col-form-label">Project:</label>
                                <select name="project_id" id="project_id" class="form-control select2-no-search" @if(count($employees) > 0) disabled @endif>
                                        <option label="All"></option>
                                        @foreach($projects as $project)
                                            <option value="{{$project->id}}" @if($project_id == $project->id) selected @endif>{{$project->name}}</option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="Branch" style="font-weight:bold;" class="col-form-label">Branch:</label>
                                <select name="branch_id" id="branch_id" class="form-control select2-no-search" @if(count($employees) > 0) disabled @endif>
                                        <option label="All"></option>
                                        @foreach($branches as $branch)
                                            <option value="{{$branch->id}}" @if($branch_id == $branch->id) selected @endif>{{$branch->name}}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="Designation" style="font-weight:bold;" class="col-form-label">Designation:</label>
                                <select name="designation_id" id="designation_id" class="form-control select2-no-search" @if(count($employees) > 0) disabled @endif>
                                        <option label="All"></option>
                                        @foreach($designations as $designation)
                                            <option value="{{$designation->id}}" @if($designation_id == $designation->id) selected @endif>{{$designation->name}}</option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="Religion" style="font-weight:bold;" class="col-form-label">Religion:</label>
                                <select class="form-control select2-no-search" name="religion">
                                    <option value="" label>All</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Christianity">Christianity</option>
                                    <option value="Hinduism">Hinduism</option>
                                    <option value="Buddhism">Buddhism</option>
                                    <option value="Others">Others</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="Gender" style="font-weight:bold;" class="col-form-label">Sex:</label>
                                <select class="form-control select2-no-search" name="gender">
                                    <option value="" label>All</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Others">Others</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="Blood Group" style="font-weight:bold;" class="col-form-label">Blood Group:</label>
                                <select class="form-control select2-no-search" name="blood_group">
                                    <option value="" label>All</option>
                                    <option value="A+">A+</option>
                                    <option value="A-">A-</option>
                                    <option value="B+">B+</option>
                                    <option value="B-">B-</option>
                                    <option value="O+">O+</option>
                                    <option value="O-">O-</option>
                                    <option value="AB+">AB+</option>
                                    <option value="AB-">AB-</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="Duty Type" style="font-weight:bold;" class="col-form-label">Duty Type:</label>
                                <select class="form-control select2-no-search" name="duty_type">
                                    <option value="" label>All</option>
                                    <option value="Roster">Roster</option>
                                    <option value="Non-Roster">Non-Roster</option>
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
                    @endif

                    @if(count($employees) > 0)
                        <div class="card-body" id="printArea">
                            <div class="div-padding-30">
                                @include('reports.exports.employee_list_table',$employees)

                                <div class="table-responsive">
                                    <table style="width:100%;">
                                        <tr>
                                        <td colspan="1" style="padding-top:75px;padding-bottom:15px;border:none;">
                                            <div style="text-align:center;">__________________<br>Prepared By</div>
                                        </td>
                                        <td colspan="2" style="padding-top:75px;padding-bottom:15px;border:none;">
                                            <div style="text-align:center;">__________________<br>Checked By</div>
                                        </td>
                                        <td colspan="1" style="padding-top:75px;padding-bottom:15px;border:none;">
                                            <div style="text-align:center;">__________________<br>Approved By</div>
                                        </td>
                                        </tr>
                                    </table>
                                </div>

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