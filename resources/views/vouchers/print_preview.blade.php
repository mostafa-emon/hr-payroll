@extends('layouts.master')

@section('content')

  <div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
      <a class="breadcrumb-item" href="{{ url('/') }}">Home</a>
      <span class="breadcrumb-item active">Voucher Preview</span>
    </nav>
  </div>

  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <h4 class="tx-gray-800 mg-b-5">Voucher Preview</h4>
  </div>

  <form action="{{ url('voucher/add') }}" method="POST">
    {{ csrf_field() }}
    <input type="hidden" name="type" value="{{$voucher_type}}"/>
    <div class="br-pagebody">
      <div class="br-section-wrapper">
        <div class="form-layout form-layout-2">
          <div class="row no-gutters">

            <div class="col-md-4">
              <div class="form-group">
                <label class="form-control-label">Voucher No: <span class="tx-danger">*</span></label>
                <input class="form-control" type="text" name="voucher_no" placeholder="Enter Voucher No" @if($data['voucher_no'] != "") value="{{$data['voucher_no']}}" @endif>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group mg-md-l--1">
                <label class="form-control-label">Voucher Date: <span class="tx-danger">*</span></label>
                <input class="form-control" type="text" name="voucher_date" placeholder="Enter Voucher Date" @if($data['voucher_date'] != "") value="{{ date('d-m-Y',strtotime($data['voucher_date']))}}" @endif>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group mg-md-l--1">
                <label class="form-control-label">Reference No:</label>
                <input class="form-control" type="text" name="reference_no" placeholder="Enter Reference No" @if($data['reference_no'] != "") value="{{$data['reference_no']}}" @endif>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group bd-t-0-force">
                <label class="form-control-label">Payee Name:</label>
                <input class="form-control" type="text" name="payee_name" placeholder="Enter Payee Name" @if($data['payee_name'] != "") value="{{$data['payee_name']}}" @endif>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group bd-t-0-force mg-md-l--1">
                <label class="form-control-label">Received From:</label>
                <input class="form-control" type="text" name="received_from" placeholder="Enter Received From" @if($data['received_from'] != "") value="{{$data['received_from']}}" @endif>
              </div>
            </div>

            <div class="col-md-4">
                <div class="form-group bd-t-0-force">
                    <label class="form-control-label">Cheque No:</label>
                    <input class="form-control" type="text" name="cheque_no" placeholder="Enter Cheque Number" @if($data['cheque_no'] != "") value="{{$data['cheque_no']}}" @endif>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group bd-t-0-force mg-md-l--1">
                    <label class="form-control-label">Cheque Date:</label>
                    <input class="form-control" type="text" id="cheque_date" name="cheque_date" placeholder="Enter Cheque Date" autocomplete="off" @if($data['cheque_date'] != "") value="{{ date('d-m-Y',strtotime($data['cheque_date']))}}" @endif>
                </div>
            </div>

            <div class="col-md-4">
              <div class="form-group bd-t-0-force mg-md-l--1">
                <label class="form-control-label">Location:</label>
                <input class="form-control" type="text" name="location" placeholder="Enter Location" @if($data['location'] != "") value="{{$data['location']}}" @endif>
              </div>
            </div>
          </div>
        </div>

        <br>
        <input type="hidden" name="transactions" value="{{$data['transactions']}}"/>
        <div class="bd bd-gray-300 rounded table-responsive">
          <table class="table table-striped mg-b-0">
            <thead>
              <tr>
                <th>Account Code & Name</th>
                <th>Memo</th>
                <th>Customer:Job/Project/Name</th>
                <th>Class</th>
                <th>Debit</th>
                <th>Credit</th>
              </tr>
            </thead>
            <tbody>
              @php $total_debit = 0; $total_credit = 0; @endphp
              @foreach($data['transactions'] as $row)
              @php
                if($row['debit'] != ""){
                  $total_debit = $total_debit + $row['debit'];
                }
                if($row['credit'] != ""){
                  $total_credit = $total_credit + $row['credit'];
                }
              @endphp
              <tr>
                <td>{{$row['account_code_name']}}</td>
                <td>{{$row['memo']}}</td>
                <td>{{$row['customer_job_project_name']}}</td>
                <td>{{$row['class']}}</td>
                <td>{{$row['debit']}}</td>
                <td>{{$row['credit']}}</td>
              </tr>
              @endforeach
              <tr>
                <td colspan="4" style="text-align:center;font-weight:bold;">Total</td>
                <td style="font-weight:bold;">{{$total_debit}}</td>
                <td style="font-weight:bold;">{{$total_credit}}</td>
              </tr>
            </tbody>
          </table>
        </div>

        <br>

        <div class="form-layout form-layout-2">
          <div class="row no-gutters">
            <div class="col-md-3">
              <div class="form-group">
                <label class="form-control-label mg-b-0-force">Voucher Format: <span class="tx-danger">*</span></label>
                    <select name="payment_method" class="form-control mg-l--4">
                      <option value="">Default</option>
                      @foreach($voucher_formats as $voucher_format)
                        <option value="{{$voucher_format->id}}">{{$voucher_format->title}}</option>
                      @endforeach
                    </select> 
              </div>
            </div>

            <div class="col-md-9">
              <div class="form-group mg-md-l--1">
                <input type="submit" class="btn btn-success pointer" value="Print" style="width:100px">
              </div>
            </div>
          </div>
        </div>
        
      </div>
    </div>
  </form>

@endsection