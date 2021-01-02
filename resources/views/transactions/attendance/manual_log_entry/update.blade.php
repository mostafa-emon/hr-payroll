@extends('layouts.master')

@section('content')

        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('/manual-log-entry')}}" style="color:#6c757d; font-weight: bold">Manual Log Entry</a></li>
                <li class="breadcrumb-item active"><a href="{{url('/manual-log-entry/update/'.$attendance->id)}}" style="color:#6c757d;">Update</a></li>
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
                            <h4 class="card-title mg-b-0">Manual Log Entry</h4>
                        </div>
                        <div class="col-md-6 text-right"></div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="card">
								<div class="card-body">
                                    <form method="POST" action="{{url('manual-log-entry/update-post/'.$attendance->id)}}">
                                        {{ csrf_field() }}

                                        <div class="pd-30 pd-sm-40 bg-gray-200">
                                            <div class="row row-xs">
                                                <div class="col-md-6 mg-t-10">
                                                    <input type="text" class="form-control" id="in_time" name="in_time" value="{{date('H:i:s',strtotime($attendance->in_time))}}" placeholder="In Time">
                                                </div>
                                                <div class="col-md-6 mg-t-10">
                                                    <input type="text" class="form-control" id="out_time" name="out_time" value="{{date('H:i:s',strtotime($attendance->out_time))}}" placeholder="Out Time">
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
        function get_employee() {
            var department_id = $('#department_id').val();
            var project_id = $('#project_id').val();
            var branch_id = $('#branch_id').val();

            var url = '/search-employee/'+department_id;
            if(project_id != "") { url = url +'/'+ project_id;} else { url = url + '/0';}
            if(branch_id != "") { url = url +'/'+ branch_id;} else { url = url + '/0';}

            $.ajax({
                type:'GET',
                url:url,
                success:function(data) {
                    console.log(data)
                    $('#employee_id').html('');
                    $('#employee_id').append('<option value="" selected>Choose Employee</option>');
                    $('#employee_id').append(data);
                }
            });
        }

    </script>

@endsection