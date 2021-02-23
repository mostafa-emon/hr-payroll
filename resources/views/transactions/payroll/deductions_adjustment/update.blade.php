@extends('layouts.master')

@section('content')

        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('/deductions-adjustment')}}" style="color:#6c757d; font-weight: bold">Deductions Adjustment</a></li>
                <li class="breadcrumb-item active"><a href="{{url('deductions-adjustment-update/'.$deduction->id)}}" style="color:#6c757d;">Update</a></li>
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
                            <h4 class="card-title mg-b-0">Update Deduction Adjustment</h4>
                        </div>
                        <div class="col-md-6 text-right"></div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="card">
								<div class="card-body">
                                    <form method="POST" action="{{url('deductions-adjustment-update/'.$deduction->id)}}" enctype="multipart/form-data">
                                        {{ csrf_field() }}

                                        <div>
                                            <div class="row row-xs">
                                                <div class="col-md-4 mg-t-10">
                                                    <input class="form-control" placeholder="Name" value="{{employee_name_by_increment_id($deduction->employee_id)}}" type="text" readonly>
                                                </div>
                                                <div class="col-md-4 mg-t-10">
                                                    <select name="month" class="form-control select2-no-search" required>
                                                        <option label="Month"></option>
                                                        <option value="January" @if($deduction->month == "January") selected @endif>January</option>
                                                        <option value="February" @if($deduction->month == "February") selected @endif>February</option>
                                                        <option value="March" @if($deduction->month == "March") selected @endif>March</option>
                                                        <option value="April" @if($deduction->month == "April") selected @endif>April</option>
                                                        <option value="May" @if($deduction->month == "May") selected @endif>May</option>
                                                        <option value="June" @if($deduction->month == "June") selected @endif>June</option>
                                                        <option value="July" @if($deduction->month == "July") selected @endif>July</option>
                                                        <option value="August" @if($deduction->month == "August") selected @endif>August</option>
                                                        <option value="September" @if($deduction->month == "September") selected @endif>September</option>
                                                        <option value="October" @if($deduction->month == "October") selected @endif>October</option>
                                                        <option value="November" @if($deduction->month == "November") selected @endif>November</option>
                                                        <option value="December" @if($deduction->month == "December") selected @endif>December</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 mg-t-10">
                                                    <input class="form-control" placeholder="Year" name="year" value="{{$deduction->year}}" type="text" required>
                                                </div>
                                                <div class="col-md-4 mg-t-10">
                                                    <input type="text" name="amount" class="form-control" placeholder="Amount" value="{{$deduction->amount}}" required/>
                                                </div>
                                                <div class="col-md-4 mg-t-10">
                                                    <select name="type" class="form-control select2-no-search" required>
                                                        <option label="Type"></option>
                                                        <option Value="Increase" @if($deduction->type == "Increase") selected @endif>Salary Increase</option>
                                                        <option Value="Decrease" @if($deduction->type == "Decrease") selected @endif>Salary Decrease</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 mg-t-10">
                                                    <select name="status" class="form-control select2-no-search">
                                                        <option label="Status"></option>
                                                        <option Value="1" @if($deduction->status == "1") selected @endif>Active</option>
                                                        <option Value="0" @if($deduction->status == "0") selected @endif>Inactive</option>
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