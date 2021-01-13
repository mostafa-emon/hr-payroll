@extends('layouts.master')

@section('content')

        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{url('/roster')}}" style="color:#6c757d;">Roster</a></li>
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
                            <h4 class="card-title mg-b-0">Roster</h4>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="{{url('roster-search')}}" style="font-size: 15px;" class="btn btn-info btn-sm">Search</a>
                            <a href="{{url('create-roster')}}" style="font-size: 15px;" class="btn btn-primary btn-sm" ><i class="fa fa-plus-circle"></i> &nbsp;Create</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mg-b-0 text-md-nowrap">
                            <thead>
                                <tr>
                                    <th style="vertical-align: middle" class="text-center">SL</th>
                                    <th style="vertical-align: middle">Roster Name</th>
                                    <th style="vertical-align: middle">Departement</th>
                                    <th style="vertical-align: middle">Project</th>
                                    <th style="vertical-align: middle">Branch</th>
                                    <th style="vertical-align: middle" class="text-center">From Date</th>
                                    <th style="vertical-align: middle" class="text-center">To Date</th>
                                    <th style="vertical-align: middle" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rosters as $roster)
                                <tr>
                                    <td style="vertical-align: middle" class="text-center">{{(($rosters->currentPage() * 10) - 10) + $loop->iteration}}</td>
                                    <td style="vertical-align: middle">{{$roster->roster_name}}</td>
                                    <td style="vertical-align: middle">{{department_name($roster->department_id)}}</td>
                                    <td style="vertical-align: middle">{{project_name($roster->project_id)}}</td>
                                    <td style="vertical-align: middle">{{branch_name($roster->branch_id)}}</td>
                                    <td style="vertical-align: middle" class="text-center">{{date('d-m-Y',strtotime($roster->from_date))}}</td>
                                    <td style="vertical-align: middle" class="text-center">{{date('d-m-Y',strtotime($roster->to_date))}}</td>
                                    <td style="vertical-align: middle" class="text-center">
                                        <button data-toggle="dropdown" class="btn btn-success btn-sm">Action <i class="icon ion-ios-arrow-down tx-11 mg-l-3"></i></button>
                                        <div class="dropdown-menu">
                                            <a href="{{url('roster-duplicate/'.$roster->id)}}" class="dropdown-item">Duplicate</a>
                                            <a href="javascript:void(0)" class="dropdown-item" onclick="confirmDelete({{$roster->id}})">Delete</a>
                                            <a href="{{url('roster/employee-list/'.$roster->id)}}" class="dropdown-item">Employee List</a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mg-t-15">
                        {{ $rosters->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        function confirmDelete(id) {
            var r = confirm("Are you confirm to delete?");
            if (r == true) {
            window.location = "/roster/delete/"+id;
            }
        }

    </script>

@endsection