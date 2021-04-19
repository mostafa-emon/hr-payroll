@extends('layouts.master')

@section('content')

        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('/roles')}}" style="color:#6c757d; font-weight: bold">Roles</a></li>
                <li class="breadcrumb-item active"><a href="{{url('/roles/add')}}" style="color:#6c757d;">Add</a></li>
            </ol>
            </div>
        </div>

    <div class="row row-sm">

        <!--div-->
        <div class="col-xl-12">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ url('roles/add') }}" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Role Name:</label> 
                                        <input type="text" name="role_name" class="form-control" required/>
                                    </div>
                                    <div class="col-md-7">
                                    </div>
                                    <div class="col-md-2 text-right" style="margin-top:32px">
                                        <a class="btn btn-info btn-sm text-white" style="font-size: 15px;" onclick="checkAll()">Check All</a>
                                    </div>
                                </div>
                                <br>
                                <div class="table-responsive">
                                <table class="table table-bordered" cellspacing="1" cellpadding="1">
                                    <thead>
                                    <tr>
                                        <th rowspan="2" style="vertical-align: middle; border: 1px solid #ced4da; text-align:center;">SL NO</th>
                                        <th rowspan="2" style="vertical-align: middle; border-top:1px solid #ced4da; border-bottom:1px solid #ced4da;">FEATURES</th>
                                        <th colspan="6" style="text-align:center; border-left:1px solid #ced4da; border-top:1px solid #ced4da; border-bottom:1px solid #ced4da; border-right: 1px solid #ced4da;">PERMISSIONS</th>
                                    </tr>

                                    <tr>
                                        <th style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">Read</th>
                                        <th style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;">ADD</th>
                                        <th style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;">UPDATE</th>
                                        <th style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;">DELETE</th>
                                        <th style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">SEND SMS</th>
                                        <th style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">PRINT</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <tr>
                                        <th colspan="8" style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da;font-weight:bold;font-size:16px;">All Module</th>
                                    </tr>
                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">1</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Company</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="company_info"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">2</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Department</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="department_read"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="department_add"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="department_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="department_delete"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">3</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Designation</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="designation_read"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="designation_add"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="designation_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="designation_delete"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">4</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Project</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="project_read"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="project_add"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="project_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="project_delete"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">5</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Branch</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="branch_read"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="branch_add"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="branch_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="branch_delete"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">6</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Currency</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="currency_read"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="currency_add"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="currency_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="currency_delete"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">7</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Employees</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="employee_read"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="employee_add"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="employee_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="employee_delete"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">8</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Roles</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="role_read"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="role_add"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="role_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="role_delete"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>
                                    
                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">9</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Users</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="user_read"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="user_add"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="user_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="user_delete"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">10</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Leave Type</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="leave_type_read"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="leave_type_add"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="leave_type_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="leave_type_delete"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">11</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Employee List Report</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="employee_list_report"/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">12</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Inactive Employee List</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="inactive_employee_list_report"/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">13</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Employee CV Report</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="employee_cv_report"/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">14</td>
                                        <td style="border-bottom: 1px solid #ced4da;">General Settings</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="general_settings"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">15</td>
                                        <td style="border-bottom: 1px solid #ced4da;">SMS Settings</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="sms_settings_read"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="sms_settings_add"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="sms_settings_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="sms_settings_delete"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">16</td>
                                        <td style="border-bottom: 1px solid #ced4da;">SMS Balance</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="sms_balance"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">17</td>
                                        <td style="border-bottom: 1px solid #ced4da;">SMTP Settings</td>

                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" class="checkbox" style="width: 20px; height: 20px; margin-top:5px;" value="1" name="smtp_settings_read"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="smtp_settings_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="smtp_settings_sent"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">18</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Tax Rule Setup</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="tax_rule_setup"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    @if($company->attendance == 1)
                                    <tr>
                                        <th colspan="8" style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da;font-weight:bold;font-size:16px;">Attendance</th>
                                    </tr>
                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">1</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Shift</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="shift_read"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="shift_add"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="shift_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="shift_delete"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">2</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Govt Holiday</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="govt_holiday_read"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="govt_holiday_add"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="govt_holiday_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="govt_holiday_delete"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">3</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Attendance Policy</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="attendance_policy_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">4</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Roster</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="roster_read"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="roster_add"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="roster_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="roster_delete"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">5</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Manual Log Entry</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="manual_log_entry_read"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="manual_log_entry_add"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="manual_log_entry_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="manual_log_entry_delete"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">6</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Daily Attendance Report</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="daily_attendance_report"/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">7</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Attendance Summary All Report</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="attendance_summary_all_report"/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">8</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Attendance Summary Single Report</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="attendance_summary_single_report"/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">9</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Daily Late Report</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="daily_late_report"/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">10</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Late Report Individual</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="late_individual_report"/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">11</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Daily Absent Report</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="daily_absent_report"/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">12</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Absent Report Single</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="absent_single_report"/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">13</td>
                                        <td style="border-bottom: 1px solid #ced4da;">OT Summary Report</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="ot_summary_report"/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">14</td>
                                        <td style="border-bottom: 1px solid #ced4da;">OT Report Individual</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="ot_individual_report"/></td>
                                    </tr>
                                    @endif

                                    @if($company->payroll == 1)
                                    <tr>
                                        <th colspan="8" style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da;font-weight:bold;font-size:16px;">Payroll</th>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">1</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Salary Component</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="salary_component_read"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="salary_component_add"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="salary_component_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="salary_component_delete"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">2</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Salary Transfer Letter Format</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="salary_transfer_letter_format"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">3</td>
                                        <td style="border-bottom: 1px solid #ced4da;">OT Transfer Letter Format</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="ot_transfer_letter_format"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">4</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Payroll Bank</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="payroll_bank_read"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="payroll_bank_add"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="payroll_bank_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="payroll_bank_delete"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">5</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Create Earning Adjustment</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="create_earning_adjustment_read"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="create_earning_adjustment_add"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="create_earning_adjustment_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="create_earning_adjustment_delete"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="create_earning_adjustment_print"/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">6</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Create Deduction Adjustment</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="create_deduction_adjustment_read"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="create_deduction_adjustment_add"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="create_deduction_adjustment_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="create_deduction_adjustment_delete"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="create_deduction_adjustment_print"/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">7</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Absent Deduction</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="absent_deduction_read"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="absent_deduction_add"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="absent_deduction_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="absent_deduction_delete"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">8</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Create Salary Sheet</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="create_salary_sheet_read"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="create_salary_sheet_add"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="create_salary_sheet_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="create_salary_sheet_delete"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="create_salary_sheet_send"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="create_salary_sheet_print"/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">9</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Create Salary Transfer Letter</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="create_salary_transfer_letter_read"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="create_salary_transfer_letter_add"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">10</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Create OT Transfer Letter</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="create_ot_transfer_letter_read"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="create_ot_transfer_letter_add"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">11</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Create Company PF</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="create_company_pf_read"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="create_company_pf_add"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="create_company_pf_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="create_company_pf_delete"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">12</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Deposit Salary Tax</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="deposit_salary_tax_read"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="deposit_salary_tax_add"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="deposit_salary_tax_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="deposit_salary_tax_delete"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="deposit_salary_tax_print"/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">13</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Pay PF</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="pay_pf_read"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="pay_pf_add"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="pay_pf_print"/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">14</td>
                                        <td style="border-bottom: 1px solid #ced4da;">SMS Campaign</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="sms_campaign_read"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="sms_campaign_add"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="sms_campaign_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="sms_campaign_delete"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="sms_campaign_send"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">15</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Gratuity</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="gratuity_read"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="gratuity_add"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="gratuity_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="gratuity_delete"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="gratuity_print"/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">16</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Earning Adjustment Report</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="earning_adjustment_report"/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">17</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Deduction Adjustment Report</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="deduction_adjustment_report"/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">18</td>
                                        <td style="border-bottom: 1px solid #ced4da;">108 Summary Report</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="108_summary_report"/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">19</td>
                                        <td style="border-bottom: 1px solid #ced4da;">PF Summary Report</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="pf_summary_report"/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">20</td>
                                        <td style="border-bottom: 1px solid #ced4da;">PF Detail Report</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="pf_detail_report"/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">21</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Salary Sheet Report</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="salary_sheet_report"/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">22</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Payslip Report</td>
                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="payslip_report"/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">23</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Email Payslip Report</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="email_payslip_report"/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">24</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Salary Transfer Letter Report</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="salary_transfer_letter_report"/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">25</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Salary Certificate Report</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="salary_certificate_report"/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">26</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Audit Trail Report</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="audit_trail_report"/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">27</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Post JV Quickbooks</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="post_jv_quickbooks"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>
                                    @endif

                                    @if($company->leave == 1)
                                    <tr>
                                        <th colspan="8" style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da;font-weight:bold;font-size:16px;">Leave</th>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">1</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Create Leave Request</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="create_leave_request"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">2</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Verify Leave Request</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="verify_leave_request"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">3</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Approve Leave Request</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="approve_leave_request"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">4</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Leave Balance Transfer</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="leave_balance_transfer"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">5</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Leave Report Individual</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="leave_individual_report"/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">6</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Rejected Leave Report</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="rejected_leave_report"/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">7</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Leave Report All</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="leave_all_report"/></td>
                                    </tr>
                                    @endif
                                    </tbody>
                                </table>

                                <br>

                                <div style="margin-bottom:5px;" class="row">
                                    <div class="col-md-12 text-center">
                                    <input type="submit" value="Submit" class="btn btn-primary wd-100 pointer"/>
                                    </div>
                                </div>
                                <br>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>

        function checkAll(){
        $('.checkbox').attr("checked","checked");
        }

    </script>

@endsection