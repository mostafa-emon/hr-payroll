@extends('layouts.master')

@section('content')

  <div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
      <a class="breadcrumb-item" href="{{ url('/') }}">Home</a>
      <a class="breadcrumb-item" href="{{ url('/user') }}">User</a>
      <span class="breadcrumb-item active">Add</span>
    </nav>
  </div>

  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <h4 class="tx-gray-800 mg-b-5">Add User</h4>
  </div>

  <form action="{{ url('user/add') }}" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="br-pagebody">
      <div class="br-section-wrapper">
        <div class="form-layout form-layout-2">
          <div class="row no-gutters">

            <div class="col-md-12">
              <div class="form-group">
                  <div class="mg-b-10">
                    <img class="pointer" id="avatar" src="{{ asset('img/user.png') }}" width="120" alt="avatar" onclick="document.getElementById('imgInp').click()"/>
                  </div>
                  <a onclick="document.getElementById('imgInp').click()" class="pointer wd-120 btn btn-secondary btn-sm text-white">Choose</a>
                  <input class="collapse" type="file" name="avatar" id="imgInp" onchange="preview_image(event)" />
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group bd-t-0-force">
                <label class="form-control-label">Name: <span class="tx-danger">*</span></label>
                <input class="form-control" type="text" name="name" placeholder="Enter Name">
              </div>
            </div>

            <div class="col-md-6 mg-t--1 mg-md-t-0">
              <div class="form-group mg-md-l--1 bd-t-0-force">
                <label class="form-control-label">Designation:</label>
                <input class="form-control" type="text" name="designation" placeholder="Enter Desination">
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group bd-t-0-force">
                <label class="form-control-label">Email address: <span class="tx-danger">*</span></label>
                <input class="form-control" type="text" name="email" placeholder="Enter Email Address">
              </div>
            </div>

            <div class="col-md-6 mg-t--1 mg-md-t-0">
              <div class="form-group bd-t-0-force mg-md-l--1">
                <label class="form-control-label">Password: <span class="tx-danger">*</span></label>
                <input class="form-control" type="text" name="password" placeholder="Enter Password">
              </div>
            </div>

            <div class="col-md-12 mg-t--1 mg-md-t-0">
              <div class="form-group bd-t-0-force">
                <label class="form-control-label mg-b-0-force">Roles: <span class="tx-danger">*</span></label>
                <select name="roles" class="form-control mg-l--4" required>
                  <option selected disabled>Select Role</option>
                      @foreach($roles as $role)
                          <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                      @endforeach
                </select>
              </div>
            </div>

          </div>

          <div class="form-layout-footer bd pd-20 bd-t-0">
            <input type="submit" value="Submit" class="btn btn-info pointer"/>
          </div>

        </div>
      </div>
    </div>
  </form>

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