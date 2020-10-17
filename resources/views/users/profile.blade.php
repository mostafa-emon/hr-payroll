@extends('layouts.master')

@section('content')

    <div class="row mb-2">
        <div class="col-sm-6"></div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{url('user/profile/'.Auth::user()->id)}}" style="color:#6c757d;">Profile</a></li>
        </ol>
        </div>
    </div>

    <!-- row -->
    <div class="row row-sm">

        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    @if(session()->has('message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session()->get('message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                    @endif

                    @if(session()->has('message_with_error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session()->get('message_with_error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                    @endif
                    
                <form class="form-horizontal" action="{{ url('user/profile/'.Auth::user()->id) }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-3">
                            <div class="pl-0">
                                <div class="main-profile-overview">
                                    <div class="main-img-user profile-user">
                                        @if($users->avatar != "")
                                            <img class="pointer" id="avatar" src="{{ asset('storage/'.$users->avatar)}}" alt="avatar" onclick="document.getElementById('imgInp').click()"/>
                                            {{--<img class="pointer" id="avatar" src="{{ Config::get('app.admin_url').$users->avatar}}" alt="avatar" onclick="document.getElementById('imgInp').click()"/>--}}
                                        @else
                                            <img class="pointer" id="avatar" src="{{ asset('assets/img/users.png') }}"alt="avatar" onclick="document.getElementById('imgInp').click()"/>
                                        @endif
                                        <a class="fas fa-camera profile-edit" style="cursor: pointer;" class="pointer" id="avatar" alt="avatar" onclick="document.getElementById('imgInp').click()"></a>
                                        <input class="collapse" type="file" name="avatar" id="imgInp" onchange="preview_image(event)" />
                                    </div>
                                    <div class="d-flex justify-content-between mg-b-20">
                                        <div>
                                            <h5 class="main-profile-name">{{$users->name}}</h5>
                                            <p class="main-profile-name-text">{{$users->designation}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <label class="form-label">Name</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" style="margin-top:-10px;" name="name" class="form-control" placeholder="Enter Name" value="{{$users->name}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <label class="form-label">Designation</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" style="margin-top:-10px;" name="designation" class="form-control" placeholder="Designation" value="{{$users->designation}}">
                                    </div>
                                </div>
                                {{--<div class="form-group row">
                                    <div class="col-md-3">
                                        <label class="form-label">Phone Number</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" style="margin-top:-10px;" name="phone" class="form-control" placeholder="Phone Number" value="{{$users->phone}}">
                                    </div>
                                </div>--}}
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <label class="form-label">Email Address</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" style="margin-top:-10px;" name="email" class="form-control" placeholder="Email Address" value="{{$users->email}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <label class="form-label">Password</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" style="margin-top:-10px;"  name="password" class="form-control" placeholder="Password" autocomplete="off">
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Update Profile</button>
                    </div>
                </form>
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