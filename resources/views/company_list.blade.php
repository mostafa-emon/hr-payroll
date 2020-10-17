@extends('layouts.master')

@section('content')

        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{url('/subscription')}}" style="color:#6c757d;">Subscriptions</a></li>
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
                            <h4 class="card-title mg-b-0">Subscriptions</h4>
                        </div>
                        <div class="col-md-6 text-right">
                            <a style="font-size: 15px;" href="{{url('company-register')}}" class="btn btn-primary btn-sm"><i class="fa fa-plus-circle"></i> &nbsp;Create</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mg-b-0 text-md-nowrap">
                            <thead>
                                <tr>
                                    <th class="text-center wd-5p">Sl</th>
                                    <th class="wd-15p">Company Name</th>
                                    <th class="wd-20p text-center">Subscription</th>
                                    <th class="wd-25p">Renew</th>
                                    <th class="wd-25p">Reset</th>
                                    <th class="text-center wd-15">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $sl = 0; @endphp
                                @foreach($companies as $company)
                                @php $sl = $sl+2; @endphp
                                <tr>
                                    <td class="text-center" style="vertical-align: middle">{{ $loop->iteration }}</td>
                                    <td style="vertical-align: middle">{{ $company->name }}</td>
                                    <td class="text-center" style="vertical-align: middle">
                                    Amount: <b>{{ $company->amount }}</b><br>
                                    Start Date: <b>{{ date('d M Y',strtotime($company->subscription_start_date)) }}</b><br>
                                    End Date: <b>{{ date('d M Y',strtotime($company->subscription_end_date)) }}</b>
                                    </td>
                                    <td class="text-center" style="vertical-align: middle">
                                    <form action="{{url ('company-renew/'.$company->id) }}" method="POST">
                                        {{ csrf_field() }}
                                        <div class="input-group mb-3" style="margin-top:17px;">
                                        <input type="text" name="amount" class="form-control" required style="width:60px;border-right:0px;border-top-right-radius:0px;border-bottom-right-radius:0px;" placeholder="amount"/>
                                        <input type="text" name="subscription_start_date" class="form-control dtpicker" value="{{date('d-m-Y',strtotime($company->subscription_start_date))}}" autocomplete="off" required style="width:85px;border-right:0px;border-top-right-radius:0px;border-bottom-right-radius:0px;" placeholder="start date"/>
                                        <input type="text" name="subscription_end_date" class="form-control dtpicker" autocomplete="off" required style="width:85px;border-top-right-radius:0px;border-bottom-right-radius:0px;" placeholder="end date"/>
                                        <input type="submit" class="btn btn-info btn-sm pointer" value="Renew" style="border-top-left-radius:0px;border-bottom-left-radius:0px;"/>
                                        </div>
                                    </form>
                                    </td>
                                    <td>

                                    <form action="{{url ('company-email-reset/'.$company->id) }}" method="POST">
                                        {{ csrf_field() }}
                                        <div class="input-group mb-3" style="margin-top:17px;">
                                        <input type="text" name="login_email" class="form-control" autocomplete="off" required style="width:90px;border-top-right-radius:0px;border-bottom-right-radius:0px;" placeholder="login email"/>
                                        <input type="submit" class="btn btn-warning btn-sm pointer" value="Reset" style="border-top-left-radius:0px;border-bottom-left-radius:0px;"/>
                                        </div>
                                    </form>

                                    <form action="{{url ('company-password-reset/'.$company->id) }}" method="POST">
                                        {{ csrf_field() }}
                                        <div class="input-group mb-3" style="margin-top:17px;">
                                        <input type="text" name="password" class="form-control" autocomplete="off" required style="width:90px;border-top-right-radius:0px;border-bottom-right-radius:0px;" placeholder="password"/>
                                        <input type="submit" class="btn btn-warning btn-sm pointer" value="Reset" style="border-top-left-radius:0px;border-bottom-left-radius:0px;"/>
                                        </div>
                                    </form>

                                    </td>
                                    <td class="text-center" style="vertical-align: middle">
                                    @if($company->status == 0)
                                        <a class="btn btn-success btn-sm" href="{{url('company-active/'.$company->id)}}" style="width:80px"> Activate </a>
                                    @else
                                        <a class="btn btn-danger btn-sm" href="{{url('company-inactive/'.$company->id)}}" style="width:80px"> Deactivate </a>
                                    @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        function confirmDelete(id){
        var result = confirm("Are you confirm to delete?");
        if (result) {
            window.location = 'company/delete/'+id
        }
        }
    </script>

@endsection