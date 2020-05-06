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
      <a href="{{ url('cheque-transactions/add') }}" class="btn btn-primary btn-sm text-white"><i class="fa fa-plus-circle"></i> Add Cheque</a>
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
              <th class="text-center">Action</th>
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
                <td>{{ $cheque_transaction->cheque_name }}</td>
                <td>{{ $cheque_transaction->amount }}</td>
                <td class="text-center">
                  <a class="btn btn-warning btn-sm" href="{{url ('cheque-transactions/update/'.$cheque_transaction->id) }}"><i class= "fa fa-edit"></i> Update </a>
                  <a class="btn btn-danger btn-sm" href="javascript:void(0)" onclick="confirmDelete({{$cheque_transaction->id}})"><i class= "fa fa-minus-circle"></i> Delete</a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script>
    function confirmDelete(id){
      var result = confirm("Are you confirm to delete?");
      if (result) {
          window.location = 'cheque-layouts/delete/'+id
      }
    }
  </script>

@endsection