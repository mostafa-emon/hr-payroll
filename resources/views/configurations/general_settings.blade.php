@extends('layouts.master')

@section('content')

        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{url('/general-settings')}}" style="color:#6c757d;">General Settings</a></li>
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

                    @if(session()->has('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session()->get('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6" style="padding-top:5px">
                            <h4 class="card-title mg-b-0">General Settings</h4>
                        </div>
                        <div class="col-md-6 text-right"></div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="card">
								<div class="card-body">
                                    <form method="POST" action="{{url('general-settings/update')}}">
                                        {{ csrf_field() }}

                                        <div class="pd-30 pd-sm-40 bg-gray-200">
                                            <div class="form-group row">
                                                <label for="amount_in_word" class="col-form-label col-md-3">Amount In Word:</label>
                                                <select class="form-control select2-no-search col-md-9 pa" name="amount_in_word">
                                                    <option value="Crore-Lac-Thousand" @if(isset($settings) && $settings->amount_in_word == "Crore-Lac-Thousand") selected @endif>Crore-Lac-Thousand</option>
                                                    <option value="Crore-Lakh-Thousand" @if(isset($settings) && $settings->amount_in_word == "Crore-Lakh-Thousand") selected @endif>Crore-Lakh-Thousand</option>
                                                    <option value="Billion-Million-Thousand" @if(isset($settings) && $settings->amount_in_word == "Billion-Million-Thousand") selected @endif>Billion-Million-Thousand</option>
                                                </select>
                                            </div>
                                            <div class="form-group row mg-t-10">
                                                <label for="date_format" class="col-form-label col-md-3">Date Format:</label>
                                                <select class="form-control select2-no-search col-md-9 pa" name="date_format">
                                                    <option value="DD-MM-YYYY" @if(isset($settings) && $settings->date_format == "DD-MM-YYYY") selected @endif>DD-MM-YYYY (Ex: 21-10-2019)</option>
                                                    <option value="MM-DD-YYYY" @if(isset($settings) && $settings->date_format == "MM-DD-YYYY") selected @endif>MM-DD-YYYY (Ex: 10-21-2019)</option>
                                                    <option value="YYYY/MM/DD" @if(isset($settings) && $settings->date_format == "YYYY/MM/DD") selected @endif>YYYY/MM/DD (Ex: 2019/10/21)</option>
                                                    <option value="DD-MMM-YY" @if(isset($settings) && $settings->date_format == "DD-MMM-YY") selected @endif>DD-MMM-YY (Ex: 21-Oct-19)</option>
                                                </select>
                                            </div>
                                            <div class="form-group row mg-t-10">
                                                <label for="date_format" class="col-form-label col-md-3">Tax Challan Code:</label>
                                                <input type="text" name="tax_chalan_code" placeholder="Enter Code" class="form-control col-md-9 pa" value="@isset($settings){{$settings->tax_chalan_code}}@endisset">
                                            </div>
                                            <div class="form-group row mg-t-10">
                                                <label for="provident_fund_registered" class="col-form-label col-md-3" class="ckbox">Provident Fund is registered?:</label>
                                                <input type="checkbox" name="provident_fund_registered" style="height:25px;margin-left:-25px;margin-top:3px;" class="col-md-1 pa" value="1" @if(isset($settings) && $settings->provident_fund_registered == 1) checked @endif>
                                            </div>
                                        </div>

                                        <div class="row pd-t-15">
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