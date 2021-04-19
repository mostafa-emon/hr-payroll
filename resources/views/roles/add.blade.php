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
                                        <th colspan="7" style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da;">Master Setup</td>
                                    </tr>
                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">1</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Events</td>

                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" class="checkbox" style="width: 20px; height: 20px; margin-top:5px;" value="1" name="event_add"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="event_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="event_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="event_delete"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">2</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Halls</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="hall_add"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="hall_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="event_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="hall_delete"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">3</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Exhibitor Category</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="exhibitor_category_add"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="exhibitor_category_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="event_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="exhibitor_category_delete"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">4</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Membership Type</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="membership_type_add"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="membership_type_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="membership_type_delete"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="event_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">5</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Exhibitors</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="exhibitor_add"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="exhibitor_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="exhibitor_delete"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="event_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">6</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Visitors</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="visitor_add"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="visitor_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="event_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="visitor_delete"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">7</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Roles</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="roles_add"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="roles_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="roles_delete"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="event_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>
                                    
                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">8</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Users</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="user_add"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="user_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="user_delete"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="event_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <th colspan="7" style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da;">Website Setup</td>
                                    </tr>
                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">1</td>
                                        <td style="border-bottom: 1px solid #ced4da;">About Us</td>

                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="about_us"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="event_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">2</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Contact Us</td>

                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="contact_us"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="event_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">3</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Why Online Fair</td>

                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="why_online_fair"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="event_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">4</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Social Networks</td>

                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="social_network"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="event_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">5</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Homepage Video</td>

                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="homepage_video"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="event_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">6</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Youtube Video</td>

                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="youtube_video"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="event_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">7</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Hall Background</td>

                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="hall_background"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="event_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">8</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Homepage Scroll</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="partner_add"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="partner_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="partner_delete"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="event_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">9</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Event Scroll</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="event_scroll_add"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="event_scroll_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="event_scroll_delete"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="event_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">10</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Media Partner (Stall)</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="media_stall_add"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="media_stall_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="media_stall_delete"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="event_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">11</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Hit Counter</td>

                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="hit_counter"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="event_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">12</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Payment Instruction</td>

                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="payment_instruction"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="event_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <th colspan="9" style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da;">Activities</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">1</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Shop Allotment</td>

                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="shop_allotment"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="event_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">2</td>
                                        <td style="border-bottom: 1px solid #ced4da;">SMS Campaign</td>

                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="sms_campaign_add"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="sms_campaign_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="sms_campaign_delete"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="sms_campaign_send"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="event_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">3</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Notification</td>

                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="notification_add"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="notification_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="event_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="notification_delete"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">4</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Inquiry</td>

                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="inquiry"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="event_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <th colspan="9" style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da;">Reports</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">1</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Exhibitor List</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="exhibitor_list"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="event_update"/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">2</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Visitor List</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="visitor_list"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="event_update"/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">3</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Event List</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="event_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="event_list"/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">4</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Meeting Request Report</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="event_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="meeting_request"/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">5</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Shop Visit Report</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="event_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="shop_visit_list"/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">6</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Voice Chat Request</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="event_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="voice_chat_request"/></td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">7</td>
                                        <td style="border-bottom: 1px solid #ced4da;">Text Message Report</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="event_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="text_message"/></td>
                                    </tr>

                                    <tr>
                                        <th colspan="9" style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da;">Configuration</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">1</td>
                                        <td style="border-bottom: 1px solid #ced4da;">SMS Settings</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="sms_settings_add"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="sms_settings_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="event_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="sms_settings_delete"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

                                    <tr>
                                        <td style="border-right: 1px solid #ced4da; border-left: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center">2</td>
                                        <td style="border-bottom: 1px solid #ced4da;">SMS Balance</td>

                                        <td style="border-left: 1px solid #ced4da; border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="sms_balance"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;"><input type="checkbox" style="width: 20px; height: 20px; margin-top:5px;" class="checkbox" value="1" name="event_update"/></td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                        <td style="border-right: 1px solid #ced4da; border-bottom: 1px solid #ced4da; text-align:center;vertical-align:middle;">N/A</td>
                                    </tr>

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