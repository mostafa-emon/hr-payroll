@extends('layouts.master')

@section('content')

        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{url('/leave-request')}}" style="color:#6c757d;">Create Leave Request</a></li>
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
                            <h4 class="card-title mg-b-0">Create Leave Request</h4>
                        </div>
                        <div class="col-md-6 text-right">
                            <a style="font-size: 15px;" class="btn btn-primary btn-sm" href="{{url('leave-request/add')}}"><i class="fa fa-plus-circle"></i> &nbsp;Create</a>
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
                        $date_format = 'd-M-y';
                    }
                @endphp

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mg-b-0 text-md-nowrap">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width:5%;">SL</th>
                                    <th style="width:25%;">Leave Type</th>
                                    <th class="text-center" style="width:15%;">From</th>
                                    <th class="text-center" style="width:15%;">To</th>
                                    <th class="text-center" style="width:15%;">Number of Days</th>
                                    <th class="text-center" style="width:15%;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($leaves as $leave)
                                <tr>
                                    <td class="text-center" style="vertical-align: middle">{{(($leaves->currentPage() * 10) - 10) + $loop->iteration}}</td>
                                    <td style="vertical-align: middle">{{leave_type_name($leave->leave_type_id)}}</td>
                                    <td class="text-center" style="vertical-align: middle">{{date($date_format,strtotime($leave->start_date))}}</td>
                                    <td class="text-center" style="vertical-align: middle">{{date($date_format,strtotime($leave->end_date))}}</td>
                                    <td class="text-center" style="vertical-align: middle">{{$leave->leave_days}}</td>
                                    <td class="text-center" style="vertical-align: middle">
                                        @if($leave->status == "Verified") <span class="badge badge-success">Verified</span>
                                        @elseif($leave->status == "Approved") <span class="badge badge-info">Approved</span>
                                        @elseif($leave->status == "Rejected") <span class="badge badge-danger">Rejected</span>
                                        @else <span class="badge badge-warning">Unapproved</span>
                                        @endif
                                    </td>
                                    {{--<td class="text-center" style="vertical-align: middle">
                                        <button data-toggle="dropdown" class="btn btn-success btn-sm">Action <i class="icon ion-ios-arrow-down tx-11 mg-l-3"></i></button>
                                        <div class="dropdown-menu">
                                            <a href="{{'leave-request/update/'.$leave->id}}" class="dropdown-item">Update</a>
                                            <a href="javascript:void(0)" class="dropdown-item" onclick="confirmDelete({{$leave->id}})">Delete</a>
                                        </div>
                                    </td>--}}
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
    
    <script>

        function confirmDelete(id) {
            var r = confirm("Are you confirm to delete?");
            if (r == true) {
            window.location = "/leave-request/delete/"+id;
            }
        }

    </script>

@endsection