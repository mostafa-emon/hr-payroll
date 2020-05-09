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
              <td class="text-center">
                <div class="btn-group">
                  <button type="button" class="btn btn-info btn-sm pointer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                  <button type="button" class="btn btn-info btn-sm pointer dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="sr-only"></span>
                  </button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item pointer" href="{{url('mr/draft/'.$mr->id)}}">Print as Draft</a>
                    @if($setting->approval_for_mr == 1 && $mr->status != 1)
                    <a class="dropdown-item pointer" href="javascript:void(0)" onclick="approve({{$mr->id}})">Approve</a>
                    <a class="dropdown-item pointer" href="javascript:void(0)" onclick="approveandprint({{$mr->id}})">Approve & Print</a>
                    @endif

                    @if($setting->approval_for_mr == 1 && $mr->status == 1)
                    <a class="dropdown-item pointer" href="{{url('mr/print/'.$mr->id)}}">Print</a>
                    @endif

                    @if($setting->approval_for_mr != 1)
                    <a class="dropdown-item pointer" href="{{url('mr/print/'.$mr->id)}}">Print</a>
                    @endif

                    <a class="dropdown-item pointer" href="javascript:void(0)" onclick="rejectMR({{$mr->id}})">Reject</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item pointer" href="javascript:void(0)" onclick="voidMR({{$mr->id}})">Void</a>
                  </div>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script>
    function approve(id){
      var result = confirm("Are you confirm to approve?");
      if (result) {
        $.ajax({
            type: 'GET',
            url: '/approve-mr/'+id,
            success:function(data) {
              location.reload();
            }
        });
      }
    }

    function approveandprint(id){
      var result = confirm("Are you confirm to approve?");
      if (result) {
        $.ajax({
            type: 'GET',
            url: '/approve-mr/'+id,
            success:function(data) {
              window.location = "/mr/print/"+id
            }
        });
      }
    }
    
    function rejectMR(id){
      var result = confirm("Are you confirm to reject?");
      if (result) {
        $.ajax({
            type: 'GET',
            url: '/reject-mr/'+id,
            success:function(data) {
              location.reload();
            }
        });
      }
    }

    function voidMR(id){
      var result = confirm("Are you confirm to void?");
      if (result) {
        $.ajax({
            type: 'GET',
            url: '/void-mr/'+id,
            success:function(data) {
              location.reload();
            }
        });
      }
    }
  </script>
@endsection