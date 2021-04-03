@extends('layouts.master')

@section('content')

    <style>
        .ui-datepicker-calendar {
            display: none;
        }
        .ui-datepicker-prev {
            display: none;
        }
        .ui-datepicker-next {
            display: none;
        }
    </style>

    <div class="row mb-2">
        <div class="col-sm-6"></div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{url('/salary-transfer-letter-report')}}" style="color:#6c757d;">Salary Transfer Letter Report</a></li>
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
                            <h4 class="card-title mg-b-0">Salary Transfer Letter Report</h4>
                        </div>
                    </div>
                    <hr>
                    <form action="{{ url('salary-transfer-letter-report') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="row">

                            <div class="col-md-3">
                                <input type="text" name="month" class="form-control monthpicker" autocomplete="off" placeholder="Month" value="{{$month}}">
                            </div>

                            <div class="col-md-3">
                                <select name="bank_id" id="bank_id" class="form-control select2-no-search">
                                    <option label="Choose Bank"></option>
                                    @foreach($banks as $bank)
                                        <option value="{{$bank->id}}" @if($bank_id == $bank->id) selected @endif>{{$bank->bank_name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <select name="currency_id" id="currency_id" class="form-control select2-no-search">
                                    <option label="Choose Currency"></option>
                                    @foreach($currencies as $currency)
                                        <option value="{{$currency->id}}" @if($currency_id == $currency->id) selected @endif>{{$currency->currency_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-md-2 text-left">
                                <input class="btn btn-main-primary" style="width:100px;" type="submit" value="Search"/>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mg-b-0 text-md-nowrap">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width:5%;">SL</th>
                                    <th style="width:30%;">Month</th>
                                    <th style="width:20%;">Currency</th>
                                    <th style="width:25%;">Bank Account</th>
                                    <th class="text-center" style="width:20%;">Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transfer_letters as $letter)
                                <tr>
                                    <td class="text-center" style="vertical-align: middle">{{(($transfer_letters->currentPage() * 10) - 10) + $loop->iteration}}</td>
                                    <td style="vertical-align: middle">{{$letter->month}} {{$letter->year}}</td>
                                    <td style="vertical-align: middle">{{currency_name($letter->currency_id)}}</td>
                                    <td style="vertical-align: middle">{{bank_name($letter->bank_id)}}</td>
                                    <td class="text-center" style="vertical-align: middle">
                                        <button data-toggle="dropdown" class="btn btn-success btn-sm">Action <i class="icon ion-ios-arrow-down tx-11 mg-l-3"></i></button>
                                        <div class="dropdown-menu">
                                            <a href="{{url('salary-transfer-letter-report-reprint/'.$letter->id)}}" class="dropdown-item">Print</a>
                                            <a href="{{url('salary-transfer-letter-details/'.$letter->id)}}" class="dropdown-item">Details</a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mg-t-15">
                        {{ $transfer_letters->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>
    
    <script>


    </script>

@endsection