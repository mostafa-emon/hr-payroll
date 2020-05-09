@extends('layouts.master')

@section('content')

  <div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
      <a class="breadcrumb-item" href="{{ url('/') }}">Home</a>
      <a class="breadcrumb-item" href="{{ url('/mr') }}">MR</a>
      <span class="breadcrumb-item active">Add</span>
    </nav>
  </div>

  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <h4 class="tx-gray-800 mg-b-5">Add MR</h4>
  </div>

  <form action="{{ url('mr/add') }}" method="POST">
    {{ csrf_field() }}
    <div class="br-pagebody">
      <div class="br-section-wrapper">
        <div class="form-layout form-layout-2">
          <div class="row no-gutters">

            <div class="col-md-3">
              <div class="form-group">
                <label class="form-control-label mg-b-0-force">Site Office: <span class="tx-danger">*</span></label>
                <select name="site_office" class="form-control mg-l--4">
                    <option value="" disabled selected>Select Site Office</option>
                    @foreach($site_offices as $site_office)
                        <option value="{{ $site_office->name }}_{{ $site_office->mr_prefix }}_{{ $site_office->mr_suffix }}_{{ $site_office->mr_start_from }}">{{ $site_office->name }}</option>
                    @endforeach
                </select>
              </div>
            </div>

            <div class="col-md-3 mg-t--1 mg-md-t-0">
              <div class="form-group mg-md-l--1">
                <label class="form-control-label mg-b-0-force">Customer: <span class="tx-danger">*</span></label>
                <select name="customer_name" class="form-control mg-l--4" onchange="datePickerAction()">
                    <option value="" disabled selected>Select Customer</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->name }}">{{ $customer->name }}</option>
                    @endforeach
                </select>
              </div>
            </div>

            <div class="col-md-3 mg-t--1 mg-md-t-0">
              <div class="form-group mg-md-l--1">
                <label class="form-control-label">Amount: <span class="tx-danger">*</span></label>
                <input class="form-control" type="text" name="amount" placeholder="Enter Amount">
              </div>
            </div>

            <div class="col-md-3 mg-t--1 mg-md-t-0">
                <div class="form-group mg-md-l--1">
                  <label class="form-control-label mg-b-0-force">Currency: <span class="tx-danger">*</span></label>
                    <select name="currency" class="form-control mg-l--4">
                        @foreach($currency as $currency)
                            <option value="{{ $currency->fraction_name }}">{{ $currency->fraction_name }}</option>
                        @endforeach
                    </select> 
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group bd-t-0-force">
                    <label class="form-control-label">Bank Name:</label>
                    <input class="form-control" type="text" name="bank_name" placeholder="Enter Bank Name">
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group bd-t-0-force mg-md-l--1">
                    <label class="form-control-label">Cheque No:</label>
                    <input class="form-control" type="text" name="cheque_no" placeholder="Enter Cheque Number">
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group bd-t-0-force mg-md-l--1">
                    <label class="form-control-label">Cheque Date:</label>
                    <input class="form-control" type="text" id="cheque_date" name="cheque_date" placeholder="Enter Cheque Date">
                </div>
            </div>

            <div class="col-md-9">
              <div class="form-group bd-t-0-force">
                <label class="form-control-label">Purpose:</label>
                <input class="form-control" type="text" name="purpose" placeholder="Enter Purpose">
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group bd-t-0-force mg-md-l--1">
                <label class="form-control-label mg-b-0-force">Payment Method: <span class="tx-danger">*</span></label>
                    <select name="payment_method" class="form-control mg-l--4">
                        @foreach($payment_methods as $payment_method)
                            <option value="{{ $payment_method->method_name }}">{{ $payment_method->method_name }}</option>
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
      function datePickerAction() {
        $( "#cheque_date" ).datepicker({ dateFormat: 'dd-mm-yy' });
      } 
  </script>
@endsection