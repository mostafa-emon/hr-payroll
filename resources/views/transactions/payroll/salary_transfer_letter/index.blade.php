@extends('layouts.master')

@section('content')

        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{url('/salary-transfer-letter')}}" style="color:#6c757d;">Salary Transfer Letter</a></li>
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
                            <h4 class="card-title mg-b-0">Salary Transfer Letter</h4>
                        </div>
                        <div class="col-md-6 text-right">
                            <a style="font-size: 15px;" class="btn btn-primary btn-sm" href="{{url('salary-transfer-letter/create')}}"><i class="fa fa-plus-circle"></i> &nbsp;Create</a>
                        </div>
                    </div>
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
                                        <a style="font-size: 15px;" class="btn btn-success btn-sm" href="{{url('salary-transfer-letter-details/'.$letter->id)}}">Details</a>
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

        function confirmDelete(id) {
            var r = confirm("Are you confirm to delete?");
            if (r == true) {
            window.location = "/govt-holiday/delete/"+id;
            }
        }

    </script>

@endsection