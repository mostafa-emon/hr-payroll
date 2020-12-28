@extends('layouts.master')

@section('content')

        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('/company-pf')}}" style="color:#6c757d; font-weight: bold">Company PF</a></li>
                <li class="breadcrumb-item active"><a href="{{url('/company-pf/update/'.$company_pf->id)}}" style="color:#6c757d;">Update</a></li>
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
                            <h4 class="card-title mg-b-0">Update Company PF</h4>
                        </div>
                        <div class="col-md-6 text-right"></div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="card">
								<div class="card-body">
                                    <form method="POST" action="{{url('company-pf/update/'.$company_pf->id)}}">
                                        {{ csrf_field() }}

                                        <div class="pd-30 pd-sm-40 bg-gray-200">
                                            <div class="row row-xs">
                                                <div class="col-md-3 mg-t-10">
                                                    <select name="currency_id" class="form-control select2-no-search" required>
                                                        <option label="Choose Currency"></option>
                                                        @foreach($currencies as $currency)
                                                            <option value="{{$currency->id}}" @if($company_pf->currency_id == $currency->id) selected @endif>{{$currency->currency_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-3 mg-t-10">
                                                    <select name="month" class="form-control select2-no-search" required>
                                                        <option label="Month"></option>
                                                        <option value="January" @if($company_pf->month == "January") selected @endif>January</option>
                                                        <option value="February" @if($company_pf->month == "February") selected @endif>February</option>
                                                        <option value="March" @if($company_pf->month == "March") selected @endif>March</option>
                                                        <option value="April" @if($company_pf->month == "April") selected @endif>April</option>
                                                        <option value="May" @if($company_pf->month == "May") selected @endif>May</option>
                                                        <option value="June" @if($company_pf->month == "June") selected @endif>June</option>
                                                        <option value="July" @if($company_pf->month == "July") selected @endif>July</option>
                                                        <option value="August" @if($company_pf->month == "August") selected @endif>August</option>
                                                        <option value="September" @if($company_pf->month == "September") selected @endif>September</option>
                                                        <option value="October" @if($company_pf->month == "October") selected @endif>October</option>
                                                        <option value="November" @if($company_pf->month == "November") selected @endif>November</option>
                                                        <option value="December" @if($company_pf->month == "December") selected @endif>December</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3 mg-t-10">
                                                    <input type="text" name="year" class="form-control" placeholder="Year; Ex:2010" value="{{$company_pf->year}}" required/>
                                                </div>
                                                <div class="col-md-3 mg-t-10">
                                                    <input type="text" name="amount" class="form-control" placeholder="Amount" value="{{$company_pf->amount}}" required/>
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