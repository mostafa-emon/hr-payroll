@extends('layouts.master')

@section('content')

        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('/govt-holiday')}}" style="color:#6c757d; font-weight: bold">Govt Holiday</a></li>
                <li class="breadcrumb-item active"><a href="{{url('/govt-holiday/update/'.$earning->id)}}" style="color:#6c757d;">Update</a></li>
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
                            <h4 class="card-title mg-b-0">Update Govt Holiday</h4>
                        </div>
                        <div class="col-md-6 text-right"></div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="card">
								<div class="card-body">
                                    <form method="POST" action="{{url('govt-holiday/update/'.$earning->id)}}" enctype="multipart/form-data">
                                        {{ csrf_field() }}

                                        <div class="pd-30 pd-sm-40 bg-gray-200">
                                            <div class="row row-xs">
                                                <div class="col-md-6 mg-t-10">
                                                    <input class="form-control" placeholder="Name" name="name" value="{{$earning->name}}" type="text">
                                                </div>
                                                <div class="col-md-6 mg-t-10">
                                                    <input class="form-control" placeholder="ID" name="holiday_id" value="{{$earning->holiday_id}}" type="text">
                                                </div>
                                                <div class="col-md-6 mg-t-10">
                                                    <input class="form-control dtpicker" name="start_date" placeholder="Start date" value="{{date('d-m-Y',strtotime($earning->start_date))}}" type="text" autocomplete="off">
                                                </div>
                                                <div class="col-md-6 mg-t-10">
                                                    <input class="form-control dtpicker" name="end_date" placeholder="End date" value="{{date('d-m-Y',strtotime($earning->end_date))}}" type="text" autocomplete="off">
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