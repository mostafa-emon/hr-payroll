@extends('layouts.master')

@section('content')

  <div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
      <a class="breadcrumb-item" href="{{ url('/') }}">Home</a>
      <a class="breadcrumb-item" href="{{ url('cheque-transactions') }}">Cheque</a>
    </nav>
  </div>

  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <div style="float:left">
      <h4 class="tx-gray-800 mg-b-5">Cheque</h4>
    </div>
    <div style="float:right">
      @if(roles() != "" && in_array(40, json_decode(roles(),false)))
      <a href="{{ url('cheque-transactions/add') }}" class="btn btn-primary btn-sm text-white"><i class="fa fa-plus-circle"></i> Add Cheque</a>
      @endif
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
              <th class="text-center">Sl</th>
              <th>Bank</th>
              <th>Account No.</th>
              <th>Book No.</th>
              <th>Cheque No.</th>
              <th>Payee</th>
              <th>Amount</th>
              <th class="text-center">Status</th>
              @if(roles() != "" && (in_array(41, json_decode(roles(),false)) || in_array(42, json_decode(roles(),false)) || in_array(43, json_decode(roles(),false)) || in_array(44, json_decode(roles(),false))))
              <th class="text-center">Action</th>
              @endif
            </tr>
          </thead>
          <tbody>
            @foreach($cheque_transactions as $cheque_transaction)
              <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $cheque_transaction->bank_name }}</td>
                <td>{{ $cheque_transaction->ac_number }}</td>
                <td>{{ $cheque_transaction->book_no }}</td>
                <td>{{ $cheque_transaction->cheque_no }}</td>
                <td>{{ $cheque_transaction->cheque_name }}</td>
                <td>{{ $cheque_transaction->amount }}</td>
                <td class="text-center">
                  @if($cheque_transaction->status == 0)
                    @if($setting->approval_for_cheque == 1)
                      <span class="badge badge-warning">Pending</span>
                    @else
                      <span class="badge badge-success">Issued</span>
                    @endif
                  @endif
                  @if($cheque_transaction->status == 1)
                    <span class="badge badge-success">Approved</span>
                  @endif
                  @if($cheque_transaction->status == 2)
                    <span class="badge badge-danger">Rejected</span>
                  @endif
                  @if($cheque_transaction->status == 3)
                    <span class="badge badge-danger">Void</span>
                  @endif
                </td>
                <td class="text-center">
                  <div class="btn-group">
                    <button type="button" class="btn btn-info btn-sm pointer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                    <button type="button" class="btn btn-info btn-sm pointer dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <span class="sr-only"></span>
                    </button>
                    <div class="dropdown-menu">
                      @if($setting->approval_for_cheque == 1 && $cheque_transaction->status == 0)
                        @if(roles() != "" && in_array(44, json_decode(roles(),false)))
                          <a class="dropdown-item pointer" href="{{url('cheque/draft/'.$cheque_transaction->id)}}">Print as Draft</a>
                        @endif

                        @if(roles() != "" && in_array(41, json_decode(roles(),false)))
                          <a class="dropdown-item pointer" href="javascript:void(0)" onclick="approve({{$cheque_transaction->id}})">Approve</a>
                          <a class="dropdown-item pointer" href="javascript:void(0)" onclick="approveandprint({{$cheque_transaction->id}})">Approve & Print</a>
                        @endif

                        @if(roles() != "" && in_array(42, json_decode(roles(),false)))
                          <a class="dropdown-item pointer" href="javascript:void(0)" onclick="rejectCheque({{$cheque_transaction->id}})">Reject</a>
                        @endif
                      @endif
                      
                      @if($setting->approval_for_cheque == 0 &&  $cheque_transaction->status == 0)
                        @if(roles() != "" && in_array(44, json_decode(roles(),false)))
                          <a class="dropdown-item pointer" href="{{url('cheque/print/'.$cheque_transaction->id)}}">Print</a>
                        @endif
                      @endif

                      @if($cheque_transaction->status != 0)
                        @if(roles() != "" && in_array(44, json_decode(roles(),false)))
                          <a class="dropdown-item pointer" href="{{url('cheque/print/'.$cheque_transaction->id)}}">Print</a>
                        @endif
                      @endif

                      @if(($setting->approval_for_cheque == 0 || $cheque_transaction->status == 1) && $cheque_transaction->status != 3)
                        @if(roles() != "" && in_array(43, json_decode(roles(),false)))
                          <div class="dropdown-divider"></div>
                          <a class="dropdown-item pointer" href="javascript:void(0)" onclick="voidCheque({{$cheque_transaction->id}})">Void</a>
                        @endif
                      @endif
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
            url: '/approve-cheque/'+id,
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
            url: '/approve-cheque/'+id,
            success:function(data) {
              window.location = "/cheque/print/"+id
            }
        });
      }
    }
    
    function rejectCheque(id){
      var result = confirm("Are you confirm to reject?");
      if (result) {
        $.ajax({
            type: 'GET',
            url: '/reject-cheque/'+id,
            success:function(data) {
              location.reload();
            }
        });
      }
    }

    function voidCheque(id){
      var result = confirm("Are you confirm to void?");
      if (result) {
        $.ajax({
            type: 'GET',
            url: '/void-cheque/'+id,
            success:function(data) {
              location.reload();
            }
        });
      }
    }
  </script>

@endsection