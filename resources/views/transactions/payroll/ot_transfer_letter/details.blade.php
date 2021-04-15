@extends('layouts.master')

@section('content')

        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('/ot-transfer-letter')}}" style="color:#6c757d; font-weight: bold">OT Transfer Letter</a></li>
                <li class="breadcrumb-item active"><a style="color:#6c757d;">Details</a></li>
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
                            <h4 class="card-title mg-b-0">OT Transfer Letter Details</h4>
                        </div>
                        <hr>
                    </div>

                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">SL</th>
                                    <th>Employee ID</th>
                                    <th>Employee Name</th>
                                    <th>Department</th>
                                    <th>Designation</th>
                                    <th>Bank Account No</th>
                                    <th>Payable Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transfer_details as $detail)
                                    <tr>
                                        <td class="text-center" style="vertical-align: middle">{{(($transfer_details->currentPage() * 10) - 10) + $loop->iteration}}</td>
                                        <td style="vertical-align: middle">{{get_employee_id($detail->employee_id)}}</td>
                                        <td style="vertical-align: middle">{{employee_name_by_increment_id($detail->employee_id)}}</td>
                                        <td style="vertical-align: middle;text-align:left;">{{employee_department($detail->employee_id)}}</td>
                                        <td style="vertical-align: middle;text-align:left;">{{employee_designation($detail->employee_id)}}</td>
                                        <td style="vertical-align: middle;text-align:left;">{{bank_account_no($detail->employee_id)}}</td>
                                        <td style="vertical-align: middle">{{number_formatting($detail->ot_amount)}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mg-t-15">
                        {{ $transfer_details->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection