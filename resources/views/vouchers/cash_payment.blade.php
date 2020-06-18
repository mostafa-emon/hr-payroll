@extends('layouts.master')

@section('content')

  <div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
      <a class="breadcrumb-item" href="{{ url('/') }}">Home</a>
      <a class="breadcrumb-item" href="{{ url('voucher-cash-payment') }}">Cash Payment Voucher</a>
    </nav>
  </div>

  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <div style="float:left">
      <h4 class="tx-gray-800 mg-b-5">Cash Payment Voucher</h4>
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

      <form action="{{ url('tr-cash-payment-voucher') }}" method="POST">
        {{ csrf_field() }}
      <div class="row mg-b-30 b">
        <div class="col-md-2">
          <label class="tx-black tx-13">Type</label>
          <select class="form-control" name="trx_type">
              <option value="all" @if($type == 'all') selected @endif>All</option>
              <option value="expense" @if($type == 'expense') selected @endif>Expense</option>
              <option value="pay_bills" @if($type == 'pay_bills') selected @endif>Pay Bills</option>
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
          <label class="tx-black tx-13">Payee Name</label>
          <input type="text" name="payee_name" value="{{$payee_name}}" class="form-control"/>
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
              <th class="text-center">Sl</th>
              <th>Trx Date</th>
              <th>Trx Type</th>
              <th>Ref No.</th>
              <th>Payee Name</th>
              <th>Paid From</th>
              <th>Memo</th>
              <th>Total Amount</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
              @foreach($data as $dt)
              <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{ date('d-M-Y',strtotime($dt['TxnDate']))}}</td>
                <td>{{$dt['TxnType']}}</td>
                <td>{{$dt['DocNumber']}}</td>
                <td>{{$dt['PayeeName']}}</td>
                <td>{{$dt['PaidFrom']}}</td>
                <td>{{$dt['Memo']}}</td>
                <td>{{$dt['TotalAmt']}}</td>
                <td>
                  @php $is_printed = is_voucher_printed('Cash-Payment-Voucher',$dt['TxnType'],$dt['Id']); @endphp
                  @if($is_printed > 0)
                    <span class="badge badge-danger">Printed</span>
                  @else
                    <span class="badge badge-primary">Not Printed</span>
                  @endif
                </td>
                <td>
                  @php
                    if($dt['TxnType'] == 'Pay Bills') {$apiType = 'bill_payment';} else{$apiType = 'expense';}
                    if($is_printed > 0) {$printStatus = 'printed';} else{$printStatus = 'new';}
                  @endphp
                  <a href="{{url('cpv-voucher-preview/'.$printStatus.'/'.$apiType.'/'.$dt['Id'])}}" class="btn btn-success btn-sm pointer" style="color:white">Print</a>
                </td>
              </tr>
              @endforeach
          </tbody>
        </table>
      </div>
      @endif
    </div>
  </div>

  <script>
    function confirmDelete(id){
      var result = confirm("Are you confirm to delete?");
      if (result) {
          window.location = 'printer/delete/'+id
      }
    }
  </script>

@endsection