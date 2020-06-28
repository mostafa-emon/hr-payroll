@extends('layouts.master')

@section('content')

<div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
      <a class="breadcrumb-item" href="{{ url('/') }}">Home</a>
      <a class="breadcrumb-item" href="{{ url('/mail-setup') }}">Email</a>
    </nav>
  </div>

  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <h4 class="tx-gray-800 mg-b-5">Email</h4>
  </div>

  <form action="{{ url('mail-setup/update') }}" method="POST" enctype="multipart/form-data">
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

            <div class="col-md-4">
              <div class="form-group">
                <label class="form-control-label">Mail Driver: <span class="tx-danger">*</span></label>
                <input class="form-control" type="text" name="mail_driver" placeholder="Mail Driver Name" value="{{$emails->mail_driver}}" required>
              </div>
            </div>

            <div class="col-md-4 mg-t--1 mg-md-t-0">
              <div class="form-group mg-md-l--1">
                <label class="form-control-label">Host: <span class="tx-danger">*</span></label>
                <input class="form-control" type="text" name="host_name" placeholder="Host Name" value="{{$emails->host_name}}" required>
              </div>
            </div>

            <div class="col-md-4 mg-t--1 mg-md-t-0">
              <div class="form-group mg-md-l--1">
                <label class="form-control-label">Port: <span class="tx-danger">*</span></label>
                <input class="form-control" type="text" name="port_name" placeholder="Port Name" value="{{$emails->port_name}}" required>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group bd-t-0-force">
                <label class="form-control-label">User Name:</label>
                <input class="form-control" type="text" name="user_name" placeholder="User Name" value="{{$emails->user_name}}">
              </div>
            </div>
            
            <div class="col-md-4">
              <div class="form-group bd-t-0-force mg-md-l--1">
                <label class="form-control-label">Password:</label>
                <input class="form-control" type="text" name="password" placeholder="Enter Password" value="{{$emails->password}}">
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group bd-t-0-force mg-md-l--1">
                <label class="form-control-label">Encryption::</label>
                <input class="form-control" type="text" name="encryption" placeholder="tsl/ssl" value="{{$emails->encryption}}">
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group bd-t-0-force">
                <label class="form-control-label">From Address:</label>
                <input class="form-control" type="text" name="from_address" placeholder="From Address" value="{{$emails->from_address}}">
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="form-group bd-t-0-force mg-md-l--1">
                <label class="form-control-label">From Name:</label>
                <input class="form-control" type="text" name="from_name" placeholder="From Name" value="{{$emails->from_name}}">
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group bd-t-0-force">
                <label class="form-control-label">Email To:</label>
                <input class="form-control" type="text" name="address" placeholder="Email To">
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group bd-t-0-force mg-md-l--1">
                <label class="form-control-label">Subject:</label>
                <input class="form-control" type="text" name="address" placeholder="Subject">
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group bd-t-0-force mg-md-l--1">
                <label class="form-control-label">Message:</label>
                <textarea class="form-control" type="text" name="address" rows="5" placeholder="Start Typing......."></textarea>
                <input type="file" class="btn btn-light pointer"/>
              </div>
            </div>

          </div>

          <div class="form-layout-footer bd pd-20 bd-t-0">
            <input value="Send" class="btn btn-info pointer"/>
            <input type="submit" value="Save As Draft" class="btn btn-info pointer"/>
          </div>


        </div>
      </div>
    </div>
  </form>
  

@endsection