@extends('layouts.master')

@section('content')

        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{url('/absent-deduction')}}" style="color:#6c757d;">Absent Deduction</a></li>
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
                            <h4 class="card-title mg-b-0">Absent Deduction</h4>
                        </div>
                        <div class="col-md-6 text-right">
                            <a style="font-size: 15px;" class="btn btn-primary btn-sm" href="{{url('absent-deduction/create')}}"><i class="fa fa-plus-circle"></i> &nbsp;Create</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mg-b-0 text-md-nowrap">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width:5%;vertical-align: middle;">SL</th>
                                    <th style="width:20%;vertical-align: middle;">Employee Name</th>
                                    <th class="text-center" style="width:20%;vertical-align: middle;">Employee ID</th>
                                    <th class="text-center" style="width:15%;vertical-align: middle;">Month</th>
                                    <th class="text-center" style="width:10%;vertical-align: middle;">Year</th>
                                    <th class="text-center" style="width:10%;vertical-align: middle;">Total Absent Days</th>
                                    <th class="text-center" style="width:10%;vertical-align: middle;">Total Deduction</th>
                                    <th class="text-center" style="width:10%;vertical-align: middle;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($deductions as $deduction)
                                @php $employee = get_employee_info($deduction->employee_id); @endphp
                                <tr>
                                    <td style="vertical-align: middle;" class="text-center">{{(($deductions->currentPage() * 10) - 10) + $loop->iteration}}</td>
                                    <td style="vertical-align: middle">{{$employee->name}}</td>
                                    <td style="vertical-align: middle" class="text-center">{{$employee->employee_id}}</td>
                                    <td style="vertical-align: middle" class="text-center">{{$deduction->month}}</td>
                                    <td style="vertical-align: middle" class="text-center">{{$deduction->year}}</td>
                                    <td style="vertical-align: middle" class="text-center">{{$deduction->total_absent_days}}</td>
                                    <td style="vertical-align: middle" class="text-center">{{$deduction->deduction}}</td>
                                    <td class="text-center" style="vertical-align: middle">
                                        <button data-toggle="dropdown" class="btn btn-success btn-sm">Action <i class="icon ion-ios-arrow-down tx-11 mg-l-3"></i></button>
                                        <div class="dropdown-menu">
                                            <a href="{{'absent-deduction/update/'.$deduction->id}}" class="dropdown-item">Update</a>
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
            window.location = "/absent-deduction/delete/"+id;
            }
        }

    </script>

@endsection