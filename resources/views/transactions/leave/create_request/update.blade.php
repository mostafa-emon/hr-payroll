@extends('layouts.master')

@section('content')

        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('/leave-request')}}" style="color:#6c757d; font-weight: bold">Leave Request</a></li>
                <li class="breadcrumb-item active"><a href="{{url('/leave-request/update/'.$request_type.'/'.$leave->id)}}" style="color:#6c757d;">Edit</a></li>
            </ol>
            </div>
        </div>

    <div class="row row-sm">

        <!--div-->
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6" style="padding-top:5px">
                            <h4 class="card-title mg-b-0">Edit Leave Request</h4>
                        </div>
                        <div class="col-md-6 text-right"></div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="card">
								<div class="card-body">
                                    <form method="POST" action="{{url('leave-request/update/'.$request_type.'/'.$leave->id)}}" enctype="multipart/form-data">
                                        {{ csrf_field() }}

                                        @php 
                                            $datepicker_format = datepicker_format();
                                            $date_format = 'd-m-Y';
                                            
                                            if($datepicker_format == "MM-DD-YYYY") {
                                                $date_format = 'm-d-Y';
                                            }else if($datepicker_format == "YYYY/MM/DD") {
                                                $date_format = 'Y/m/d';
                                            }else if($datepicker_format == "DD-MMM-YY") {
                                                $date_format = 'd-M-Y';
                                            }
                                        @endphp

                                        <div class="pd-30 pd-sm-40 bg-gray-200">
                                            <div class="row row-xs">
                                                <div class="col-md-4 mg-t-10">
                                                    <select name="leave_type_id" class="form-control select2-no-search pa">
                                                        <option label="Leave Type"></option>
                                                        @foreach($types as $type)
                                                            <option value="{{$type->id}}" @if($leave->leave_type_id == $type->id) selected @endif>{{$type->leave_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4 mg-t-10">
                                                    <input id="start_date" class="form-control dtpicker" name="start_date" placeholder="Start date" value="{{date($date_format,strtotime($leave->start_date))}}" type="text" autocomplete="off">
                                                </div>
                                                <div class="col-md-4 mg-t-10">
                                                    <input id="end_date" class="form-control dtpicker" name="end_date" placeholder="End date" value="{{date($date_format,strtotime($leave->end_date))}}" type="text" autocomplete="off">
                                                </div>
                                                <div class="col-md-4 mg-t-10">
                                                    <input id="leave_days" class="form-control" placeholder="Number of Days" name="leave_days" value="{{$leave->leave_days}}" type="text">
                                                </div>
                                                <div class="col-md-8 mg-t-10">
                                                    <input id="leave_days" class="form-control" placeholder="Remark" name="remark" value="{{$leave->remark}}" type="text">
                                                </div>
                                                <div class="col-md-12 mg-t-10">
                                                    <label for="attach_file" style="margin-left:-10px;" class="col-form-label col-md-3">Attach Docs:</label>
                                                    <input class="form-control" name="attach_file" type="file">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row pd-t-10">
                                            <div class="col-md-12 text-center">
                                                <input class="btn btn-main-primary" style="width:100px;" type="submit" value="Submit"/>
                                            </div>
                                        </div>
                                    </form>
								</div>
							</div>
						</div>
					</div>
                </div>
            </div>
        </div>

    </div>

@endsection