@extends('layouts.master')

@section('content')

  <div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
      <a class="breadcrumb-item" href="{{ url('/') }}">Home</a>
      <a class="breadcrumb-item" href="{{ url('bank-account') }}">Bank Account</a>
    </nav>
  </div>

  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <div style="float:left">
      <h4 class="tx-gray-800 mg-b-5">Bank Accounts</h4>
    </div>
    <div style="float:right">
      <a href="{{ url('bank-account/add') }}" class="btn btn-primary btn-sm text-white"><i class="fa fa-plus-circle"></i> Add Account</a>
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
              <th>Bank Name</th>
              <th>A\C Number</th>
              <th>A\C Type</th>
              <th>Currency</th>
              <th>Update</th>
              <th>Delete</th>
            </tr>
          </thead>
          <tbody>
            @foreach($bankaccounts as $bankaccount)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $bankaccount->bank_name }}</td>
                <td>{{ $bankaccount->ac_number }}</td>
                <td>{{ $bankaccount->ac_type }}</td>
                <td>{{ $bankaccount->currency_name }}</td>
                <td>
                  <a class="btn btn-info btn-sm" href="{{url ('bank-account/update/'.$bankaccount->id) }}"><i class= "fa fa-edit"></i> Update </a>
                  </td>
                  <td>
                  <a class="btn btn-danger btn-sm" href="{{url ('bank-account/delete/'.$bankaccount->id) }}"><i class= "fa fa-minus-circle"></i> Delete</a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

@endsection