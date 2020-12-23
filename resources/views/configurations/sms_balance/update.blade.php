@extends('layouts.master')

@section('content')

        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('/sms-balance')}}" style="color:#6c757d; font-weight: bold">SMS Balance</a></li>
                <li class="breadcrumb-item active"><a style="color:#6c757d;">Update</a></li>
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
                        <h4 class="card-title mg-b-0">Update SMS Balance</h4>
                      </div>
                        <div class="col-md-6 text-right"></div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="card">
								<div class="card-body">
                                    <form method="POST" action="{{url('sms-balance/update/'.$sms_setup->id)}}">
                                        {{ csrf_field() }}
                                        <div class="pd-30 pd-sm-40 bg-gray-200">
                                            <div class="row row-xs align-items-center mg-b-20">
                                                <div class="col-md-2">
                                                    <label class="form-label mg-b-0" style="font-size:16px;font-weight:bold;">SMS Balance:</label>
                                                </div>
                                                <div class="col-md-10 mg-t-5 mg-md-t-0">
                                                    <input type="text" class="form-control" name="sms_balance" value="{{$sms_setup->sms_balance}}" placeholder="SMS Balance" required>
                                                </div>
                                            </div>
                                            <div class="row row-xs align-items-center mg-b-20">
                                                <div class="col-md-2">
                                                    <label class="form-label mg-b-0" style="font-size:16px;font-weight:bold;">English:</label>
                                                </div>
                                                <div class="col-md-2 mg-t-5 mg-md-t-0">
                                                    <input type="text" class="form-control" name="eng_character_1" value="{{$sms_setup->eng_character_1}}" placeholder="Character If 1 SMS" required>
                                                </div>
                                                <div class="col-md-2 mg-t-5 mg-md-t-0">
                                                    <input type="text" class="form-control" name="eng_character_2" value="{{$sms_setup->eng_character_2}}" placeholder="Character If 2 SMS">
                                                </div>
                                                <div class="col-md-2 mg-t-5 mg-md-t-0">
                                                    <input type="text" class="form-control" name="eng_character_3" value="{{$sms_setup->eng_character_3}}" placeholder="Character If 3 SMS">
                                                </div>
                                                <div class="col-md-2 mg-t-5 mg-md-t-0">
                                                    <input type="text" class="form-control" name="eng_character_4" value="{{$sms_setup->eng_character_4}}" placeholder="Character If 4 SMS">
                                                </div>
                                                <div class="col-md-2 mg-t-5 mg-md-t-0">
                                                    <input type="text" class="form-control" name="eng_character_5" value="{{$sms_setup->eng_character_5}}" placeholder="Character If 5 SMS">
                                                </div>
                                            </div>
                                            <div class="row row-xs align-items-center mg-b-20">
                                                <div class="col-md-2">
                                                    <label class="form-label mg-b-0" style="font-size:16px;font-weight:bold;">Other Language:</label>
                                                </div>
                                                <div class="col-md-2 mg-t-5 mg-md-t-0">
                                                    <input type="text" class="form-control" name="other_character_1" value="{{$sms_setup->other_character_1}}" placeholder="Character If 1 SMS" required>
                                                </div>
                                                <div class="col-md-2 mg-t-5 mg-md-t-0">
                                                    <input type="text" class="form-control" name="other_character_2" value="{{$sms_setup->other_character_2}}" placeholder="Character If 2 SMS">
                                                </div>
                                                <div class="col-md-2 mg-t-5 mg-md-t-0">
                                                    <input type="text" class="form-control" name="other_character_3" value="{{$sms_setup->other_character_3}}" placeholder="Character If 3 SMS">
                                                </div>
                                                <div class="col-md-2 mg-t-5 mg-md-t-0">
                                                    <input type="text" class="form-control" name="other_character_4" value="{{$sms_setup->other_character_4}}" placeholder="Character If 4 SMS">
                                                </div>
                                                <div class="col-md-2 mg-t-5 mg-md-t-0">
                                                    <input type="text" class="form-control" name="other_character_5" value="{{$sms_setup->other_character_5}}" placeholder="Character If 5 SMS">
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