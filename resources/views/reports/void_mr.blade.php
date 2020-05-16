@extends('layouts.master')

@section('content')
  <div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
      <a class="breadcrumb-item" href="{{ url('/') }}">Home</a>
      <a class="breadcrumb-item" href="{{ url('mr') }}">Report</a>
      <span class="breadcrumb-item active">Void MR</span>
    </nav>
  </div>

  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <div style="float:left">
      <h4 class="tx-gray-800 mg-b-5">Void MR</h4>
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

      <div class="text-right mg-b-15">
        <a class="btn btn-info btn-sm pointer" id="excelButton" href="">Excel</a>
        <a class="btn btn-success btn-sm pointer" onclick="printElem()" href="javascript:void(0)">Print</a>
      </div>

      <style>
        table {
          border-collapse: collapse;
        }
        th, td {
          border: 1px solid black;
          font-family:arial;
          font-size:13px;
          padding:5px;
        }
        .no-border{border:none;}
      </style>

      <div id="printArea" style="color:black;">
        <div class="div-padding-30">
          @include('reports.exports.void_mr_table',$money_receipts)
        </div>
      </div>
    </div>
  </div>
@endsection