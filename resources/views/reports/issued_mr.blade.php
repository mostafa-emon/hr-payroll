@extends('layouts.master')

@section('title', $title)

@section('content')
  <div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
      <a class="breadcrumb-item" href="{{ url('/') }}">Home</a>
      <a class="breadcrumb-item" href="{{ url('mr') }}">Report</a>
      <span class="breadcrumb-item active">Issued MR</span>
    </nav>
  </div>

  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <div style="float:left">
      <h4 class="tx-gray-800 mg-b-5">Issued MR</h4>
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
      
      <form action="{{ url('issued-mr') }}" method="POST">
        {{ csrf_field() }}
      <div class="row mg-b-30 b">
        <div class="col-md-2">
          <label class="tx-black tx-13">Site Office</label>
          <select class="form-control" name="site_office">
            <option value="All" @if($site_office == "all") selected @endif>All</option>
            @foreach($site_offices as $site)
              <option value="{{$site->name}}" @if($site_office == $site->name) selected @endif>{{$site->name}}</option>
            @endforeach
          </select>
        </div>

        <div class="col-md-2">
          <label class="tx-black tx-13">Customer</label>
          <select class="form-control" name="customer">
            <option value="All" @if($site_office == "all") selected @endif>All</option>
            @foreach($customers as $cus)
              <option value="{{$cus->name}}" @if($customer == $cus->name) selected @endif>{{$cus->name}}</option>
            @endforeach
          </select>
        </div>

        <div class="col-md-2">
          <label class="tx-black tx-13">From Date</label>
          <input type="text" id="dtpick1" name="from_date" value="{{$from_date}}" class="form-control" autocomplete="off"/>
        </div>

        <div class="col-md-2">
          <label class="tx-black tx-13">To Date</label>
          <input type="text" id="dtpick2" name="to_date" value="{{$to_date}}" class="form-control" autocomplete="off"/>
        </div>

        <div class="col-md-2" style="margin-top:28px">
          <input type="submit" class="btn btn-primary pointer" value="Search"/>
        </div>
        
      </div>
      </form>

      <div class="table-responsive">
        <table 
        @if(roles() != "" && in_array(45, json_decode(roles(),false))) id="datatable1" @endif 
        @if(roles() != "" && !in_array(45, json_decode(roles(),false))) id="datatable2" @endif
        class="table display responsive nowrap">
          <thead>
            <tr>
              <th>Sl</th>
              <th>Date</th>
              <th>Invoice No</th>
              <th>Site Office</th>
              <th>Customer</th>
              <th>Amount</th>
              <th>Pay Method</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($money_receipts as $mr)
            <tr>
              <td>{{$loop->iteration}}</td>
              <td>{{ date('d-m-Y', strtotime($mr->created_at))}}</td>
              <td>{{$mr->site_office_prefix}}{{$mr->invoice_no}}{{$mr->site_office_suffix}}</td>
              <td>{{$mr->site_office_name}}</td>
              <td>{{$mr->customer_name}}</td>
              <td>{{$mr->amount}}</td>
              <td>{{$mr->payment_method}}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
        <br>
      </div>
    </div>
  </div>
@endsection