@extends('layouts.master')

@section('content')

        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{url('/earnings-adjustment')}}" style="color:#6c757d;">Earnings Adjustment</a></li>
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
                            <h4 class="card-title mg-b-0">Earnings Adjustment</h4>
                        </div>
                        <div class="col-md-6 text-right">
                            <a style="font-size: 15px;" class="btn btn-primary btn-sm" href="{{url('earnings-adjustment/create')}}"><i class="fa fa-plus-circle"></i> &nbsp;Create</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mg-b-0 text-md-nowrap">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width:5%;vertical-align: middle;">SL</th>
                                    <th style="width:18%;vertical-align: middle;">Employee Name</th>
                                    <th class="text-left" style="width:12%;vertical-align: middle;">Component Type</th>
                                    <th class="text-center" style="width:10%;vertical-align: middle;">Amount</th>
                                    <th class="text-center" style="width:10%;vertical-align: middle;">Amount Type</th>
                                    <th class="text-center" style="width:15%;vertical-align: middle;">Month</th>
                                    <th class="text-center" style="width:10%;vertical-align: middle;">Year</th>
                                    <th class="text-center" style="width:10%;vertical-align: middle;">Status</th>
                                    <th class="text-center" style="width:10%;vertical-align: middle;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($earnings as $earning)
                                <tr>
                                    <td style="vertical-align: middle" class="text-center">{{(($earnings->currentPage() * 10) - 10) + $loop->iteration}}</td>
                                    <td style="vertical-align: middle">{{employee_name_by_increment_id($earning->employee_id)}}</td>
                                    <td style="vertical-align: middle" class="text-left">{{get_component_name($earning->salary_component_id)}}</td>
                                    <td style="vertical-align: middle" class="text-center">{{number_formatting($earning->amount)}}</td>
                                    <td style="vertical-align: middle" class="text-center">
                                        @if($earning->type == "Increase")
                                            <span class="badge badge-success">Salary Increase</span>
                                        @else
                                            <span class="badge badge-danger">Salary Decrease</span>
                                        @endif
                                    </td>
                                    <td style="vertical-align: middle" class="text-center">{{$earning->month}}</td>
                                    <td style="vertical-align: middle" class="text-center">{{$earning->year}}</td>
                                    <td style="vertical-align: middle" class="text-center">
                                        @if($earning->status == "1")
                                            <span class="badge badge-info">Active</span>
                                        @else
                                            <span class="badge badge-warning">Inactive</span>
                                        @endif
                                    </td>
                                    <td style="vertical-align: middle" class="text-center">
                                        <button data-toggle="dropdown" class="btn btn-success btn-sm">Action <i class="icon ion-ios-arrow-down tx-11 mg-l-3"></i></button>
                                        <div class="dropdown-menu">
                                            <a href="{{'earnings-adjustment-view/'.$earning->id}}" class="dropdown-item">View</a>
                                            <a href="{{'earnings-adjustment-print/'.$earning->id}}" class="dropdown-item">Print</a>
                                            <a href="{{'earnings-adjustment-update/'.$earning->id}}" class="dropdown-item">Edit</a>
                                            @if($earning->status == "1")
                                                <a href="{{'earnings-adjustment/inactive/'.$earning->id}}" class="dropdown-item">Inactive</a>
                                            @else
                                                <a href="{{'earnings-adjustment/active/'.$earning->id}}" class="dropdown-item">Active</a>
                                            @endif
                                            <a href="javascript:void(0)" class="dropdown-item" onclick="confirmDelete({{$earning->id}})">Delete</a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mg-t-15">
                        {{ $earnings->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>
    
    <script>

        function confirmDelete(id) {
            var r = confirm("Are you confirm to delete?");
            if (r == true) {
            window.location = "/earning-adjustment/delete/"+id;
            }
        }

    </script>

@endsection