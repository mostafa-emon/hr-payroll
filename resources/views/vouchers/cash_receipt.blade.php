@extends('layouts.master')

@section('content')

  <div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
      <a class="breadcrumb-item" href="{{ url('/') }}">Home</a>
      <a class="breadcrumb-item" href="{{ url('tr-cash-receipt-voucher') }}">Cash Receipt Voucher</a>
    </nav>
  </div>

  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <div style="float:left">
      <h4 class="tx-gray-800 mg-b-5">Cash Receipt Voucher</h4>
    </div>
  </div>

  <div class="br-pagebody pd-t-15">
    <div class="br-section-wrapper">
      @if(session()->has('message'))
        <div class="alert alert-primary alert-dismissible fade show" role="alert">
          {{ session()->get('message') }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      @endif

      <form action="{{ url('tr-cash-receipt-voucher') }}" method="POST">
        {{ csrf_field() }}
      <div class="row mg-b-30 b">
        <div class="col-md-2">
          <label class="tx-black tx-13">Type</label>
          <select class="form-control" name="trx_type">
              <option value="all" @if($type == 'all') selected @endif>All</option>
              <option value="bank_deposit" @if($type == 'bank_deposit') selected @endif>Bank Deposit</option>
              <option value="receive_payment" @if($type == 'receive_payment') selected @endif>Receive Payment</option>
              <option value="sales_receipt" @if($type == 'sales_receipt') selected @endif>Sales Receipt</option>
          </select>
        </div>

        <div class="col-md-2">
          <label class="tx-black tx-13">From Date</label>
          <input type="text" id="dtpick1" name="from_date" value="{{date('d-m-Y',strtotime($from_date))}}" class="form-control" autocomplete="off"/>
        </div>

        <div class="col-md-2">
          <label class="tx-black tx-13">To Date</label>
          <input type="text" id="dtpick2" name="to_date" value="{{date('d-m-Y',strtotime($to_date))}}" class="form-control" autocomplete="off"/>
        </div>

        <div class="col-md-2">
          <label class="tx-black tx-13">Received From</label>
          <input type="text" name="received_from" value="{{$received_from}}" class="form-control"/>
        </div>

        <div class="col-md-2">
          <label class="tx-black tx-13">Amount</label>
          <input type="text" name="amount" value="{{$amount}}" class="form-control"/>
        </div>

        <div class="col-md-2">
          <label class="tx-black tx-13">Memo</label>
          <input type="text" name="memo" value="{{$memo}}" class="form-control"/>
        </div>

        <div class="col-md-2" style="margin-top:28px">
          <input type="submit" class="btn btn-primary pointer" value="Search"/>
        </div>
        
      </div>
      </form>

      @if(count($data) != 0)
      <div class="bd bd-gray-300 rounded table-responsive">
        <table class="table table-striped mg-b-0">
          <thead>
            <tr>
              <th style="width:5%" class="text-center">Sl</th>
              <th style="width:10%">Trx Date</th>
              <th style="width:10%">Trx Type</th>
              <th style="width:10%">QB Ref No.</th>
              <th style="width:10%">Received From</th>
              <th style="width:10%">Deposit To</th>
              <th style="width:15%">Memo</th>
              <th style="text-align:center; width:10%">Total Amount</th>
              <th style="width:10%;text-align:right;">Status</th>
              <th style="width:10%;text-align:right;">Action</th>
            </tr>
          </thead>
          <tbody>
              @foreach($data as $dt)
              <tr>
                <td style="width:5%">{{$loop->iteration}}</td>
                <td style="width:10%">{{ date('d-M-Y',strtotime($dt['TxnDate']))}}</td>
                <td style="width:10%">{{$dt['TxnType']}}</td>
                <td style="width:10%">{{$dt['DocNumber']}}</td>
                <td style="width:10%">{{$dt['ReceivedFrom']}}</td>
                <td style="width:10%">{{$dt['DepositTo']}}</td>
                <td style="width:15%">{{$dt['Memo']}}</td>
                <td style="text-align:right; width:10%">{!! number_formatting($dt['TotalAmt']) !!}</td>
                <td style="width:10%;text-align:right;">
                  @php $is_printed = is_voucher_printed('Cash-Payment-Voucher',$dt['TxnType'],$dt['Id']); @endphp
                  @if($is_printed > 0)
                    <span class="badge badge-success">Printed</span>
                  @endif
                </td>
                <td style="width:10%;text-align:right;">
                  @php
                    if($dt['TxnType'] == 'Bank Deposit') {$apiType = 'bank_deposit';}
                    else if($dt['TxnType'] == 'Receive Payment') {$apiType = 'received_payment';}
                    else if($dt['TxnType'] == 'Sales Receipt') {$apiType = 'sales_receipt';}

                    if($is_printed > 0) {$printStatus = 'printed';} else{$printStatus = 'new';}
                  @endphp
                  <a href="{{url('crv-voucher-preview/'.$printStatus.'/'.$apiType.'/'.$dt['Id'])}}" class="btn btn-primary btn-sm pointer" style="color:white">Print</a>
                </td>
              </tr>
              @endforeach
          </tbody>
        </table>
      </div>
      @endif
    </div>
  </div>
@endsection