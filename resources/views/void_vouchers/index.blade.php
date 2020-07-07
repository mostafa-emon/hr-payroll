@extends('layouts.master')

@section('content')

  <div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
      <a class="breadcrumb-item" href="{{ url('/') }}">Home</a>
      <a class="breadcrumb-item" href="{{ url('tr-void-voucher') }}">Void Voucher</a>
    </nav>
  </div>

  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <div style="float:left">
      <h4 class="tx-gray-800 mg-b-5">Void Voucher</h4>
    </div>
  </div>


  <div class="br-pagebody pd-t-15">
    <div class="br-section-wrapper">

      <form action="{{ url('tr-void-voucher') }}" method="POST">
        {{ csrf_field() }}
      <div class="row mg-b-30 b">
        <div class="col-md-2">
          <label class="tx-black tx-13">From Date</label>
          <input type="text" id="dtpick1" name="from_date" value="{{$from_date}}" class="form-control" autocomplete="off"/>
        </div>

        <div class="col-md-2">
            <label class="tx-black tx-13">To Date</label>
            <input type="text" id="dtpick2" name="to_date" value="{{$to_date}}" class="form-control" autocomplete="off"/>
        </div>

        <div class="col-md-2" style="margin-top:27px">
          <input type="submit" class="btn btn-primary pointer" value="Search"/>
        </div>
      </div>

      @if(session()->has('message'))
        <div class="alert alert-primary alert-dismissible fade show" role="alert">
          {{ session()->get('message') }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      @endif
      <div class="bd bd-gray-300 rounded table-responsive">
        <table class="table table-striped mg-b-0">
          <thead>
            <tr>
              <th>Sl</th>
              <th>Voucher Type</th>
              <th>TRX Date</th>
              <th>QB REF NO.</th>
              <th>Payee Name</th>
              <th>Received From</th>
              <th>Memo</th>
              <th>Total Amount</th>
              <th class="text-center">Status</th>
            </tr>
          </thead>
          <tbody>
            @foreach($vouchers as $voucher)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $voucher->type }}</td>
                <td>{{ $voucher->voucher_date }}</td>
                <td>{{ $voucher->reference_no }}</td>
                <td>{{ $voucher->payee_name }}</td>
                <td>{{ $voucher->received_from }}</td>
                <td>{{ $voucher->memo }}</td>
                <td>{!! number_formatting($voucher->total_credit) !!}</td>
                <td class="text-center">
                  <span class="badge badge-success">Void</span>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div><br>
    </div>
  </div>

  <script>
    function confirmDelete(id){
      var result = confirm("Are you confirm to delete?");
      if (result) {
          window.location = 'voucher/delete/'+id
      }
    }
  </script>

@endsection