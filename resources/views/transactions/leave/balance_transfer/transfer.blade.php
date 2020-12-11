@extends('layouts.master')

@section('content')

        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('/leave-balance-transfer')}}" style="color:#6c757d; font-weight: bold">Leave Balance</a></li>
                <li class="breadcrumb-item active"><a href="{{url('/transfer-leave-balance')}}" style="color:#6c757d;">Transfer</a></li>
            </ol>
            </div>
        </div>

    <div class="row row-sm">

        <!--div-->
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">

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
                            <h4 class="card-title mg-b-0">Transfer Leave Balance</h4>
                        </div>
                        <div class="col-md-6 text-right"></div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="card">
								<div class="card-body">
                                    <form method="POST" action="{{url('leave-request/add')}}" enctype="multipart/form-data">
                                        {{ csrf_field() }}

                                        <div>
                                            <div class="row pd-t-10">
                                                <div class="col-md-4 remove-space">
                                                    <input type="text" class="form-control" name="applicable_year" placeholder="Applicable Year" value={{date('Y')}}>
                                                </div>
                                            </div>
                                            @foreach($leave_infos as $leave_info)
                                            <div class="row pd-t-10">
                                                <div class="col-md-4 remove-space">
                                                    <select class="form-control" name="leave_type_id[]" disabled>
                                                        <option value="" label>Leave Type</option>
                                                        @foreach($leave_types as $leave_type)
                                                            <option value="{{$leave_type->id}}" @if($leave_type->id == $leave_info->leave_type_id) selected @endif>{{$leave_type->leave_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            
                                                <div class="col-md-4 remove-space">
                                                    <input type="text" class="form-control" name="balance_left[]" placeholder="Balance Left" value={{leave_balance_left($leave_info->id,$employee->id)}}>
                                                </div>
                                
                                                <div class="col-md-4 remove-space">
                                                    <input type="text" class="form-control" name="max_carry_forward[]" placeholder="Max C.F" value="{{$leave_info->max_carry_forward}}">
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>

                                        <div class="row pd-t-30">
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