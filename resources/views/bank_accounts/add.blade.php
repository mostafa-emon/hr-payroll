@extends('layouts.master')

@section('content')

  <div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
      <a class="breadcrumb-item" href="{{ url('/') }}">Home</a>
      <a class="breadcrumb-item" href="{{ url('/bank-account') }}">Bank Account</a>
      <span class="breadcrumb-item active">Add</span>
    </nav>
  </div>

  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <h4 class="tx-gray-800 mg-b-5">Add Bank Account</h4>
  </div>

  <form action="{{ url('bank-account/add') }}" method="POST">
    {{ csrf_field() }}
    <div class="br-pagebody">
      <div class="br-section-wrapper">
        <div class="form-layout form-layout-2">
          <div class="row no-gutters">
            
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-control-label mg-b-0-force">Bank Name: <span class="tx-danger">*</span></label>
                <select name="bank_id" class="form-control">
                  <option selected disabled>Select Bank</option>
                      @foreach($banks as $bank)
                          <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                      @endforeach
                </select>
              </div>
            </div>

            <div class="col-md-6 mg-t--1 mg-md-t-0">
              <div class="form-group mg-md-l--1">
                <label class="form-control-label">A/C Number: <span class="tx-danger">*</span></label>
                <input class="form-control" type="text" name="ac_number" placeholder="Enter A/C Number">
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group mg-md-l--1 bd-t-0-force">
                <label class="form-control-label mg-b-0-force">Country: <span class="tx-danger">*</span></label>
                <select id="select2-a" class="form-control" name="ac_type" data-placeholder="A/C Type">
                  <option label="A/C Type"></option>
                  <option selected disabled>Select A/C Type</option>
                  <option value="Current">Current</option>
                  <option value="Savings">Savings</option>
                  <option value="Others">Others</option>
                </select>
              </div>
            </div>

            <div class="col-md-6  mg-t--1 mg-md-t-0">
              <div class="form-group mg-md-l--1 bd-t-0-force">
                <label class="form-control-label mg-b-0-force">Currency Name: <span class="tx-danger">*</span></label>
                <select name="currency_id" class="form-control">
                  <option selected disabled>Select Currency</option>
                      @foreach($currencies as $currency)
                          <option value="{{ $currency->id }}">{{ $currency->full_name }}</option>
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

@endsection