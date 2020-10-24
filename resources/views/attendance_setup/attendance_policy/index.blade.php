@extends('layouts.master')

@section('content')

        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{url('/attendance-policy')}}" style="color:#6c757d;">Attendance Policy</a></li>
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
                            <h4 class="card-title mg-b-0">Attendance Policy</h4>
                        </div>
                        <div class="col-md-6 text-right">
                            <a style="font-size: 15px;" class="btn btn-primary btn-sm" href="{{url('attendance-policy/add')}}"><i class="fa fa-plus-circle"></i> &nbsp;Add</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mg-b-0 text-md-nowrap">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width:10%;">SL</th>
                                    <th class="text-center" style="width:35%;">From</th>
                                    <th class="text-center" style="width:35%;">To</th>
                                    <th class="text-center" style="width:20%;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($policies as $policy)
                                <tr>
                                    <td class="text-center" style="vertical-align: middle">{{$loop->iteration}}</td>
                                    <td class="text-center" style="vertical-align: middle">{{$policy->start_time}} @if($policy->start_time_meridiem == 0) AM @else PM @endif</td>
                                    <td class="text-center" style="vertical-align: middle">{{$policy->end_time}} @if($policy->end_time_meridiem == 0) AM @else PM @endif</td>
                                    <td class="text-center" style="vertical-align: middle">
                                        <button data-toggle="dropdown" class="btn btn-success btn-sm">Action <i class="icon ion-ios-arrow-down tx-11 mg-l-3"></i></button>
                                        <div class="dropdown-menu">
                                            <a href="{{'attendance-policy/update/'.$policy->id}}" class="dropdown-item">Update</a>
                                            <a href="javascript:void(0)" class="dropdown-item" onclick="confirmDelete({{$policy->id}})">Delete</a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $policies->links() }}
                </div>
            </div>
        </div>

    </div>
    
    <script>

        function confirmDelete(id) {
            var r = confirm("Are you confirm to delete?");
            if (r == true) {
            window.location = "/attendance-policy/delete/"+id;
            }
        }

    </script>

@endsection