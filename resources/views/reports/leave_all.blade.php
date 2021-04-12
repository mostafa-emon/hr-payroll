@extends('layouts.master')

@section('content')

        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{url('/leave-report-all')}}" style="color:#6c757d;">Leave Report All</a></li>
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
                            <h4 class="card-title mg-b-0">Leave Report All</h4>
                        </div>
                        <div class="col-md-6 text-right">
                            @if(count($employees) > 0)
                            <a href="{{url('leave-report-all')}}" class="btn btn-info">Reset</a>
                            <a href="{{ url($excel_link) }}" class="btn btn-success">Export</a>&nbsp;
                            <button class="btn btn-primary" onclick="printElem()">Print</button>
                            @endif
                        </div>
                    </div>
                    <hr>
                    @if(count($employees) == 0)
                    <form action="{{ url('leave-report-all') }}" method="POST">
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
                            <div class="col-md-3" style="display:none;">
                                <input type="text" class="form-control" name="job" value="1"/>
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
                            <div class="col-md-3">
                                <label for="Designation" style="font-weight:bold;" class="col-form-label">Designation:</label>
                                <select name="designation_id" id="designation_id" class="form-control select2-no-search" @if(count($employees) > 0) disabled @endif>
                                        <option label="All"></option>
                                        @foreach($designations as $designation)
                                            <option value="{{$designation->id}}" @if($designation_id == $designation->id) selected @endif>{{$designation->name}}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="Gender" style="font-weight:bold;" class="col-form-label">Sex:</label>
                                <select class="form-control select2-no-search" name="gender">
                                    <option value="" label>All</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Others">Others</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="Duty Type" style="font-weight:bold;" class="col-form-label">Duty Type:</label>
                                <select class="form-control select2-no-search" name="duty_type">
                                    <option value="" label>All</option>
                                    <option value="Roster">Roster</option>
                                    <option value="Non-Roster">Non-Roster</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="Remark" style="font-weight:bold;" class="col-form-label">From Date:</label>
                                <input type="text" class="form-control dtpicker" name="from_date" value="{{date($date_format,strtotime($from_date))}}"placeholder="From Date" autocomplete="off" required>
                            </div>
                            <div class="col-md-3">
                                <label for="Remark" style="font-weight:bold;" class="col-form-label">To Date:</label>
                                <input type="text" class="form-control dtpicker" name="to_date" value="{{date($date_format,strtotime($to_date))}}" placeholder="To Date" autocomplete="off" required>
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
                                @include('reports.exports.leave_list_all_table',$employees)

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