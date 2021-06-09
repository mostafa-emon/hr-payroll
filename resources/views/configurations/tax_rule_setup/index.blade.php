@extends('layouts.master')

@section('content')

        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{url('/tax-rule-setup')}}" style="color:#6c757d;">Tax Rule Setup</a></li>
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
                            <h4 class="card-title mg-b-0">Tax Rule Setup</h4>
                        </div>
                        <div class="col-md-6 text-right">
                            {{--@if(roles() != "" && in_array(61, json_decode(roles(),false)))--}}
                                <a style="font-size: 15px;" class="btn btn-primary btn-sm" href="{{url('tax-rule-setup/add')}}"><i class="fa fa-plus-circle"></i> &nbsp;Add</a>
                            {{--@endif--}}
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mg-b-0 text-md-nowrap">
                            <thead>
                                <tr>
                                    <th class="text-center">SL</th>
                                    <th class="text-center">Income Year</th>
                                    <th class="text-center">Assesment Year</th>
                                    {{--@if(in_array(62, json_decode(roles(),false)) || in_array(63, json_decode(roles(),false)))--}}
                                        <th class="text-center">Action</th>
                                    {{--@endif--}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($setups as $setup)
                                <tr>
                                    <td class="text-center" style="vertical-align: middle">{{(($setups->currentPage() * 10) - 10) + $loop->iteration}}</td>
                                    <td class="text-center" style="vertical-align: middle">{{$setup->income_year_from}} - {{$setup->income_year_to}}</td>
                                    <td class="text-center" style="vertical-align: middle">{{$setup->assesment_year_from}} - {{$setup->assesment_year_to}}</td>
                                    {{--@if(in_array(62, json_decode(roles(),false)) || in_array(63, json_decode(roles(),false)))--}}
                                        <td class="text-center" style="vertical-align: middle">
                                            <button data-toggle="dropdown" class="btn btn-success btn-sm">Action <i class="icon ion-ios-arrow-down tx-11 mg-l-3"></i></button>
                                            <div class="dropdown-menu">
                                                {{--@if(roles() != "" && in_array(62, json_decode(roles(),false)))--}}
                                                    <a href="{{'tax-rule-setup/update/'.$setup->id}}" class="dropdown-item">Update</a>
                                                {{--@endif
                                                @if(roles() != "" && in_array(63, json_decode(roles(),false)))--}}
                                                    <a href="javascript:void(0)" class="dropdown-item" onclick="confirmDelete({{$setup->id}})">Delete</a>
                                                {{--@endif--}}
                                            </div>
                                        </td>
                                    {{--@endif--}}
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mg-t-15">
                        {{ $setups->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>
    
    <script>

        function confirmDelete(id) {
            var r = confirm("Are you confirm to delete?");
            if (r == true) {
            window.location = "/tax-rule-setup/delete/"+id;
            }
        }

    </script>

@endsection