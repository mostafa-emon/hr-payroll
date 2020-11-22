@extends('layouts.master')

@section('content')

        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{url('/employee')}}" style="color:#6c757d;">Employees</a></li>
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
                            <h4 class="card-title mg-b-0">Employees</h4>
                        </div>
                        <div class="col-md-6 text-right"> 
                            <a href="{{url('employee/add/personal')}}" style="font-size: 15px;" class="btn btn-primary btn-sm" ><i class="fa fa-plus-circle"></i> &nbsp;Create</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mg-b-0 text-md-nowrap">
                            <thead>
                                <tr>
                                    <th style="vertical-align: middle" class="text-center">SL</th>
                                    <th style="vertical-align: middle" class="text-center">Photo</th>
                                    <th style="vertical-align: middle" class="text-center">ID</th>
                                    <th style="vertical-align: middle">Name</th>
                                    <th style="vertical-align: middle">Departement</th>
                                    <th style="vertical-align: middle">Designation</th>
                                    <th style="vertical-align: middle">Phone</th>
                                    <th style="vertical-align: middle">Email</th>
                                    <th style="vertical-align: middle">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($employees as $employee)
                                <tr>
                                    <td style="vertical-align: middle" class="text-center">{{$loop->iteration}}</td>
                                    <td style="vertical-align: middle">
                                        @if($employee->employee_photo != "")
                                            <img src="{{ asset('storage/'.$employee->employee_photo) }}" style="border-radius:50%;" width="45" height="45"/>
                                        @else
                                        <img src="{{ asset('assets/img/users.png') }}" style="border-radius:50%;" width="45" height="45"/>
                                        @endif
                                    </td>
                                    <td style="vertical-align: middle">{{$employee->employee_id}}</td>
                                    <td style="vertical-align: middle">{{$employee->name}}</td>
                                    <td style="vertical-align: middle">{{employee_department($employee->id)}}</td>
                                    <td style="vertical-align: middle">{{employee_designation($employee->id)}}</td>
                                    <td style="vertical-align: middle">{{$employee->phone_1}}</td>
                                    <td style="vertical-align: middle">{{$employee->email_address}}</td>
                                    <td style="vertical-align: middle">Action</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $employees->links() }}
                </div>
            </div>
        </div>

    </div>

    <script>
        function confirmDelete(id) {
            var r = confirm("Are you confirm to delete?");
            if (r == true) {
            window.location = "/branches/delete/"+id;
            }
        }

    </script>

@endsection