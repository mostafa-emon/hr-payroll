@extends('layouts.master')

@section('content')

  <div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
      <a class="breadcrumb-item" href="{{ url('/') }}">Home</a>
      <a class="breadcrumb-item" href="{{ url('company-register') }}">Subscription Company</a>
    </nav>
  </div>

  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <h4 class="tx-gray-800 mg-b-5">Subscription</h4>
  </div>

  <form action="{{ url('company-register') }}" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="br-pagebody">
      <div class="br-section-wrapper">
        @if(session()->has('message'))
          <div class="alert alert-primary alert-dismissible fade show" role="alert">
            {{ session()->get('message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        @endif
        
        <div class="form-layout form-layout-2">
          <div class="row no-gutters">

            <div class="col-md-12">
              <div class="form-group">
                  <div class="mg-b-10">
                      @if(isset($info) && $info->logo != "")
                          <img class="pointer" id="logo" src="{{ asset('storage/'.$info->logo) }}" width="120" alt="logo" onclick="document.getElementById('imgInp').click()"/>
                      @else
                          <img class="pointer" id="logo" src="{{ asset('img/logo-placeholder.png') }}" width="120" alt="logo" onclick="document.getElementById('imgInp').click()"/>
                      @endif
                  </div>
                  <a onclick="document.getElementById('imgInp').click()" class="pointer wd-120 btn btn-secondary btn-sm text-white">Choose</a>
                  <input class="collapse" type="file" name="logo" id="imgInp" onchange="preview_image(event)" />
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group bd-t-0-force ">
                <label class="form-control-label">Name: <span class="tx-danger">*</span></label>
                <input id="name" type="text" name="name" placeholder="Company Name" class="form-control">
              </div>
            </div>

            <div class="col-md-4 mg-t--1 mg-md-t-0">
              <div class="form-group bd-t-0-force  mg-md-l--1">
                <label class="form-control-label">Email address:</label>
                <input id="email" type="text" name="email" placeholder="Email Address" class="form-control">
              </div>
            </div>

            <div class="col-md-4 mg-t--1 mg-md-t-0">
              <div class="form-group bd-t-0-force mg-md-l--1">
                <label class="form-control-label">Phone Number:</label>
                <input id="phone" type="text" name="phone" placeholder="Phone Number" class="form-control">
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group bd-t-0-force">
                <label class="form-control-label">Address:</label>
                <input id="address" type="text" name="address" placeholder="Address" class="form-control">
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group bd-t-0-force mg-md-l--1">
                <label class="form-control-label">TIN:</label>
                <input id="tin" type="text" name="tin" placeholder="Tin Number" class="form-control">
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group bd-t-0-force mg-md-l--1">
                <label class="form-control-label">VAT Registration Number:</label>
                <input id="vat_reg_no" type="text" name="vat_reg_no" placeholder="VAT Registration Number" class="form-control">
              </div>
            </div>

            <div class="col-md-4">
                <div class="form-group bd-t-0-force">
                  <label class="form-control-label">Login Email:</label>
                  <input id="login-email" type="text" name="login_email" placeholder="Login Email" class="form-control">
                </div>
              </div>
  
              <div class="col-md-4">
                <div class="form-group bd-t-0-force mg-md-l--1">
                  <label class="form-control-label">Login Password:</label>
                  <input id="login-password" type="text" name="login_password" placeholder="Login Password" class="form-control">
                </div>
              </div>
  
              <div class="col-md-4">
                <div class="form-group bd-t-0-force mg-md-l--1">
                  <label class="form-control-label">Subscription End Date:</label>
                  <input id="vat_reg_no" type="date" name="subscription_end_date" placeholder="Subscription End Date" class="form-control">
                </div>
              </div>

          </div>

          {{--@if(roles() != "" && in_array(1, json_decode(roles(),false)))--}}
          <div class="form-layout-footer bd pd-20 bd-t-0">
            <input type="submit" value="Update" class="btn btn-info pointer"/>
          </div>
          {{--@endif--}}
        </div>
      </div>
    </div>
  </form>

  <script>
    function preview_image(event) {
      var reader = new FileReader();
      reader.onload = function()
      {
        var output = document.getElementById('logo');
        output.src = reader.result;
      }
      reader.readAsDataURL(event.target.files[0]);
    }
  </script>
@endsection