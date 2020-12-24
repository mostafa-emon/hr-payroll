@extends('layouts.master')

@section('content')

        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
                <li class="breadcrumb-item active"><a style="color:#6c757d;">Campaign Receivers</a></li>
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
                            <h4 class="card-title mg-b-0">Campaign Receivers</h4>
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
                                    <th>Receiver Name</th>
                                    <th>Phone</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($receivers as $receiver)
                                    <tr>
                                        <td class="text-center" style="vertical-align: middle">{{$loop->iteration}}</td>
                                        <td style="vertical-align: middle">{{$receiver->receiver_name}}</td>
                                        <td style="vertical-align: middle">{{$receiver->phone}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $receivers->links() }}
                </div>
            </div>
        </div>

    </div>

@endsection