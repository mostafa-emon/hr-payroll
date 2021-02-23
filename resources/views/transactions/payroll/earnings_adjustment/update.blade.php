@extends('layouts.master')

@section('content')

        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('/earnings-adjustment')}}" style="color:#6c757d; font-weight: bold">Earning Adjustment</a></li>
                <li class="breadcrumb-item active"><a href="{{url('earnings-adjustment-update/'.$earning->id)}}" style="color:#6c757d;">Update</a></li>
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
                            <h4 class="card-title mg-b-0">Update Earning Adjustment</h4>
                        </div>
                        <div class="col-md-6 text-right"></div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="card">
								<div class="card-body">
                                    <form method="POST" action="{{url('earnings-adjustment-update/'.$earning->id)}}" enctype="multipart/form-data">
                                        {{ csrf_field() }}

                                        <div>
                                            <div class="row row-xs">
                                                <div class="col-md-4 mg-t-10">
                                                    <input class="form-control" placeholder="Name" value="{{employee_name_by_increment_id($earning->employee_id)}}" type="text" readonly>
                                                </div>
                                                <div class="col-md-4 mg-t-10">
                                                    <select name="month" class="form-control select2-no-search" required>
                                                        <option label="Month"></option>
                                                        <option value="January" @if($earning->month == "January") selected @endif>January</option>
                                                        <option value="February" @if($earning->month == "February") selected @endif>February</option>
                                                        <option value="March" @if($earning->month == "March") selected @endif>March</option>
                                                        <option value="April" @if($earning->month == "April") selected @endif>April</option>
                                                        <option value="May" @if($earning->month == "May") selected @endif>May</option>
                                                        <option value="June" @if($earning->month == "June") selected @endif>June</option>
                                                        <option value="July" @if($earning->month == "July") selected @endif>July</option>
                                                        <option value="August" @if($earning->month == "August") selected @endif>August</option>
                                                        <option value="September" @if($earning->month == "September") selected @endif>September</option>
                                                        <option value="October" @if($earning->month == "October") selected @endif>October</option>
                                                        <option value="November" @if($earning->month == "November") selected @endif>November</option>
                                                        <option value="December" @if($earning->month == "December") selected @endif>December</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 mg-t-10">
                                                    <input class="form-control" placeholder="Year" name="year" value="{{$earning->year}}" type="text" required>
                                                </div>
                                                <div class="col-md-4 mg-t-10">
                                                    <input type="text" name="amount" class="form-control" placeholder="Amount" value="{{$earning->amount}}" required/>
                                                </div>
                                                <div class="col-md-4 mg-t-10">
                                                    <select name="type" class="form-control select2-no-search" required>
                                                        <option label="Type"></option>
                                                        <option Value="Increase" @if($earning->type == "Increase") selected @endif>Salary Increase</option>
                                                        <option Value="Decrease" @if($earning->type == "Decrease") selected @endif>Salary Decrease</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 mg-t-10">
                                                    <select name="status" class="form-control select2-no-search">
                                                        <option label="Status"></option>
                                                        <option Value="1" @if($earning->status == "1") selected @endif>Active</option>
                                                        <option Value="0" @if($earning->status == "0") selected @endif>Inactive</option>
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