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
                                    <th class="text-center" style="width:5%;">SL</th>
                                    <th style="width:20%;">Employee Name</th>
                                    <th class="text-center" style="width:15%;">Amount</th>
                                    <th class="text-center" style="width:15%;">Month</th>
                                    <th class="text-center" style="width:15%;">Year</th>
                                    <th class="text-center" style="width:15%;">Status</th>
                                    <th class="text-center" style="width:15%;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($earnings as $earning)
                                <tr>
                                    <td style="vertical-align: middle" class="text-center">{{$loop->iteration}}</td>
                                    <td style="vertical-align: middle">{{employee_name_by_increment_id($earning->employee_id)}}</td>
                                    <td style="vertical-align: middle" class="text-center">{{$earning->amount}}</td>
                                    <td style="vertical-align: middle" class="text-center">{{$earning->month}}</td>
                                    <td style="vertical-align: middle" class="text-center">{{$earning->year}}</td>
                                    <td style="vertical-align: middle" class="text-center">
                                        @if($earning->status == "1") Active
                                        @else Inactive
                                        @endif
                                    </td>
                                    <td style="vertical-align: middle" class="text-center">
                                        <button data-toggle="dropdown" class="btn btn-success btn-sm">Action <i class="icon ion-ios-arrow-down tx-11 mg-l-3"></i></button>
                                        <div class="dropdown-menu">
                                            <a href="{{'govt-holiday/update/'.$earning->id}}" class="dropdown-item">Update</a>
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
            window.location = "/earnings-adjustment/delete/"+id;
            }
        }

    </script>

@endsection