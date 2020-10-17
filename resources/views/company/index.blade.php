@extends('layouts.master')

@section('content')

        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{url('company')}}" style="color:#6c757d;">Company</a></li>
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
                        <h4 class="card-title mg-b-0">Company</h4>
                      </div>
                        <div class="col-md-6 text-right"></div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="card">
								<div class="card-body">
                  <form method="POST" action="{{ url('company/update') }}" enctype="multipart/form-data">
                      {{ csrf_field() }}
                      <div class="form-group">
                          <div style="float-center;" class="mg-b-10">
                            @if(isset($info) && $info->logo != "")
                              <img id="avatar" src="{{ asset('storage/'.$info->logo) }}" width="100" height="100" alt="avatar" onclick="document.getElementById('imgInp').click()" style="cursor:pointer;padding-left:10px"/>
                            @else
                              <img id="avatar" src="{{ asset('assets/img/447x413.jpg') }}" width="100" height="100" alt="avatar" onclick="document.getElementById('imgInp').click()" style="cursor:pointer;padding-left:10px"/>
                            @endif
                          </div>
                          <input class="collapse" type="file" name="logo" id="imgInp" width="100" height="100" onchange="preview_image(event)"/>
                      </div>
                      <div class="pd-30 pd-sm-40 bg-gray-200">
                          <div class="row row-xs">
                            <div class="col-md-4">
                              <input id="name" type="text" name="name" placeholder="Company Name" class="form-control" value="@isset($info->name){{$info->name}}@endisset" required>
                            </div>

                            <div class="col-md-4">
                              <input id="email" type="text" name="email" placeholder="Email Address" class="form-control" value="@isset($info->email){{$info->email}}@endisset">
                            </div>

                            <div class="col-md-4">
                              <input id="phone" type="text" name="phone" placeholder="Phone Number" class="form-control" value="@isset($info->phone){{$info->phone}}@endisset">
                            </div>

                            <div class="col-md-4 mg-t-10">
                              <input id="address" type="text" name="address" placeholder="Address" class="form-control" value="@isset($info->address){{$info->address}}@endisset">
                            </div>

                            <div class="col-md-4 mg-t-10">
                              <input id="tin" type="text" name="tin" placeholder="Tin Number" class="form-control" value="@isset($info->tin){{$info->tin}}@endisset">
                            </div>

                            <div class="col-md-4 mg-t-10">
                              <input id="vat_reg_no" type="text" name="vat_reg_no" placeholder="VAT Registration Number" class="form-control" value="@isset($info->vat_reg_no){{$info->vat_reg_no}}@endisset">
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