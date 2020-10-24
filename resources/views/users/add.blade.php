@extends('layouts.master')

@section('content')

        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('/user')}}" style="color:#6c757d; font-weight: bold">User</a></li>
                <li class="breadcrumb-item active"><a href="{{url('/user/add')}}" style="color:#6c757d;">Add</a></li>
            </ol>
            </div>
        </div>

    <div class="row row-sm">

        <!--div-->
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    @if(session()->has('message'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session()->get('message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-6" style="padding-top:5px">
                            <h4 class="card-title mg-b-0">Add User</h4>
                        </div>
                        <div class="col-md-6 text-right"></div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="card">
								<div class="card-body">
                                    <form method="POST" action="{{url('user/add')}}" enctype="multipart/form-data">
                                        {{ csrf_field() }}

                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <div>
                                                    <img id="avatar" src="{{ asset('assets/img/users.png') }}" style="cursor: pointer;" width="85" height="85" alt="avatar" onclick="document.getElementById('imgInp').click()" style="cursor:pointer;padding-left:10px"/>
                                                </div>
                                                <input class="collapse" type="file" name="avatar" id="imgInp" onchange="preview_image(event)"/>
                                            </div>
                                        </div>

                                        <div class="pd-30 pd-sm-40 bg-gray-200">
                                            <div class="row row-xs">
                                                <div class="col-md-6 mg-t-10">
                                                    <input class="form-control" type="text" name="name" placeholder="Enter Name" required>
                                                </div>
                                                <div class="col-md-6 mg-t-10">
                                                    <input class="form-control" type="text" name="email" placeholder="Enter Email Address" required>
                                                </div>
                                                <div class="col-md-6 mg-t-10">
                                                    <input class="form-control" type="password" name="password" placeholder="Enter Password" autocomplete="off" required>
                                                </div>
                                                <div class="col-md-6 mg-t-10">
                                                   <input class="form-control" type="password" name="confirm_password" placeholder="Re-Type Password" autocomplete="off" required>
                                                </div>
                                                <div class="col-md-12 mg-t-10">
                                                    <select id="roles" name="roles" class="form-control select2-no-search pa" required>
                                                        <option label="Select Role"></option>
                                                        <option value="CEO">CEO</option>
                                                        <option value="CTO">CTO</option>
                                                        <option value="Junior Engineer">Junior Engineer</option>
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
    function preview_image(event) {
      var reader = new FileReader();
      reader.onload = function()
      {
        var output = document.getElementById('avatar');
        output.src = reader.result;
      }
      reader.readAsDataURL(event.target.files[0]);
    }
  </script>

@endsection