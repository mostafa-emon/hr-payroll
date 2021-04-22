@extends('layouts.master')

@section('content')

        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{url('/roles')}}" style="color:#6c757d;">Roles</a></li>
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

                    @if(session()->has('error_message'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session()->get('error_message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                    @endif
                    
                    <div class="row">
                        <div class="col-md-6" style="padding-top:5px">
                            <h4 class="card-title mg-b-0">Roles</h4>
                        </div>
                        <div class="col-md-6 text-right">
                            @if(roles() != "" && in_array(27, json_decode(roles(),false)))
                                <a href="{{url('roles/add')}}" style="font-size: 15px;" class="btn btn-primary btn-sm" ><i class="fa fa-plus-circle"></i> &nbsp;Create</a>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mg-b-0 text-md-nowrap">
                            <thead>
                                <tr>
                                    <th style="vertical-align: middle" class="text-center">SL</th>
                                    <th style="vertical-align: middle" class="text-center">Role Name</th>
                                    @if(in_array(28, json_decode(roles(),false)) || in_array(29, json_decode(roles(),false)))
                                        <th style="vertical-align: middle" class="text-center">Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($roles as $role)
                                <tr>
                                    <td style="vertical-align: middle" class="text-center">{{(($roles->currentPage() * 10) - 10) + $loop->iteration}}</td>
                                    <td style="vertical-align: middle">{{$role->role_name}}</td>
                                    @if(in_array(28, json_decode(roles(),false)) || in_array(29, json_decode(roles(),false)))
                                        <td class="text-center" style="vertical-align: middle">
                                            <button data-toggle="dropdown" class="btn btn-success btn-sm">Action <i class="icon ion-ios-arrow-down tx-11 mg-l-3"></i></button>
                                            <div class="dropdown-menu">
                                                @if(roles() != "" && in_array(28, json_decode(roles(),false)))
                                                    <a href="{{'roles/update/'.$role->id}}" class="dropdown-item">Update</a>
                                                @endif
                                                @if(roles() != "" && in_array(29, json_decode(roles(),false)))
                                                    <a href="javascript:void(0)" class="dropdown-item" onclick="confirmDelete({{$role->id}})">Delete</a>
                                                @endif
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mg-t-15">
                        {{ $roles->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        function confirmDelete(id) {
            var r = confirm("Are you confirm to delete?");
            if (r == true) {
            window.location = "/roles/delete/"+id;
            }
        }

    </script>

@endsection