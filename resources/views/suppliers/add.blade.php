@extends('layouts.master')

@section('content')

  <div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
      <a class="breadcrumb-item" href="{{ url('/') }}">Home</a>
      <a class="breadcrumb-item" href="{{ url('/supplier') }}">Supplier</a>
      <span class="breadcrumb-item active">Add</span>
    </nav>
  </div>

  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <h4 class="tx-gray-800 mg-b-5">Add Supplier</h4>
  </div>

  <form action="{{ url('supplier/add') }}" method="POST">
    {{ csrf_field() }}
    <div class="br-pagebody">
      <div class="br-section-wrapper">
        <div class="form-layout form-layout-2">
          <div class="row no-gutters">

            <div class="col-md-4">
              <div class="form-group">
                <label class="form-control-label">Name: <span class="tx-danger">*</span></label>
                <input class="form-control" type="text" name="name" placeholder="Enter Name">
              </div>
            </div>

            <div class="col-md-4 mg-t--1 mg-md-t-0">
              <div class="form-group mg-md-l--1">
                <label class="form-control-label">Email address: <span class="tx-danger">*</span></label>
                <input class="form-control" type="text" name="email" placeholder="Enter Email Address">
              </div>
            </div>

            <div class="col-md-4 mg-t--1 mg-md-t-0">
              <div class="form-group mg-md-l--1">
                <label class="form-control-label">Phone Number: <span class="tx-danger">*</span></label>
                <input class="form-control" type="text" name="phone" placeholder="Enter Phone Number">
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group bd-t-0-force">
                <label class="form-control-label">Cheque Name: <span class="tx-danger">*</span></label>
                <input class="form-control" type="text" name="cheque_name" placeholder="Enter Cheque Name">
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group bd-t-0-force mg-md-l--1">
                <label class="form-control-label">Address: <span class="tx-danger">*</span></label>
                <input class="form-control" type="text" name="address" placeholder="Enter Address">
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group mg-md-l--1 bd-t-0-force">
                <label class="form-control-label">Contact Person: <span class="tx-danger">*</span></label>
                <input class="form-control" type="text" name="contact_person" placeholder="Contact Person Name">
              </div>
            </div>

          </div>

          <div class="form-layout-footer bd pd-20 bd-t-0">
            <input type="submit" value="Submit" class="btn btn-info"/>
          </div>

        </div>
      </div>
    </div>
  </form>

@endsection