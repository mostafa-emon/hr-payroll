@extends('layouts.master')

@section('content')

        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{url('/verify-leave-request')}}" style="color:#6c757d;">Verify Leave Request</a></li>
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
                    
                    <div class="row">
                        <div class="col-md-6" style="padding-top:5px">
                            <h4 class="card-title mg-b-0">Verify Leave Request</h4>
                        </div>
                    </div>
                </div>

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

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mg-b-0 text-md-nowrap">
                            <thead>
                                <tr>
                                    <th class="text-center" style="vertical-align: middle;width:5%;">SL</th>
                                    <th style="vertical-align: middle;width:20%;">Employee Name</th>
                                    <th style="vertical-align: middle;width:10%;">Department</th>
                                    <th style="vertical-align: middle;width:10%;">Designation</th>
                                    <th style="vertical-align: middle;width:15%;">Leave Type</th>
                                    <th class="text-center" style="vertical-align: middle;width:10%;">From</th>
                                    <th class="text-center" style="vertical-align: middle;width:10%;">To</th>
                                    <th class="text-center" style="vertical-align: middle;width:10%;">Number of Days</th>
                                    <th class="text-center" style="vertical-align: middle;width:10%;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($leaves as $leave)
                                @php $employee = get_employee_info($leave->employee_id); @endphp
                                <tr>
                                    <td class="text-center" style="vertical-align: middle">{{(($leaves->currentPage() * 10) - 10) + $loop->iteration}}</td>
                                    <td style="vertical-align: middle">{{$employee->name}}</td>
                                    <td style="vertical-align: middle">{{employee_department($employee->id)}}</td>
                                    <td style="vertical-align: middle">{{employee_designation($employee->id)}}</td>
                                    <td style="vertical-align: middle">{{leave_type_name($leave->leave_type_id)}}</td>
                                    <td class="text-center" style="vertical-align: middle">{{date($date_format,strtotime($leave->start_date))}}</td>
                                    <td class="text-center" style="vertical-align: middle">{{date($date_format,strtotime($leave->end_date))}}</td>
                                    <td class="text-center" style="vertical-align: middle">{{$leave->leave_days}}</td>
                                    <td class="text-center" style="vertical-align: middle">
                                        <button data-toggle="dropdown" class="btn btn-success btn-sm">Action <i class="icon ion-ios-arrow-down tx-11 mg-l-3"></i></button>
                                        <div class="dropdown-menu">
                                            <a href="{{'leave-request/update/verify/'.$leave->id}}" class="dropdown-item">Edit</a>
                                            <a href="{{'leave-request/verify/'.$leave->id}}" class="dropdown-item">Verify</a>
                                            <a href="{{'leave-request/reject/'.$leave->id.'/verify'}}" class="dropdown-item">Reject</a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mg-t-15">
                        {{ $leaves->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection