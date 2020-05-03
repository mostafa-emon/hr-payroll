@extends('layouts.master')

@section('content')

  <div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
      <a class="breadcrumb-item" href="{{ url('/') }}">Home</a>
      <a class="breadcrumb-item" href="{{ url('/payment-method') }}">Payment Method</a>
      <span class="breadcrumb-item active">Update</span>
    </nav>
  </div>

  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <h4 class="tx-gray-800 mg-b-5">Update Payment Method</h4>
  </div>

  <form action="{{ url('payment-method/update/'.$payment_methods->id) }}" method="POST">
    {{ csrf_field() }}
    <div class="br-pagebody">
      <div class="br-section-wrapper">
        <div class="form-layout form-layout-2">
          <div class="row no-gutters">

            <div class="col-md-12">
              <div class="form-group">
                <label class="form-control-label">Method Name: <span class="tx-danger">*</span></label>
              <input class="form-control" type="text" name="method_name" placeholder="Enter Method Name" value="{{$payment_methods->method_name}}">
              </div>
            </div>

          </div>

          <div class="form-layout-footer bd pd-20 bd-t-0">
            <input type="submit" value="Update" class="btn btn-info pointer"/>
          </div>

        </div>
      </div>
    </div>
  </form>

@endsection