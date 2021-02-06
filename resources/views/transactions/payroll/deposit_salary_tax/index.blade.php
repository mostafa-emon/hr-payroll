@extends('layouts.master')

@section('content')

        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{url('/deposit-salary-tax')}}" style="color:#6c757d;">Deposit Salary Tax</a></li>
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
                            <h4 class="card-title mg-b-0">Deposit Salary Tax</h4>
                        </div>
                        <div class="col-md-6 text-right">
                            <a style="font-size: 15px;" class="btn btn-primary btn-sm" href="{{url('deposit-salary-tax/add')}}"><i class="fa fa-plus-circle"></i> &nbsp;Add</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mg-b-0 text-md-nowrap">
                            <thead>
                                <tr>
                                    <th class="text-center" style="vertical-align:middle;">SL</th>
                                    <th style="vertical-align:middle;">From - To</th>
                                    <th style="vertical-align:middle;">Department</th>
                                    <th style="vertical-align:middle;">Project</th>
                                    <th style="vertical-align:middle;">Branch</th>
                                    <th style="vertical-align:middle;">Currency</th>
                                    <th class="text-center" style="vertical-align:middle;">Total Tax</th>
                                    <th class="text-center" style="vertical-align:middle;">Total Amount</th>
                                    <th class="text-center" style="vertical-align:middle;">Challan No</th>
                                    <th class="text-center" style="vertical-align:middle;">Attachment</th>
                                    <th class="text-center" style="vertical-align:middle;">Status</th>
                                    <th class="text-center" style="vertical-align:middle;width:95px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($taxes as $tax)
                                @php 
                                    $total_taxes = total_tax($tax->id);
                                    list($total_tax,$total_amount) = explode("_",$total_taxes);
                                @endphp
                                <tr>
                                    <td class="text-center" style="vertical-align: middle">{{(($taxes->currentPage() * 10) - 10) + $loop->iteration}}</td>
                                    <td style="vertical-align: middle">{{date('M-Y',strtotime($tax->from))}} {{date('M-Y',strtotime($tax->to))}}</td>
                                    <td style="vertical-align: middle">{{department_name($tax->department_id)}}</td>
                                    <td style="vertical-align: middle">{{project_name($tax->project_id)}}</td>
                                    <td style="vertical-align: middle">{{branch_name($tax->branch_id)}}</td>
                                    <td style="vertical-align: middle">{{currency_name($tax->currency_id)}}</td>
                                    <td class="text-center" style="vertical-align: middle">{{$total_tax}}</td>
                                    <td class="text-center" style="vertical-align: middle">{{sprintf("%.2f", $total_amount)}}</td>
                                    <td class="text-center" style="vertical-align: middle">{{$tax->challan_no}}</td>
                                    <td class="text-center" style="vertical-align: middle">
                                        @if($tax->attachment != "")
                                            @foreach(json_decode($tax->attachment) as $file)
                                                <a style="font-size: 15px;" class="btn btn-info btn-sm" href="{{url('download-file/deposit_salary_tax/'.$file)}}">Download</a>
                                                <br><br>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td class="text-center" style="vertical-align: middle">
                                        @if($tax->status == "Pending")
                                            <span class="badge badge-warning">Pending</span>
                                        @elseif($tax->status == "Approved")
                                            <span class="badge badge-success">Approved</span>
                                        @else
                                            <span class="badge badge-danger">Cancelled</span>
                                        @endif
                                    </td>
                                    <td class="text-center" style="vertical-align: middle">
                                        <button data-toggle="dropdown" class="btn btn-success btn-sm">Action <i class="icon ion-ios-arrow-down tx-11 mg-l-3"></i></button>
                                        <div class="dropdown-menu">
                                            <a href="{{url('deposit-salary-tax-print-frontside/'.$tax->id)}}" class="dropdown-item">Print Frontside</a>
                                            <a href="{{url('deposit-salary-tax-print-backside/'.$tax->id)}}" class="dropdown-item">Print Backtside</a>
                                            @if($tax->status == "Pending")
                                            <a href="{{url('deposit-salary-tax-update/'.$tax->id)}}" class="dropdown-item">Edit</a>
                                                <a href="{{url('deposit-salary-tax/Approved/'.$tax->id)}}" class="dropdown-item">Approved</a>
                                                <a href="{{url('deposit-salary-tax/Cancelled/'.$tax->id)}}" class="dropdown-item">Cancelled</a>
                                            @endif
                                            <a href="{{url('deposit-salary-tax-upload_file/'.$tax->id)}}" class="dropdown-item">Upload</a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mg-t-15">
                        {{ $taxes->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection