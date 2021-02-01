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
            <li class="breadcrumb-item"><a href="{{url('/salary-sheet')}}" style="color:#6c757d; font-weight: bold">Salary Sheet</a></li>
            <li class="breadcrumb-item active"><a href="{{ url('salary-sheet-details/') }}" style="color:#6c757d;">Details</a></li>
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
                            <h4 class="card-title mg-b-0">Salary Sheet Details</h4>
                        </div>
                        <div class="col-md-6 text-right">
                        </div>
                    </div>
                    <hr>
                    <form action="{{ url('salary-transfer-letter/create') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="row">

                            <div class="col-md-3">
                                <input type="text" name="month" class="form-control monthpicker" autocomplete="off" placeholder="Month" value="{{$month}}" required>
                            </div>

                            <div class="col-md-3">
                                <select name="bank_id" id="bank_id" class="form-control select2-no-search" required>
                                    <option label="Choose Bank"></option>
                                    @foreach($banks as $bank)
                                        <option value="{{$bank->id}}" @if($bank_id == $bank->id) selected @endif>{{$bank->bank_name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <select name="currency_id" id="currency_id" class="form-control select2-no-search" required>
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

                    <br>
                    @if($month != "" && (count($employment_infos) > 0))

                        <form method="post" action="{{url('store-salary-transfer-letter')}}">
                            {{ csrf_field() }}
                            <input type="hidden" name="store_month" value="{{$formatted_month}}"/>
                            <input type="hidden" name="store_year" value="{{$formatted_year}}"/>
                            <input type="hidden" name="store_currency_id" value="{{$currency_id}}"/>
                            <input type="hidden" name="store_bank_id" value="{{$bank_id}}"/>

                            <div class="table-responsive">
                                <table style="width:100%;" class="table table-striped table-bordered mg-b-0 text-md-nowrap">
                                    <thead>
                                        <tr>
                                            <th style="width:5%;vertical-align: middle;text-align:center;">SL</th>
                                            <th style="width:30%;vertical-align: middle;text-align:center;">Employee ID</th>
                                            <th style="width:35%;vertical-align: middle;text-align:left;">Employee Name</th>
                                            <th style="width:30%;vertical-align: middle;text-align:right;">Salary Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($employment_infos as $employee)
                                            <tr>
                                                <td style="vertical-align: middle;text-align:center;">{{$loop->iteration}}</td>
                                                <td style="vertical-align: middle;text-align:center;">{{$employee->original_employee_id}}</td>
                                                <td style="vertical-align: middle;text-align:left;">{{$employee->name}}</td>
                                                <td style="vertical-align: middle;text-align:right;">
                                                    {{$employee->total_salary}}
                                                    <input type="hidden" name="employee_id[]" value="{{$employee->employee_id}}">
                                                    <input type="hidden" name="salary_amount[]" value="{{$employee->total_salary}}">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div class="pd-t-15 text-center">
                                    <input class="btn btn-main-primary" style="width:100px;" type="submit" value="Submit"/>
                                </div>
                            </div>
                        
                        </form>
                        
                    @endif

                </div>
                
            </div>
        </div>

    </div>

@endsection