@extends('layouts.master')

@section('content')

  <div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
      <a class="breadcrumb-item" href="{{ url('/') }}">Home</a>
      <a class="breadcrumb-item" href="{{ url('mr') }}">MR</a>
    </nav>
  </div>

  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <div style="float:left">
      <h4 class="tx-gray-800 mg-b-5">Money Receipt</h4>
    </div>
    <div style="float:right">
      <a href="{{ url('mr/add') }}" class="btn btn-primary btn-sm text-white"><i class="fa fa-plus-circle"></i> Add MR</a>
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
      <div class="bd bd-gray-300 rounded table-responsive">
        <table class="table table-striped mg-b-0">
          <thead>
            <tr>
              <th>Sl</th>
              <th>Invoice No</th>
              <th>Site Office</th>
              <th>Customer</th>
              <th>Amount</th>
              <th class="text-center">Payment Method</th>
              <th class="text-center">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($money_receipts as $mr)
            <tr>
              <td>{{$loop->iteration}}</td>
              <td>{{$mr->site_office_prefix}}{{$mr->invoice_no}}{{$mr->site_office_suffix}}</td>
              <td>{{$mr->site_office_name}}</td>
              <td>{{$mr->customer_name}}</td>
              <td>{{$mr->amount}}</td>
              <td class="text-center">
                <span class="badge badge-info">{{ $mr->payment_method }}</span>
              </td>
              <td class="text-center">Action</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

@endsection