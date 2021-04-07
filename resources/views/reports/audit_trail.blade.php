@extends('layouts.master')

@section('content')

        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{url('/audit-trail-report')}}" style="color:#6c757d;">Audit Trail Report</a></li>
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
                            <h4 class="card-title mg-b-0">Audit Trail Report</h4>
                        </div>
                        <div class="col-md-6 text-right">
                            {{--
                            <a href="{{url('audit-trail-report')}}" class="btn btn-info">Reset</a>
                            <a href="{{ url($excel_link) }}" class="btn btn-success">Export</a>&nbsp;
                            <button class="btn btn-primary" onclick="printElem()">Print</button>--}}
                        </div>
                    </div>
                    <hr>
                    <form action="{{ url('audit-trail-report') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-4">
                                <label for="Remark" style="font-weight:bold;" class="col-form-label">From Date:</label>
                                <input type="text" class="form-control dtpicker" name="from_date" value="{{date('d-m-Y',strtotime($from_date))}}"placeholder="From Date" autocomplete="off" required>
                            </div>
                            <div class="col-md-4">
                                <label for="Remark" style="font-weight:bold;" class="col-form-label">To Date:</label>
                                <input type="text" class="form-control dtpicker" name="to_date" value="{{date('d-m-Y',strtotime($to_date))}}" placeholder="To Date" autocomplete="off" required>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-3 text-left">
                                <input class="btn btn-main-primary" style="width:100px;" type="submit" value="Search"/>
                            </div>
                        </div>
                    </form>

                </div>

                @if(count($audits) > 0)
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mg-b-0 text-md-nowrap">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width:5%;">SL</th>
                                    <th class="text-center">Date Time</th>
                                    <th>User ID</th>
                                    <th>Auditable Type</th>
                                    <th>Auditable ID</th>
                                    <th>Event</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($audits as $audit)
                                <tr>
                                    <td class="text-center" style="vertical-align: middle">{{(($audits->currentPage() * 10) - 10) + $loop->iteration}}</td>
                                    <td class="text-center">{{date('d M Y h:i A',strtotime($audit->created_at))}}</td>
                                    <td>{{$audit->user_id}}</td>
                                    <td>{{$audit->auditable_type}}</td>
                                    <td>{{$audit->auditable_id}}</td>
                                    <td>{{$audit->event}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mg-t-15">
                        {{ $audits->links() }}
                    </div>
                </div>
                @endif
                
            </div>
        </div>

    </div>

    <style>
        table {
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            font-family:arial;
            font-size:13px;
            padding:5px;
        }
    </style>
    
    <script>

        function printElem(){
            var mywindow = window.open('', 'PRINT');
            mywindow.document.write('<style>table {border-collapse: collapse;} th, td {border: 1px solid black;font-family:arial;font-size:13px;padding:7px;} .div-padding-30{padding:30px;}</style>');
            mywindow.document.write(document.getElementById('printArea').innerHTML);

            setTimeout(function () {
                mywindow.focus();
                mywindow.print();
                mywindow.close();

                //window.location = "/mr"
            }, 1000);
        }
    </script>

@endsection