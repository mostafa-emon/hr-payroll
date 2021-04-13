@extends('layouts.master')

@section('content')

        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{url('/manual-log-entry')}}" style="color:#6c757d;">Manual Log Entry</a></li>
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
                            <h4 class="card-title mg-b-0">Manual Log Entry</h4>
                        </div>
                        <div class="col-md-6 text-right">
                            <a style="font-size: 15px;" class="btn btn-primary btn-sm" href="{{url('manual-log-entry/add')}}"><i class="fa fa-plus-circle"></i> &nbsp;Add</a>
                        </div>
                    </div>
                    <hr>
                    <form action="{{ url('manual-log-entry') }}" method="POST">
                        {{ csrf_field() }}

                        @php 
                            $datepicker_format = datepicker_format();
                            $date_format = 'd-m-Y';
                            
                            if($datepicker_format == "MM-DD-YYYY") {
                                $date_format = 'm-d-Y';
                            }else if($datepicker_format == "YYYY/MM/DD") {
                                $date_format = 'Y/m/d';
                            }else if($datepicker_format == "DD-MMM-YY") {
                                $date_format = 'd-M-y';
                            }
                        @endphp
                        
                        <div class="row">
                            <div class="col-md-3">
                                <input type="text" name="date" class="form-control dtpicker" autocomplete="off" placeholder="Date" value="{{date($date_format,strtotime($date))}}" required/>
                            </div>
                            <div class="col-md-9">
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
                                    <th style="width:25%;">Employee Name</th>
                                    <th class="text-center" style="width:15%;">Employee ID</th>
                                    <th class="text-center" style="width:15%;">Date</th>
                                    <th class="text-center" style="width:15%;">In Time</th>
                                    <th class="text-center" style="width:15%;">Out Time</th>
                                    <th class="text-center" style="width:10%;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($attendances as $attendance)
                                @php $employee = get_employee_info($attendance->employee_id); @endphp
                                <tr>
                                    <td class="text-center" style="vertical-align: middle">{{(($attendances->currentPage() * 10) - 10) + $loop->iteration}}</td>
                                    <td style="vertical-align: middle">{{$employee->name}}</td>
                                    <td class="text-center" style="vertical-align: middle">{{$employee->employee_id}}</td>
                                    <td class="text-center" style="vertical-align: middle">{{date('d-m-Y',strtotime($attendance->date))}}</td>
                                    <td class="text-center" style="vertical-align: middle">{{date('h:i A', strtotime($attendance->in_time))}}</td>
                                    <td class="text-center" style="vertical-align: middle">{{date('h:i A', strtotime($attendance->out_time))}}</td>
                                    {{--<td class="text-center" style="vertical-align: middle">
                                        <button data-toggle="dropdown" class="btn btn-success btn-sm">Action <i class="icon ion-ios-arrow-down tx-11 mg-l-3"></i></button>
                                        <div class="dropdown-menu">
                                            <a href="{{'manual-log-entry/update/'.$attendance->id}}" class="dropdown-item">Update</a>
                                        </div>
                                    </td>--}}
                                    <td class="text-center" style="vertical-align:middle">
                                        <a class="btn btn-success btn-sm" href="{{url ('manual-log-entry/update/'.$attendance->id) }}"> Update </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mg-t-15">
                        {{ $attendances->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>
    
    <script>

    </script>

@endsection