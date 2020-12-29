@extends('layouts.master')

@section('content')

        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{url('/attendance-policy')}}" style="color:#6c757d;">Attendance Policy</a></li>
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
                            <h4 class="card-title mg-b-0">Update Attendance Policy</h4>
                        </div>
                        <div class="col-md-6 text-right"></div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="card">
								<div class="card-body">
                                    <form method="POST" action="{{url('attendance-policy')}}" enctype="multipart/form-data">
                                        {{ csrf_field() }}

                                        <div class="pd-30 pd-sm-40 bg-gray-200">
                                            <div class="row row-xs">

                                                <label for="name" style="margin-left:-5px;" class="col-form-label col-md-12">Duty Time for Non-Roster Employees:</label>
                                                <div class="col-md-4 mg-t-8">
                                                    <input class="form-control" placeholder="10:00" name="start_time" type="text" value="@if($policy != ""){{$policy->start_time}} @endif" required/>
                                                </div>
                                                <div class="col-md-2 mg-t-8">
                                                    <select id="account_1type" name="start_time_meridiem" class="form-control select2-no-search col-md-12 pa" required>
                                                        <option value="0" @if($policy !='') ( @if($policy->start_time_meridiem == "0") selected @endif ) @endif>AM</option>
                                                        <option value="1" @if($policy !='') ( @if($policy->start_time_meridiem == "1") selected @endif ) @endif>PM</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 mg-t-8">
                                                    <input class="form-control" name="end_time" placeholder="06:00" type="text" value="@if($policy != ""){{$policy->end_time}} @endif" required>
                                                </div>
                                                <div class="col-md-2 mg-t-8">
                                                    <select id="account_1type" name="end_time_meridiem" class="form-control select2-no-search col-md-12 pa" required>
                                                        <option value="0" @if($policy !='') ( @if($policy->end_time_meridiem == "0") selected @endif ) @endif>AM</option>
                                                        <option value="1" @if($policy !='') ( @if($policy->end_time_meridiem == "1") selected @endif ) @endif>PM</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-6 mg-t-10">
                                                    <label for="name" class="col-form-label">Activate Late Policy:</label>
                                                    <select id="account_1type" name="late_policy" class="form-control select2-no-search col-md-12 pa" required>
                                                        <option value="1" @if($policy !='') ( @if($policy->late_policy == "1") selected @endif ) @endif>Yes</option>
                                                        <option value="0" @if($policy !='') ( @if($policy->late_policy == "0") selected @endif ) @endif>No</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mg-t-10">
                                                    <label for="name" class="col-form-label">Grace Time for Late Mark:</label>
                                                    <input class="form-control" name="late_mark" placeholder="Minutes" type="text" value="@if($policy !=''){{$policy->late_mark}} @endif" required>
                                                </div>

                                                <div class="col-md-6 mg-t-10">
                                                    <label for="name" class="col-form-label">Activate Late Absent Policy:</label>
                                                    <select id="account_1type" name="late_absent_policy" class="form-control select2-no-search col-md-12 pa" required>
                                                        <option value="1" @if($policy !='') ( @if($policy->late_absent_policy == "1") selected @endif ) @endif>Yes</option>
                                                        <option value="0" @if($policy !='') ( @if($policy->late_absent_policy == "0") selected @endif ) @endif>No</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mg-t-10">
                                                    <label for="name" class="col-form-label">Mark as 1 Day Absent for:</label>
                                                    <input class="form-control" name="marks_absent_for" placeholder="Days Late in a month" type="text" value="@if($policy !=''){{$policy->marks_absent_for}} @endif" required>
                                                </div>

                                                <div class="col-md-6 mg-t-10">
                                                    <label for="name" class="col-form-label">Use OT Round off Slab:</label>
                                                    <select id="account_1type" name="use_ot_round" onclick="hideShowElement(this.value)" class="form-control select2-no-search col-md-12 pa" required>
                                                        <option value="1" @if($policy !='') ( @if($policy->use_ot_round == "1") selected @endif ) @endif>Yes</option>
                                                        <option value="0" @if($policy !='') ( @if($policy->use_ot_round == "0") selected @endif ) @endif>No</option>
                                                    </select>
                                                </div>

                                                <div @if($policy !='') ( @if($policy->use_ot_round == "0") style="display:none;" @endif ) @endif id="ot_round_slab" class="col-md-6 mg-t-10">
                                                    <label for="name" class="col-form-label">OT Round off Slab:</label>
                                                    <input class="form-control" name="ot_round" placeholder="Minutes" value="@if($policy !=''){{$policy->ot_round}} @endif" type="text">
                                                </div>

                                                <div class="col-md-6 mg-t-10">
                                                    <label for="name" class="col-form-label">Minimum time need to stay for considering as OT:</label>
                                                    <input class="form-control" name="time_for_ot" placeholder="Minutes" type="text" value="@if($policy !=''){{$policy->time_for_ot}} @endif" required>
                                                </div>
                                                <div class="col-md-6 mg-t-10">
                                                    <label for="name" class="col-form-label">Mark OverTime if Work In Holiday:</label>
                                                    <select id="account_1type" name="mark_overtime" class="form-control select2-no-search col-md-12 pa" required>
                                                        <option value="1" @if($policy !='') ( @if($policy->mark_overtime == "1") selected @endif ) @endif>Yes</option>
                                                        <option value="0" @if($policy !='') ( @if($policy->mark_overtime == "0") selected @endif ) @endif>No</option>
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

    <script>

        function hideShowElement(value) {
            if(value == "1") {
                $('#ot_round_slab').show();
            }else{
                $('#ot_round_slab').hide();
            }
        }
    </script>

@endsection