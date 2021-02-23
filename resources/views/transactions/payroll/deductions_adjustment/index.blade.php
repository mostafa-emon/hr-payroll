@extends('layouts.master')

@section('content')

        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{url('/deductions-adjustment')}}" style="color:#6c757d;">Deductions Adjustment</a></li>
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
                            <h4 class="card-title mg-b-0">Deductions Adjustment</h4>
                        </div>
                        <div class="col-md-6 text-right">
                            <a style="font-size: 15px;" class="btn btn-primary btn-sm" href="{{url('deductions-adjustment/create')}}"><i class="fa fa-plus-circle"></i> &nbsp;Create</a>
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
                                @foreach($deductions as $deduction)
                                <tr>
                                    <td style="vertical-align: middle" class="text-center">{{(($deductions->currentPage() * 10) - 10) + $loop->iteration}}</td>
                                    <td style="vertical-align: middle">{{employee_name_by_increment_id($deduction->employee_id)}}</td>
                                    <td style="vertical-align: middle" class="text-left">{{get_component_name($deduction->salary_component_id)}}</td>
                                    <td style="vertical-align: middle" class="text-center">{{$deduction->amount}}</td>
                                    <td style="vertical-align: middle" class="text-center">
                                        @if($deduction->type == "Increase")
                                            <span class="badge badge-success">Salary Increase</span>
                                        @else
                                            <span class="badge badge-danger">Salary Decrease</span>
                                        @endif
                                    </td>
                                    <td style="vertical-align: middle" class="text-center">{{$deduction->month}}</td>
                                    <td style="vertical-align: middle" class="text-center">{{$deduction->year}}</td>
                                    <td style="vertical-align: middle" class="text-center">
                                        @if($deduction->status == "1")
                                            <span class="badge badge-info">Active</span>
                                        @else
                                            <span class="badge badge-warning">Inactive</span>
                                        @endif
                                    </td>
                                    <td style="vertical-align: middle" class="text-center">
                                        <button data-toggle="dropdown" class="btn btn-success btn-sm">Action <i class="icon ion-ios-arrow-down tx-11 mg-l-3"></i></button>
                                        <div class="dropdown-menu">
                                            <a href="{{'deductions-adjustment-view/'.$deduction->id}}" class="dropdown-item">View</a>
                                            <a href="{{'deductions-adjustment-print/'.$deduction->id}}" class="dropdown-item">Print</a>
                                            <a href="{{'deductions-adjustment-update/'.$deduction->id}}" class="dropdown-item">Edit</a>
                                            @if($deduction->status == "1")
                                                <a href="{{'deductions-adjustment/inactive/'.$deduction->id}}" class="dropdown-item">Inactive</a>
                                            @else
                                                <a href="{{'deductions-adjustment/active/'.$deduction->id}}" class="dropdown-item">Active</a>
                                            @endif
                                            <a href="javascript:void(0)" class="dropdown-item" onclick="confirmDelete({{$deduction->id}})">Delete</a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mg-t-15">
                        {{ $deductions->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>
    
    <script>

        function confirmDelete(id) {
            var r = confirm("Are you confirm to delete?");
            if (r == true) {
            window.location = "/deduction-adjustment/delete/"+id;
            }
        }

    </script>

@endsection