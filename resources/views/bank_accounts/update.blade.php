@extends('layouts.master')

@section('content')

  <div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
      <a class="breadcrumb-item" href="{{ url('/') }}">Home</a>
      <a class="breadcrumb-item" href="{{ url('/bank-account') }}">Bank Account</a>
      <span class="breadcrumb-item active">Update</span>
    </nav>
  </div>

  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <h4 class="tx-gray-800 mg-b-5">Update Bank Account</h4>
  </div>

  <form action="{{ url('bank-account/update/'.$bank_accounts->id) }}" method="POST">
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
                          <option value="{{ $bank->id }}" @if($bank_accounts->bank_id == $bank->id) selected @endif>{{ $bank->name }}</option>
                      @endforeach
                </select>
              </div>
            </div>

            <div class="col-md-6 mg-t--1 mg-md-t-0">
              <div class="form-group mg-md-l--1">
                <label class="form-control-label">A/C Number: <span class="tx-danger">*</span></label>
              <input class="form-control" type="text" name="ac_number" placeholder="Enter A/C Number" value="{{$bank_accounts->ac_number}}">
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group mg-md-l--1 bd-t-0-force">
                <label class="form-control-label mg-b-0-force">A/C Type: <span class="tx-danger">*</span></label>
              <select id="select2-a" class="form-control" name="ac_type" data-placeholder="A/C Type">
                  <option selected disabled>Select A/C Type</option>
                  <option value="Current"  @if($bank_accounts->ac_type == "Current") selected @endif>Current</option>
                  <option value="Savings" @if($bank_accounts->ac_type == "Savings") selected @endif>Savings</option>
                  <option value="Others"  @if($bank_accounts->ac_type == "Others") selected @endif>Others</option>
                </select>
              </div>
            </div>

            <div class="col-md-6  mg-t--1 mg-md-t-0">
              <div class="form-group mg-md-l--1 bd-t-0-force">
                <label class="form-control-label mg-b-0-force">Currency Name: <span class="tx-danger">*</span></label>
                <select name="currency_id" class="form-control">
                  <option selected disabled>Select Currency</option>
                      @foreach($currencies as $currency)
                          <option value="{{ $currency->id }}" @if($bank_accounts->currency_id == $currency->id) selected @endif>{{ $currency->full_name }}</option>
                      @endforeach
                </select>
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