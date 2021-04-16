@extends('layouts.master')

@section('content')

        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{url('/salary-sheet')}}" style="color:#6c757d;">Salary Sheet</a></li>
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

                    @if(session()->has('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session()->get('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6" style="padding-top:5px">
                            <h4 class="card-title mg-b-0">Salary Sheet</h4>
                        </div>
                        <div class="col-md-6 text-right">
                            <a style="font-size: 15px;" class="btn btn-primary btn-sm" href="{{url('salary-sheet/create')}}"><i class="fa fa-plus-circle"></i> &nbsp;Create</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mg-b-0 text-md-nowrap">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width:5%;">SL</th>
                                    <th class="text-center" style="width:20%;">Salary Month</th>
                                    <th class="text-center" style="width:20%;">Total Employee</th>
                                    <th class="text-center" style="width:20%;">Total Amount</th>
                                    <th class="text-center" style="width:15%;">Email Pay Slip</th>
                                    <th class="text-center" style="width:30%;">Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sheets as $sheet)
                                <tr>
                                    <td class="text-center" style="vertical-align:middle">{{$loop->iteration}}</td>
                                    <td class="text-center" style="vertical-align:middle">{{$sheet->month}} {{$sheet->year}}</td>
                                    <td class="text-center" style="vertical-align:middle">{{$sheet->total_employee}}</td>
                                    <td class="text-center" style="vertical-align:middle">{{number_formatting($sheet->total_salary)}}</td>
                                    <td class="text-center" style="vertical-align:middle">
                                        @php
                                            $total_receiver = mail_pay_slip_total($sheet->month,$sheet->year);
                                            $total_sent     = mail_pay_slip_sent($sheet->month,$sheet->year);
                                        @endphp
                                        @if($total_receiver == 0)
                                            <a style="font-size: 15px;" class="btn btn-info btn-sm" href="{{url('mail-pay-slip/'.$sheet->month.'/'.$sheet->year)}}">
                                                Send Email
                                            </a>
                                        @endif
                                        @if($total_receiver != 0 && $total_receiver > $total_sent)
                                            <a style="font-size: 15px;" class="btn btn-info btn-sm" href="{{url('mail-pay-slip/'.$sheet->month.'/'.$sheet->year)}}">
                                                Send Email
                                            </a>
                                        @endif
                                        @if($total_receiver != 0 && $total_receiver == $total_sent)
                                            <a style="font-size: 15px;" class="btn btn-success btn-sm" href="javascript:0">
                                                Already Sent
                                            </a>
                                        @endif
                                    </td>
                                    <td class="text-center" style="vertical-align:middle">
                                        <a style="font-size: 15px;" class="btn btn-success btn-sm" href="{{url('salary-sheet-details/'.$sheet->month.'/'.$sheet->year)}}">Details</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mg-t-15">
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
