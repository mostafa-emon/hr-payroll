@extends('layouts.master')

@section('content')

        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('/roles')}}" style="color:#6c757d; font-weight: bold">Roles</a></li>
                <li class="breadcrumb-item active"><a style="color:#6c757d;">Update</a></li>
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
                            <form action="{{ url('roles/update/'.$roles->id) }}" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Role Name:</label> 
                                        <input type="text" name="role_name" value="{{$roles->role_name}}" class="form-control" required/>
                                    </div>
                                    <div class="col-md-7">
                                    </div>
                                    <div class="col-md-2 text-right" style="margin-top:32px">
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
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="company_info" @if($roles->access != "" && in_array(1, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">2</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Department</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="department_read" @if($roles->access != "" && in_array(2, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="department_add" @if($roles->access != "" && in_array(3, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="department_update" @if($roles->access != "" && in_array(4, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="department_delete" @if($roles->access != "" && in_array(5, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">3</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Designation</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="designation_read" @if($roles->access != "" && in_array(6, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="designation_add" @if($roles->access != "" && in_array(7, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="designation_update" @if($roles->access != "" && in_array(8, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="designation_delete" @if($roles->access != "" && in_array(9, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">4</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Project</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="project_read" @if($roles->access != "" && in_array(10, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="project_add" @if($roles->access != "" && in_array(11, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="project_update" @if($roles->access != "" && in_array(12, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="project_delete" @if($roles->access != "" && in_array(13, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">5</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Branch</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="branch_read" @if($roles->access != "" && in_array(14, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="branch_add" @if($roles->access != "" && in_array(15, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="branch_update" @if($roles->access != "" && in_array(16, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="branch_delete" @if($roles->access != "" && in_array(17, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">6</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Currency</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="currency_read" @if($roles->access != "" && in_array(18, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="currency_add" @if($roles->access != "" && in_array(19, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="currency_update" @if($roles->access != "" && in_array(20, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="currency_delete" @if($roles->access != "" && in_array(21, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">7</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Employees</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="employee_read" @if($roles->access != "" && in_array(22, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="employee_add" @if($roles->access != "" && in_array(23, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="employee_update" @if($roles->access != "" && in_array(24, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="employee_delete" @if($roles->access != "" && in_array(25, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">8</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Roles</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="role_read" @if($roles->access != "" && in_array(26, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="role_add" @if($roles->access != "" && in_array(27, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="role_update" @if($roles->access != "" && in_array(28, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="role_delete" @if($roles->access != "" && in_array(29, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>
                                    
                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">9</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Users</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="user_read" @if($roles->access != "" && in_array(30, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="user_add" @if($roles->access != "" && in_array(31, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="user_update" @if($roles->access != "" && in_array(32, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="user_delete" @if($roles->access != "" && in_array(33, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">10</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Leave Type</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="leave_type_read" @if($roles->access != "" && in_array(34, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="leave_type_add" @if($roles->access != "" && in_array(35, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="leave_type_update" @if($roles->access != "" && in_array(36, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="leave_type_delete" @if($roles->access != "" && in_array(37, json_decode($roles->access,false)))checked="checked"@endif/></td>
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
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="employee_list_report" @if($roles->access != "" && in_array(38, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">12</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Inactive Employee List</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="inactive_employee_list_report" @if($roles->access != "" && in_array(39, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">13</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Employee CV Report</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="employee_cv_report" @if($roles->access != "" && in_array(50, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">14</td>
                                        <td style="border-bottom: 1px solid #ced4da;">General Settings</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="general_settings" @if($roles->access != "" && in_array(40, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">15</td>
                                        <td style="border-bottom: 1px solid #ced4da;">SMS Settings</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="sms_settings_read" @if($roles->access != "" && in_array(41, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="sms_settings_add" @if($roles->access != "" && in_array(42, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="sms_settings_update" @if($roles->access != "" && in_array(43, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="sms_settings_delete" @if($roles->access != "" && in_array(44, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">16</td>
                                        <td style="border-bottom: 1px solid #ced4da;">SMS Balance</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="sms_balance_read" @if($roles->access != "" && in_array(45, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="sms_balance_update" @if($roles->access != "" && in_array(46, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">17</td>
                                        <td style="border-bottom: 1px solid #ced4da;">SMTP Settings</td>

                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" class="checkbox" style="width: 20px; height: 20px; margin-top:5px;" value="1" name="smtp_settings_read" @if($roles->access != "" && in_array(47, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="smtp_settings_update" @if($roles->access != "" && in_array(48, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="smtp_settings_sent" @if($roles->access != "" && in_array(49, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">18</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Tax Rule Setup</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="tax_rule_setup" @if($roles->access != "" && in_array(51, json_decode($roles->access,false)))checked="checked"@endif/></td>
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

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="shift_read" @if($roles->access != "" && in_array(56, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="shift_add" @if($roles->access != "" && in_array(57, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="shift_update" @if($roles->access != "" && in_array(58, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="shift_delete" @if($roles->access != "" && in_array(59, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">2</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Govt Holiday</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="govt_holiday_read" @if($roles->access != "" && in_array(60, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="govt_holiday_add" @if($roles->access != "" && in_array(61, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="govt_holiday_update" @if($roles->access != "" && in_array(62, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="govt_holiday_delete" @if($roles->access != "" && in_array(63, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">3</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Attendance Policy</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="attendance_policy_update" @if($roles->access != "" && in_array(64, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">4</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Roster</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="roster_read" @if($roles->access != "" && in_array(65, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="roster_add" @if($roles->access != "" && in_array(66, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="roster_update" @if($roles->access != "" && in_array(67, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="roster_delete" @if($roles->access != "" && in_array(68, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">5</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Manual Log Entry</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="manual_log_entry_read" @if($roles->access != "" && in_array(69, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="manual_log_entry_add" @if($roles->access != "" && in_array(70, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="manual_log_entry_update" @if($roles->access != "" && in_array(71, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
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
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="daily_attendance_report" @if($roles->access != "" && in_array(73, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">7</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Attendance Summary All Report</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="attendance_summary_all_report" @if($roles->access != "" && in_array(74, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">8</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Attendance Summary Single Report</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="attendance_summary_single_report" @if($roles->access != "" && in_array(75, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">9</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Daily Late Report</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="daily_late_report" @if($roles->access != "" && in_array(76, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">10</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Late Report Individual</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="late_individual_report" @if($roles->access != "" && in_array(77, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">11</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Daily Absent Report</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="daily_absent_report" @if($roles->access != "" && in_array(78, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">12</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Absent Report Single</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="absent_single_report" @if($roles->access != "" && in_array(79, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">13</td>
                                        <td style="border-bottom: 1px solid #ced4da;">OT Summary Report</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="ot_summary_report" @if($roles->access != "" && in_array(80, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">14</td>
                                        <td style="border-bottom: 1px solid #ced4da;">OT Report Individual</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="ot_individual_report" @if($roles->access != "" && in_array(81, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                    </tr>
                                    @endif

                                    @if($company->payroll == 1)
                                    <tr>
                                        <th colspan="8" style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da;font-weight:bold;font-size:16px;">Payroll</th>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">1</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Salary Component</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="salary_component_read" @if($roles->access != "" && in_array(91, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="salary_component_add" @if($roles->access != "" && in_array(92, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="salary_component_update" @if($roles->access != "" && in_array(93, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="salary_component_delete" @if($roles->access != "" && in_array(94, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">2</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Salary Transfer Letter Format</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="salary_transfer_letter_format" @if($roles->access != "" && in_array(95, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">3</td>
                                        <td style="border-bottom: 1px solid #ced4da;">OT Transfer Letter Format</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="ot_transfer_letter_format" @if($roles->access != "" && in_array(96, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">4</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Payroll Bank</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="payroll_bank_read" @if($roles->access != "" && in_array(97, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="payroll_bank_add" @if($roles->access != "" && in_array(98, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="payroll_bank_update" @if($roles->access != "" && in_array(99, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="payroll_bank_delete" @if($roles->access != "" && in_array(100, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">5</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Create Earning Adjustment</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="create_earning_adjustment_read" @if($roles->access != "" && in_array(101, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="create_earning_adjustment_add" @if($roles->access != "" && in_array(102, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="create_earning_adjustment_update" @if($roles->access != "" && in_array(103, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="create_earning_adjustment_delete" @if($roles->access != "" && in_array(104, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="create_earning_adjustment_print" @if($roles->access != "" && in_array(105, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">6</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Create Deduction Adjustment</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="create_deduction_adjustment_read" @if($roles->access != "" && in_array(106, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="create_deduction_adjustment_add" @if($roles->access != "" && in_array(107, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="create_deduction_adjustment_update" @if($roles->access != "" && in_array(108, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="create_deduction_adjustment_delete" @if($roles->access != "" && in_array(109, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="create_deduction_adjustment_print" @if($roles->access != "" && in_array(110, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">7</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Absent Deduction</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="absent_deduction_read" @if($roles->access != "" && in_array(111, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="absent_deduction_add" @if($roles->access != "" && in_array(112, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="absent_deduction_update" @if($roles->access != "" && in_array(113, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="absent_deduction_delete" @if($roles->access != "" && in_array(114, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">8</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Create Salary Sheet</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="create_salary_sheet_read" @if($roles->access != "" && in_array(115, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="create_salary_sheet_add" @if($roles->access != "" && in_array(116, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="create_salary_sheet_send" @if($roles->access != "" && in_array(119, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="create_salary_sheet_print" @if($roles->access != "" && in_array(120, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">9</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Create Salary Transfer Letter</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="create_salary_transfer_letter_read" @if($roles->access != "" && in_array(121, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="create_salary_transfer_letter_add" @if($roles->access != "" && in_array(122, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="create_salary_transfer_letter_print" @if($roles->access != "" && in_array(159, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">10</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Create OT Transfer Letter</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="create_ot_transfer_letter_read" @if($roles->access != "" && in_array(123, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="create_ot_transfer_letter_add" @if($roles->access != "" && in_array(124, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="create_ot_transfer_letter_print" @if($roles->access != "" && in_array(160, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">11</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Create Company PF</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="create_company_pf_read" @if($roles->access != "" && in_array(125, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="create_company_pf_add" @if($roles->access != "" && in_array(126, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="create_company_pf_update" @if($roles->access != "" && in_array(127, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="create_company_pf_delete" @if($roles->access != "" && in_array(128, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">12</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Deposit Salary Tax</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="deposit_salary_tax_read" @if($roles->access != "" && in_array(129, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="deposit_salary_tax_add" @if($roles->access != "" && in_array(130, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="deposit_salary_tax_update" @if($roles->access != "" && in_array(131, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="deposit_salary_tax_print" @if($roles->access != "" && in_array(133, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">13</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Pay PF</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="pay_pf_read" @if($roles->access != "" && in_array(134, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="pay_pf_add" @if($roles->access != "" && in_array(135, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="pay_pf_print" @if($roles->access != "" && in_array(136, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">14</td>
                                        <td style="border-bottom: 1px solid #ced4da;">SMS Campaign</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="sms_campaign_read" @if($roles->access != "" && in_array(137, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="sms_campaign_add" @if($roles->access != "" && in_array(138, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="sms_campaign_update" @if($roles->access != "" && in_array(139, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="sms_campaign_delete" @if($roles->access != "" && in_array(140, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="sms_campaign_send" @if($roles->access != "" && in_array(141, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">15</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Gratuity</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="gratuity_read" @if($roles->access != "" && in_array(142, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="gratuity_add" @if($roles->access != "" && in_array(143, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="gratuity_update" @if($roles->access != "" && in_array(144, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="gratuity_delete" @if($roles->access != "" && in_array(145, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="gratuity_print" @if($roles->access != "" && in_array(146, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">16</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Earning Adjustment Report</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="earning_adjustment_report" @if($roles->access != "" && in_array(147, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">17</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Deduction Adjustment Report</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="deduction_adjustment_report" @if($roles->access != "" && in_array(148, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">18</td>
                                        <td style="border-bottom: 1px solid #ced4da;">108 Summary Report</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="108_summary_report" @if($roles->access != "" && in_array(157, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">19</td>
                                        <td style="border-bottom: 1px solid #ced4da;">PF Summary Report</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="pf_summary_report" @if($roles->access != "" && in_array(149, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">20</td>
                                        <td style="border-bottom: 1px solid #ced4da;">PF Detail Report</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="pf_detail_report" @if($roles->access != "" && in_array(150, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">21</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Salary Sheet Report</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="salary_sheet_report" @if($roles->access != "" && in_array(151, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">22</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Payslip Report</td>
                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="payslip_report" @if($roles->access != "" && in_array(152, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">23</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Email Payslip Report</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="email_payslip_report" @if($roles->access != "" && in_array(153, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">24</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Salary Transfer Letter Report</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="salary_transfer_letter_report" @if($roles->access != "" && in_array(154, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">25</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Salary Certificate Report</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="salary_certificate_report" @if($roles->access != "" && in_array(155, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">26</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Audit Trail Report</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="audit_trail_report" @if($roles->access != "" && in_array(156, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">27</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Post JV Quickbooks</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="post_jv_quickbooks" @if($roles->access != "" && in_array(158, json_decode($roles->access,false)))checked="checked"@endif/></td>
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

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="create_leave_request" @if($roles->access != "" && in_array(161, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">2</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Verify Leave Request</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="verify_leave_request" @if($roles->access != "" && in_array(162, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">3</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Approve Leave Request</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="approve_leave_request" @if($roles->access != "" && in_array(163, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">4</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Leave Balance Transfer</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="leave_balance_transfer" @if($roles->access != "" && in_array(164, json_decode($roles->access,false)))checked="checked"@endif/></td>
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
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="leave_individual_report" @if($roles->access != "" && in_array(165, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">6</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Rejected Leave Report</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="rejected_leave_report" @if($roles->access != "" && in_array(166, json_decode($roles->access,false)))checked="checked"@endif/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">7</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Leave Report All</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="leave_all_report" @if($roles->access != "" && in_array(167, json_decode($roles->access,false)))checked="checked"@endif/></td>
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

@endsection