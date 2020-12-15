@extends('layouts.master')

@section('content')

        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('/roster-search')}}" style="color:#6c757d; font-weight: bold">Search Roster</a></li>
                <li class="breadcrumb-item active"><a href="{{url('/roster-employee/update/'.$r_employee->id)}}" style="color:#6c757d;">Update</a></li>
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
                            <h4 class="card-title mg-b-0">Update Roster Employee</h4>
                        </div>
                        <div class="col-md-6 text-right"></div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="card">
								<div class="card-body">
                                    <form method="POST" action="{{url('roster-employee/update/'.$r_employee->id)}}" enctype="multipart/form-data">
                                        {{ csrf_field() }}

                                        <div class="pd-30 pd-sm-40 bg-gray-200">
                                            <div class="row row-xs">
                                                <div class="col-md-4 mg-t-10">
                                                    <input class="form-control dtpicker" name="date" placeholder="Date" value="{{date('d-m-Y',strtotime($r_employee->date))}}" type="text" autocomplete="off" required>
                                                </div>
                                                <div class="col-md-4 mg-t-10">
                                                    <select name="shift_id" class="form-control select2-no-search" required>
                                                        <option label="Choose Shift"></option>
                                                        @foreach($shifts as $shift)
                                                            <option value="{{$shift->id}}" @if($r_employee->shift_id == $shift->id) selected @endif>{{$shift->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4 mg-t-10">
                                                    <select name="day_off" class="form-control select2-no-search" required>
                                                        <option label="Day Off"></option>
                                                        <option value="1" @if($r_employee->day_off == "1") selected @endif>Yes</option>
                                                        <option value="0" @if($r_employee->day_off == "0") selected @endif>No</option>
                                                    </select>
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