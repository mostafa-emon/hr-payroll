@extends('layouts.master')

@section('content')

        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{url('/attendance-summary-report-single')}}" style="color:#6c757d;">Attendance Summary Report Single</a></li>
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
                            <h4 class="card-title mg-b-0">Attendance Summary Report Single</h4>
                        </div>
                        <div class="col-md-6 text-right">
                            @if(count($employees) > 0)
                            <a href="{{url('attendance-summary-report-single')}}" class="btn btn-info">Reset</a>
                            <a href="{{ url($excel_link) }}" class="btn btn-success">Export</a>&nbsp;
                            <button class="btn btn-primary" onclick="printElem()">Print</button>
                            @endif
                        </div>
                    </div>
                    <hr>
                    @if(count($employees) == 0)
                    <form action="{{ url('attendance-summary-report-single') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-3">
                                <label for="Employee ID" style="font-weight:bold;" class="col-form-label">Employee ID:</label>
                                <input type="text" class="form-control" name="original_employee_id" placeholder="Employee ID" value="{{$original_employee_id}}"/>
                            </div>
                            <div class="col-md-3">
                                <label for="Department" style="font-weight:bold;" class="col-form-label">Department:</label>
                                <select name="department_id" id="department_id" class="form-control select2-no-search" onchange="get_employee()" @if(count($employees) > 0) disabled @endif>
                                        <option label="All"></option>
                                        @foreach($departments as $department)
                                            <option value="{{$department->id}}" @if($department_id == $department->id) selected @endif>{{$department->name}}</option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="Project" style="font-weight:bold;" class="col-form-label">Project:</label>
                                <select name="project_id" id="project_id" class="form-control select2-no-search" onchange="get_employee()" @if(count($employees) > 0) disabled @endif>
                                        <option label="All"></option>
                                        @foreach($projects as $project)
                                            <option value="{{$project->id}}" @if($project_id == $project->id) selected @endif>{{$project->name}}</option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="Branch" style="font-weight:bold;" class="col-form-label">Branch:</label>
                                <select name="branch_id" id="branch_id" class="form-control select2-no-search" onchange="get_employee()" @if(count($employees) > 0) disabled @endif>
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
                                <select name="designation_id" id="designation_id" class="form-control select2-no-search" onchange="get_employee()" @if(count($employees) > 0) disabled @endif>
                                        <option label="All"></option>
                                        @foreach($designations as $designation)
                                            <option value="{{$designation->id}}" @if($designation_id == $designation->id) selected @endif>{{$designation->name}}</option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="Employee" style="font-weight:bold;" class="col-form-label">Employee Name:</label>
                                <select id="employee_id" name="employee_id[]" class="form-control select2-no-search" @if(count($employees) > 0) disabled @endif>
                                    @foreach($select_employees as $employment_info)
                                        <option value="{{$employment_info->string_employee_id}}">{{$employment_info->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="Remark" style="font-weight:bold;" class="col-form-label">Status:</label>
                                <select name="remark" id="remark" class="form-control select2-no-search" @if(count($employees) > 0) disabled @endif>
                                        <option label="All"></option>
                                        <option value="Late" @if($remark == "Late") selected @endif>Late</option>
                                        <option value="OK" @if($remark == "OK") selected @endif>OK</option>
                                        <option value="Absent" @if($remark == "Absent") selected @endif>Absent</option>
                                        <option value="Leave" @if($remark == "Leave") selected @endif>Leave</option>
                                        <option value="Day Off" @if($remark == "Day Off") selected @endif>Day Off</option>
                                        <option value="Govt Holiday" @if($remark == "Govt Holiday") selected @endif>Govt Holiday</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="Remark" style="font-weight:bold;" class="col-form-label">From Date:</label>
                                <input type="text" class="form-control dtpicker" name="from_date" value="{{date('d-m-Y',strtotime($from_date))}}"placeholder="From Date" autocomplete="off" required>
                            </div>
                            <div class="col-md-2">
                                <label for="Remark" style="font-weight:bold;" class="col-form-label">To Date:</label>
                                <input type="text" class="form-control dtpicker" name="to_date" value="{{date('d-m-Y',strtotime($to_date))}}" placeholder="To Date" autocomplete="off" required>
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
                                @include('reports.exports.attendance_summary_list_single_table',$employees)

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
        function get_employee() {
            var department_id   = $('#department_id').val();
            var project_id      = $('#project_id').val();
            var branch_id       = $('#branch_id').val();
            var designation_id  = $('#designation_id').val();

            if(department_id == "") {department_id = 0;}
            if(project_id == "") {project_id = 0;}
            if(branch_id == "") {branch_id = 0;}
            if(designation_id == "") {designation_id = 0;}

            var url = '/search-employee-with-designation/'+department_id;
            if(project_id != "") { url = url +'/'+ project_id;} else { url = url + '/0';}
            if(branch_id != "") { url = url +'/'+ branch_id;} else { url = url + '/0';}
            if(designation_id != "") { url = url +'/'+ designation_id;} else { url = url + '/0';}

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