@extends('layouts.master')

@section('content')

  <div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
      <a class="breadcrumb-item" href="{{ url('/') }}">Home</a>
      <a class="breadcrumb-item" href="{{ url('/signatory') }}">Signatory</a>
      <span class="breadcrumb-item active">Update</span>
    </nav>
  </div>

  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <h4 class="tx-gray-800 mg-b-5">Update Signatory</h4>
  </div>

  <form action="{{ url('signatory/update/'.$signatories->id) }}" method="POST">
    {{ csrf_field() }}
    <div class="br-pagebody">
      <div class="br-section-wrapper">
        <div class="form-layout form-layout-2">
          <div class="row no-gutters">

            <div class="col-md-12">
              <div class="form-group">
                <label class="form-control-label">Name: <span class="tx-danger">*</span></label>
              <input class="form-control" type="text" name="name" placeholder="Enter Name" value="{{$signatories->name}}">
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <label class="form-control-label">Applied For: <span class="tx-danger">*</span></label>
                <div class="row">
                  <div class="col-md-4">
                    <input type="checkbox" name="cash_payment_voucher" value="1" @if($signatories->cash_payment_voucher == 1) checked @endif>&nbsp;<span>Cash Payment Voucher</span>
                  </div>
                  <div class="col-md-4">
                    <input type="checkbox" name="bank_payment_voucher" value="1" @if($signatories->bank_payment_voucher == 1) checked @endif>&nbsp;<span>Bank Payment Voucher</span>
                  </div>
                  <div class="col-md-4">
                    <input type="checkbox" name="cash_receipt_voucher" value="1" @if($signatories->cash_receipt_voucher == 1) checked @endif>&nbsp;<span>Cash Receipt Voucher</span>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <input type="checkbox" name="bank_receipt_voucher" value="1" @if($signatories->bank_receipt_voucher == 1) checked @endif>&nbsp;<span>Bank Receipt Voucher</span>
                  </div>
                  <div class="col-md-4">
                    <input type="checkbox" name="contra_voucher" value="1" @if($signatories->contra_voucher == 1) checked @endif>&nbsp;<span>Contra Voucher</span>
                  </div>
                  <div class="col-md-4">
                    <input type="checkbox" name="journal_voucher" value="1" @if($signatories->journal_voucher == 1) checked @endif>&nbsp;<span>Journal Voucher</span>
                  </div>
                </div>
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