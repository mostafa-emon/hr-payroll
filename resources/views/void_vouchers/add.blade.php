@extends('layouts.master')

@section('content')

  <div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
      <a class="breadcrumb-item" href="{{ url('/') }}">Home</a>
      <a class="breadcrumb-item" href="{{ url('tr-void-voucher-add') }}">Void Voucher</a>
    </nav>
  </div>

  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <div style="float:left">
      <h4 class="tx-gray-800 mg-b-5">Void Voucher</h4>
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

      <form action="{{ url('tr-void-voucher-add') }}" method="POST">
        {{ csrf_field() }}
      <div class="row mg-b-30 b">
        <div class="col-md-2">
          <label class="tx-black tx-13">Voucher Type</label>
          <select class="form-control" name="voucher_type">
            <option value="Cash-Payment-Voucher">Cash Payment Voucher</option>
            <option value="Cash-Payment-Voucher">Bank Payment Voucher</option>
            <option value="Cash-Receipt-Voucher">Cash Receipt Voucher</option>
            <option value="Bank-Receipt-Voucher">Bank Receipt Voucher</option>
            <option value="Contra-Voucher">Contra Voucher</option>
            <option value="Journal-Voucher">Journal Voucher</option>
          </select>
        </div>

        <div class="col-md-2">
          <label class="tx-black tx-13">From Date</label>
          <input type="text" id="dtpick1" name="from_date" value="" class="form-control" autocomplete="off"/>
        </div>

        <div class="col-md-2">
          <label class="tx-black tx-13">To Date</label>
          <input type="text" id="dtpick2" name="to_date" value="" class="form-control" autocomplete="off"/>
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

      {{--@if(count($data) != 0)--}}
      <div class="bd bd-gray-300 rounded table-responsive">
        <table class="table table-striped mg-b-0">
          <thead>
            <tr>
              <th class="text-center">Sl</th>
              <th>Voucher Type</th>
              <th>Trx Date</th>
              <th>Ref No.</th>
              <th>Payee Name</th>
              <th>Memo</th>
              <th>Total Amount</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
              @foreach($vouchers as $voucher)
              <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{ $voucher->type }}</td>
                <td>{{ $voucher->voucher_date }}</td>
                <td>{{ $voucher->reference_no }}</td>
                <td>{{ $voucher->payee_name }}</td>
                <td>{{ $voucher->memo }}</td>
                <td>{{ $voucher->total_credit }}</td>
                <td>
                    <a class="btn btn-info btn-sm" href="{{url ('voucher-void/'.$voucher->id) }}"> Void </a>
                </td>
              </tr>
              @endforeach
          </tbody>
        </table>
      </div>
      {{--@endif--}}
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